import { defineStore } from "pinia";
import {ref, watch} from 'vue'
import axios from "axios";
import { push } from "notivue";
import { useRouter } from "vue-router";
export const useAuthStore = defineStore('auth', ()=>{
    const user = ref(null)
    const isLoggedin = ref()
    const isLoadingLogin = ref(false)
    const isLoadingSignup = ref(false)
    const router = useRouter()
    const login = ref({
        email: '',
        password: '',
       
    })

    const signUp = ref({
        name: '',
        email: '',
        password: '',
        confirm_password: '',
       
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
            isLoadingLogin.value = true
            const response = await axios.post('/login', {
                email: login.value.email,
                password: login.value.password,
            })

            
            localStorage.setItem('user', JSON.stringify(response.data.data))
            user.value = response.data.data
            localStorage.setItem('message', response.data.message)
            window.location.replace('/')
            isLoggedin.value = true;
            
            login.value = {
                email: '',
                password: '',
               
            }

        }catch(err){
            console.log(err)
            if(err.response.data){

          
            push.error(err.response.data.message) 
        }
        }finally{
            isLoadingLogin.value = false
        }
      

    }

    // SIGN UP

    const handleSignUp = async ()=>{
        try{
            isLoadingSignup.value = true
            const response = await axios.post('/register', {
                email: signUp.value.email,
                name: signUp.value.name,
                password: signUp.value.password,
                confirm_password: signUp.value.confirm_password,
            })

            isLoggedin.value = true;
            
            localStorage.setItem('user', JSON.stringify(response.data.data))
            user.value = response.data.data
            localStorage.setItem('message', response.data.message)
            window.location.replace('/')
            
            signUp.value = {
                name: '',
                email: '',
                password: '',
                conPassword: '',
               
            }
            
            push.success(response.data.message)



        }catch(err){
            console.log(err)
            if(err.response.data){
                const message = err.response.data.message
                if(message.email){
                    push.error(err.response.data.message['email'][0]) 
                    console.log("Error: ", err.response.data.message['email'])
                }else if(message.password){
                    push.error(err.response.data.message['password'][0]) 
                    console.log("Error: ", err.response.data.message['password'])
                }else if(message.confirm_password){
                    push.error(err.response.data.message['confirm_password'][0]) 
                    console.log("Error: ", err.response.data.message['confirm_password'])
                }
                
            }
            // push.error(err.response.data.message) 
        }finally{
            isLoadingSignup.value = false
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

    const checkToken  = async(init=false)=>{
        try{
            const response = await axios.get('/me')
            localStorage.setItem('user', JSON.stringify(response.data.data))
            isLoggedin.value = true
            user.value = JSON.parse(localStorage.getItem('user'))
            console.log("user: ", user.value)
            
        }catch(err){
            // console.log(err)
            if(err.response.status == 401){
                if(init)
                    return
                // push.error(`${err.response.data.message}. You are logged out`)
                logout()
            }
           
        }
    }

    const logout = async()=>{
        try{
            const response = await axios.post('/logout')
            localStorage.removeItem('user')
            user.value = null
            localStorage.setItem('message', response.data.message)
            
            isLoggedin.value = false
           
            window.location.replace('/')
        }catch(err){
            console.log(err)
        }
    }
    
    return {login, signUp, user, reqPassReset, resetPassword, isLoggedin, isLoadingLogin, isLoadingSignup,
        
        logout,
        handleLogin, handleSignUp, setTimer, handleResetPassword, handleRequestPasswordReset, checkToken}

})