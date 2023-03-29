<template>
    <div class="authContainer">
        <InfoBox :message='toastMessage.message' :message_type='toastMessage.message_type' :active='toastMessage.active' />
        <form role="form" @submit="requestLogin">
            <label> Email Address </label>
            <input type="email" v-model="authDetails.email" />
            <label> Password </label>
            <input type="password" v-model="authDetails.password" />
            <button type="submit"> Sign In </button>
        </form>
    </div>
</template>

<script>

import { signInAdmin } from '../../assets/apis/adminApi';
import InfoBox from '../../components/InfoBox.vue';

    export default{
        data() {
            return {
                authDetails : {
                email: '',
                password: ''
            }, toastMessage: {
                message: 'My Message',
                message_type: '',
                active: false
            }}
        },
        methods: {
            async requestLogin (e){
                e.preventDefault();

                const responseData = await signInAdmin(this.authDetails);
                if(responseData.status === 0){
                    this.toastMessage.active = true;
                    this.toastMessage.message_type = 'error';
                    this.toastMessage.message = responseData.message;
                    return;
                }
                this.toastMessage.active = true;
                this.toastMessage.message_type = 'success';
                this.toastMessage.message = responseData.message;
                setTimeout(() => this.$router.push('/dashboard'), 5000);
            }
        },
        components: {InfoBox}
    }
</script>

<style scoped>
    .authContainer{
        display: flex;
        width: 100%;
        height: 100vh;
        align-items: center;
        justify-content: center;
    }
    form{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 30%;
        box-shadow: 0 0 5px 2px #acacac70;
        padding: 50px;
        gap: 6px;
        border-radius: 4px;
    }
    label{
        width: 80%;
        text-align: left;
        font-weight: 28px;
        font-weight: 600;
    }
    input{
        width: 80%;
        border-radius: 8px;
        margin: 4px auto 20px;
        box-shadow: 0 0 5px 2px #acacac90;
        padding: 14px 12px 14px 30px;
        border: 1px solid #acacac;
        font-size: 20px;
    }
    button{
        width: 40%;
        border-radius: 8px;
        background: #126775;
        color: #ffffff;
        font-size: 20px;
        font-weight: 300;
        padding: 12px 12px;
        cursor: pointer;
        border: 1px solid transparent;
    }
    button:hover{
        background: transparent;
        color: #126775;
        border-color: #126775;
    }
</style>
