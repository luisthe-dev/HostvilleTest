<template>
    <div class="authContainer">
        <InfoBox :message='toastMessage.message' :message_type='toastMessage.message_type' :active='toastMessage.active' />
        <form role="form" @submit="createUser">
            <label> First Name </label>
            <input type="text" v-model="userDetails.first_name" />
            <label> Last Name </label>
            <input type="text" v-model="userDetails.last_name" />
            <label> Email Address </label>
            <input type="email" v-model="userDetails.email" />
            <label> Phone </label>
            <input type="text" v-model="userDetails.phone" />
            <label> Password </label>
            <input type="password" v-model="userDetails.password" />
            <button type="submit"> Create User </button>
        </form>
    </div>
</template>

<script>

import { creatNewUser } from '../../assets/apis/adminApi';
import InfoBox from '../../components/InfoBox.vue';

export default {

    data() {
        return {
            userDetails: {
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
                password: ''
            }, toastMessage: {
                message: '',
                message_type: '',
                active: false
            }
        }
    },
    components: { InfoBox },
    methods: {
        async createUser(e) {
            e.preventDefault();

            const responseData = await creatNewUser(this.userDetails);
            if (responseData.status === 0) {
                this.toastMessage.active = true;
                this.toastMessage.message_type = 'error';
                this.toastMessage.message = responseData.message;
                return;
            }
            this.toastMessage.active = true;
            this.toastMessage.message_type = 'success';
            this.toastMessage.message = responseData.message;
            setTimeout(() => this.toastMessage.active = false, 5000);
        }
    }
}
</script>

<style scoped></style>
