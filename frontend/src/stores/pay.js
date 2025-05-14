import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
import { push } from "notivue";
import { useUserStore } from "./user";


export const usePayStore = defineStore('pay', () => {
    const {getUserPosts} = useUserStore()
    const isLoadingPay = ref(false)
    const handlePayment = async (amount = 500) => {
        try {



            isLoadingPay.value = true


            const orderRes = await axios.post(`/create-order`, {
                amount: amount * 100,
            })



            const orderData = orderRes.data

            const options = {
                key: import.meta.env.VITE_RAZORPAY_KEY_ID,
                amount: orderData.amount,
                currency: "INR",
                name: "inlist",
                description: "Accessory Purchase",
                theme: { color: '#F50761'},
               

                order_id: orderData.id,
                handler: async function (response) {
                    try {
                        const verifyRes = await axios.post(`/verify-payment`, {
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_signature: response.razorpay_signature,

                        })

                        if (verifyRes.data.success) {
                            push.success("Payment successful!")
                            const storeResponse = await axios.post('/store-info', {
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_payment_id: response.razorpay_payment_id,

                            })

                        } else {
                            push.error("Payment verification failed.")
                        }
                    } catch (error) {
                        push.error("An error occurred during verification.")
                        console.error(error)
                    }
                },
                prefill: {



                },
                
            }

            const rzp = new Razorpay(options)
            rzp.open()
        } catch (error) {
            alert("Unable to initiate payment.")
            console.error(error)
        }finally{
            isLoadingPay.value = false
        }
    }



    const payBoost = async (amount = 500, id) => {
        try {



            isLoadingPay.value = true


            const orderRes = await axios.post(`/create-order`, {
                amount: amount * 100,
            })



            const orderData = orderRes.data

            const options = {
                key: import.meta.env.VITE_RAZORPAY_KEY_ID,
                amount: orderData.amount,
                currency: "INR",
                name: "inlist",
                description: "Accessory Purchase",
                theme: { color: '#F50761'},
               

                order_id: orderData.id,
                handler: async function (response) {
                    try {
                        const verifyRes = await axios.post(`/verify-payment`, {
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_signature: response.razorpay_signature,

                        })

                        if (verifyRes.data.success) {
                            push.success("Payment successful!")
                            const storeResponse = await axios.post('/store-payment', {
                                order_id: response.razorpay_order_id,
                                ref_id: response.razorpay_payment_id,
                                amount: orderData.amount,
                                purpose: 'listing_feature',
                                post_id: id,
                                status: 'success',
                                currency: 'INR'
                            })

                            const boostResponse = await axios.put(`/post/boost/${id}`)
                            getUserPosts(true)

                        } else {
                            push.error("Payment verification failed.")
                        }
                    } catch (error) {
                        push.error("An error occurred during verification.")
                        console.error(error)
                    }
                },
                prefill: {



                },
                
            }

            const rzp = new Razorpay(options)
            rzp.open()
        } catch (error) {
            alert("Unable to initiate payment.")
            console.error(error)
        }finally{
            isLoadingPay.value = false
        }
    }


    const paySub = async (amount = 500) => {
        try {



            isLoadingPay.value = true


            const orderRes = await axios.post(`/create-order`, {
                amount: amount * 100,
            })



            const orderData = orderRes.data

            const options = {
                key: import.meta.env.VITE_RAZORPAY_KEY_ID,
                amount: orderData.amount,
                currency: "INR",
                name: "inlist",
                description: "Accessory Purchase",
                theme: { color: '#F50761'},
               

                order_id: orderData.id,
                handler: async function (response) {
                    try {
                        const verifyRes = await axios.post(`/verify-payment`, {
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_signature: response.razorpay_signature,

                        })

                        if (verifyRes.data.success) {
                            push.success("Payment successful!")
                            const storeResponse = await axios.post('/store-info', {
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_payment_id: response.razorpay_payment_id,

                            })

                        } else {
                            push.error("Payment verification failed.")
                        }
                    } catch (error) {
                        push.error("An error occurred during verification.")
                        console.error(error)
                    }
                },
                prefill: {



                },
                
            }

            const rzp = new Razorpay(options)
            rzp.open()
        } catch (error) {
            alert("Unable to initiate payment.")
            console.error(error)
        }finally{
            isLoadingPay.value = false
        }
    }

    return {handlePayment, isLoadingPay, payBoost, paySub}
})