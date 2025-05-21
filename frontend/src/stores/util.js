import { defineStore } from "pinia";
import { ref } from "vue";

export const useUtilStore = defineStore('util', () => {


    // progress loader
    const width = ref(0);
    const isVisible = ref(false);
    let interval = null;
    const isOpen = ref(true);


    function timeAgo(timestamp) {
        const nowUTC = new Date().getTime(); // local time in ms
        const postedUTC = new Date(timestamp).getTime(); // UTC timestamp in ms
        const diffInSeconds = Math.floor((nowUTC - postedUTC) / 1000);

        const secondsInMinute = 60;
        const secondsInHour = 3600;
        const secondsInDay = 86400;
        const secondsInWeek = 604800;
        const secondsInMonth = 2629800; // ~30.44 days
        const secondsInYear = 31557600; // ~365.25 days

        if (diffInSeconds < secondsInMinute) {
            return 'Just Now';
        } else if (diffInSeconds < secondsInHour) {
            const mins = Math.floor(diffInSeconds / secondsInMinute);
            return `${mins} minute${mins !== 1 ? 's' : ''} ago`;
        } else if (diffInSeconds < secondsInDay) {
            const hours = Math.floor(diffInSeconds / secondsInHour);
            return `${hours} hour${hours !== 1 ? 's' : ''} ago`;
        } else if (diffInSeconds < secondsInWeek) {
            const days = Math.floor(diffInSeconds / secondsInDay);
            return `${days} day${days !== 1 ? 's' : ''} ago`;
        } else if (diffInSeconds < secondsInMonth) {
            const weeks = Math.floor(diffInSeconds / secondsInWeek);
            return `${weeks} week${weeks !== 1 ? 's' : ''} ago`;
        } else if (diffInSeconds < secondsInYear) {
            const months = Math.floor(diffInSeconds / secondsInMonth);
            return `${months} month${months !== 1 ? 's' : ''} ago`;
        } else {
            const years = Math.floor(diffInSeconds / secondsInYear);
            return `${years} year${years !== 1 ? 's' : ''} ago`;
        }
    }

    const startLoading = () => {

        isVisible.value = true;
        width.value = 0;


        interval = setInterval(() => {
            if (width.value < 80) {
                width.value += Math.random() * 5;
            }
        }, 300);
    };

    const finishLoading = () => {
        clearInterval(interval);
        width.value = 100;


        setTimeout(() => {
            isVisible.value = false;
            width.value = 0;
        }, 300);
    };

    const isOpenFilterSidebar = ref(false);
    const isBrowsePage = ref(false);
    const toggleFilterSidebar = () => {
        isOpenFilterSidebar.value = !isOpenFilterSidebar.value
    }
    return { isOpenFilterSidebar, startLoading, finishLoading, isOpen, isVisible, width, isBrowsePage, toggleFilterSidebar, timeAgo }
})