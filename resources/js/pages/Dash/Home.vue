<template>
    <div class="blocks">
        <InfoBox :message='toastMessage.message' :message_type='toastMessage.message_type' :active='toastMessage.active' />
        <div class="block">
            <label> {{ users }} </label>
            <p> Users </p>
        </div>
        <div class="block">
            <label> {{ programs }} </label>
            <p> Programs </p>
        </div>
        <div class="block">
            <label> {{ courses }} </label>
            <p> Courses </p>
        </div>
    </div>
</template>

<script>
import InfoBox from '../../components/InfoBox.vue';
import { fetchSiteStats } from '../../assets/apis/adminApi';
export default {
    components: { InfoBox },
    data() {
        return {
            users: 0,
            programs: 0,
            courses: 0, toastMessage: {
                message: '',
                message_type: '',
                active: false
            }
        }
    },
    created() {
        this.fetchStats();
    },
    methods: {
        async fetchStats() {
            const responseData = await fetchSiteStats();
            if (responseData.status === 1) {
                this.users = responseData.data.Users;
                this.programs = responseData.data.Programs;
                this.courses = responseData.data.Courses;
            } else {
                this.toastMessage.active = true;
                this.toastMessage.message_type = 'error';
                this.toastMessage.message = 'Error Connecting With Server';
            }
        }
    }
}
</script>

<style scoped>
.blocks {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-evenly;
    width: 100%;
    padding: 30px 0;
}

.block {
    width: 30%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 30px 0;
    height: 150px;
    box-shadow: 0 0 6px 3px #acacac75;
    border-radius: 8px;
}

label {
    font-size: 64px;
    font-weight: 700;
}

p {
    font-size: 28px;
    font-weight: 400;
}
</style>
