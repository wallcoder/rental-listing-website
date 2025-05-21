import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
export const useAreaStore = defineStore('area', () => {
    const area = ref([])
    const isLoadingArea = ref(false)

    const getArea = async () => {
        try {
            
            if (area.value.length !== 0) {
                return
            }


            isLoadingArea.value = true

            const response = await axios.get('/top-locations')
            area.value = response.data.data;
            console.log("AREA: ", area.value)

        } catch (err) {
            console.log(err)
        } finally {
            isLoadingArea.value = false
        }
    }

    return { area, isLoadingArea, getArea }
})
