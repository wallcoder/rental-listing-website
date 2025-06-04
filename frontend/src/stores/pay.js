import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
import { push } from "notivue";
import { useUserStore } from "./user";
import { useRouter } from "vue-router";

export const usePayStore = defineStore('pay', () => {
    const { getUserPosts } = useUserStore()
    const router = useRouter()
    const isLoadingPay = ref(false)
    const handlePayment = async (
        amount = 500,
        subMerchantAccountId,
        postId,
        checkinDate,
        checkoutDate,
        fullName,
        email,
        phone
    ) => {
        try {
            // Basic frontend validation
            if (!fullName) {
                push.error("Please enter a valid full name.");
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email || !emailRegex.test(email)) {
                push.error("Please enter a valid email address.");
                return;
            }

            // Simple phone validation (adjust regex for your country if needed)
            const phoneRegex = /^[0-9]{10,15}$/;
            if (!phone || !phoneRegex.test(phone)) {
                push.error("Please enter a valid phone number.");
                return;
            }

            isLoadingPay.value = true;
            console.log("parameters: ", amount, subMerchantAccountId, postId, checkinDate, checkoutDate);

            // Step 1: Check booking conflict first
            const conflictRes = await axios.get('/check-booking', {
                params: {
                    post_id: postId,
                    checkin_date: checkinDate,
                    checkout_date: checkoutDate,
                }
            });

            if (!conflictRes.data.success) {
                push.error(conflictRes.data.message || "Booking conflict detected");
                return;  // Stop here, no payment proceed
            }

            const orderRes = await axios.post(`/booking/create-order`, {
                amount: amount * 100,
                sub_account: subMerchantAccountId,
            });

            const orderData = orderRes.data;

            const options = {
                key: import.meta.env.VITE_RAZORPAY_KEY_ID,
                amount: orderData.amount,
                currency: "INR",
                name: "Inlist",
                description: "Booking",
                order_id: orderData.id,
                theme: { color: "#F50761" },

                handler: async function (response) {
                    try {
                        const verifyRes = await axios.post(`/booking/verify-payment`, {
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_signature: response.razorpay_signature,
                        });

                        if (verifyRes.data.success) {
                            // Insert booking
                            const insertRes = await axios.post(`/booking/insert`, {
                                post_id: postId,
                                full_name: fullName,
                                email: email,
                                phone: phone,
                                checkin_date: checkinDate,
                                checkout_date: checkoutDate,
                                total: amount,
                                status: 'active',
                            });

                            if (insertRes.data.success) {
                                const bookingId = insertRes?.data?.data?.id;
                                console.log('booking id: ', bookingId)

                                // Store payment with booking_id and payment info
                                await axios.post('/booking/store-payment', {
                                    amount: amount,
                                    currency: 'INR',
                                    signature: response.razorpay_signature,
                                    ref_id: verifyRes.data.payment_details.id,
                                    order_id: response.razorpay_order_id,
                                    status: verifyRes.data.payment_details.status === 'captured' ? 'success' : 'failed',
                                    booking_id: bookingId,
                                    payment_method: verifyRes.data.payment_method,
                                });

                                push.success("Booking successful and payment completed.");
                            } else {
                                push.error("Payment succeeded but booking failed.");
                            }
                        } else {
                            push.error("Payment verification failed.");
                        }
                    } catch (error) {
                        push.error("An error occurred during verification or booking.");
                        console.error(error);
                    }
                },



                prefill: {
                    name: fullName,
                    email: email,
                    contact: phone,
                },
            };

            const rzp = new Razorpay(options);
            rzp.open();

        } catch (error) {
            if (error.response && error.response.status === 409) {
            push.error(error.response.data.message || "Booking conflict detected");
            } else {
                alert("Unable to initiate payment.");
                console.error(error);
            }
        } finally {
            isLoadingPay.value = false;
        }
    };







    return { handlePayment, isLoadingPay, }
})