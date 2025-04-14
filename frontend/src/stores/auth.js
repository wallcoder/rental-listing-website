import { defineStore } from "pinia";
import {ref, watch} from 'vue'
import axios from "axios";
import { push } from "notivue";
import { useRoute } from "vue-router";
export const useAuthStore = defineStore('auth', ()=>{
    const user = ref(null)
    const router = useRoute()
    const login = ref({
        email: '',
        password: '',
       
    })

    const signUp = ref({
        name: '',
        email: '',
        password: '',
        conPassword: '',
       
    })

    const reqPassReset = ref({
        email: '',
        timer: null,
        allow: true
    })


    const resetPassword = ref({
       
        password: '',
        conPassword: ''
    })

// HandleResetPassword
const handleResetPassword = async (email, token)=>{
    try{
        const response = await axios.post('/reset-password', {email, token, password: resetPassword.value.password, conPassword: resetPassword.value.conPassword})

        router.push('/user/login')
        push.success(response.data.message)
         resetPassword.value = {
       
            password: '',
            conPassword: ''
        }

    }catch(err){
        console.log(err)
        push.error(err.response.data.message) 
    }

}


// send password request
const handleRequestPasswordReset =async  ()=>{
    try{
        const response = await axios.post('/request-password-reset', {
            email: reqPassReset.value.email
        })



        setTimer()

        push.success(response.data.message)

         reqPassReset.value = {
            email: '',
            timer: null,
            allow: true
        }
    }catch(err){
        console.log(err)
        push.error(err.response.data.message) 
    }
}

// Request password reset timer
    const setTimer= ()=>{
        reqPassReset.value.timer = 30
        reqPassReset.value.isSent = false
        const interval = setInterval(() => {
            if (reqPassReset.value.timer > 0) {
                reqPassReset.value.timer--
            } else {
                clearInterval(interval)
            }
        }, 1000)
    }
// watches password reset enau
    watch(()=>reqPassReset.value.timer, (newVal)=>{
        if(newVal === 0){
            reqPassReset.value.isSent = true

        }
    })

    // LOGIN
    const handleLogin = async ()=>{
        try{
            const response = await axios.post('/login', {
                email: login.value.email,
                password: login.value.password,
            })

            localStorage.setItem('token', JSON.stringify(response.data.token))
            router.push('/')
            getUserDetails()
            push.success(response.data.message)
            login.value = {
                email: '',
                password: '',
               
            }

        }catch(err){
            console.log(err)
            if(err.response.data){

          
            push.error(err.response.data.message) 
        }
        }
      

    }

    // SIGN UP

    const handleSignUp = async ()=>{
        try{
            const response = await axios.post('/signup', {
                email: signUp.value.email,
                name: signUp.value.name,
                password: signUp.value.password,
                conPassword: signUp.value.conPassword,
            })

            localStorage.setItem('token', JSON.stringify(response.data.token))
            router.push('/')
            getUserDetails()
            signUp.value = {
                name: '',
                email: '',
                password: '',
                conPassword: '',
               
            }
            
            push.success(response.data.message)



        }catch(err){
            console.log(err)
            push.error(err.response.data.message) 
        }
    }

    // USER DETAIL
    const getUserDetails = async()=>{
        try{
            const response = await axios.post('/user')
            localStorage.setItem('user', response.data.data)

        }catch(err){
            console.log(err)
            push.error(err.response.data.message) 
        }
    }

    
    return {login, signUp, user, reqPassReset, resetPassword,
        
        
        handleLogin, handleSignUp, setTimer, handleResetPassword, handleRequestPasswordReset}

})