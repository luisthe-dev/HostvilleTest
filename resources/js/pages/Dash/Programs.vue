<template>
    <div class="tablecontainer">
        <h3>Programs</h3>
        <div class="programsContainer">
            <div class="program" v-for="program in programsData">
                <img :src="`/storage/${program.program_cover.split('/').splice(1).join('/')}`"
                    :alt="program.program_title" />
                <h3> {{ program.program_title }} </h3>
                <h6> {{ program.program_description }} </h6>
                <p> {{ program.program_duration }} </p>
            </div>
        </div>
        <div class="navigation">
            <button @click="() => fetchUsers(navData.previousPage)" :class="{ hidden: navData.previousPage === 0 }"> &lt;
                Previous </button>
            <button @click="() => fetchUsers(navData.nextPage)" :class="{ hidden: navData.nextPage === null }"> Next &gt;
            </button>
        </div>
    </div>
</template>

<script>
import { fetchSitePrograms } from '../../assets/apis/adminApi';

export default {
    data() {
        return {
            navData: {
                previousPage: 0,
                currentPage: 0,
                nextPage: null
            },
            programsData: []
        }
    },
    created() {
        this.fetchPrograms(1);
    },
    methods: {
        async fetchPrograms(pageNumber) {
            if (pageNumber === 0) return;
            const responseData = await fetchSitePrograms(pageNumber);
            console.log(responseData)
            this.programsData = responseData.data.data
            if (pageNumber > this.navData.currentPage) {
                this.navData.previousPage = this.navData.currentPage
                this.navData.currentPage = this.navData.nextPage
            } else {
                this.navData.currentPage = this.navData.previousPage
                this.navData.previousPage = (this.navData.previousPage - 1)
            }
            this.navData.nextPage = responseData.data.next_page_url === null ? null : Number(responseData.data.next_page_url.split('=')[1])
        }
    }
}
</script>


<style scoped>
.tablecontainer h3 {
    font-size: 48px;
    font-weight: 600;
    margin: 30px 0;
}

.tablecontainer {
    width: 80%;
    display: flex;
    margin: 10px auto;
    flex-direction: column;
    gap: 20px;
}

.programsContainer {
    width: 100%;
    margin: 20px auto;
    padding: 20px 0;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: 3%;
}

.program {
    width: 20%;
    box-shadow: 0 0 5px 2px #adadad70;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 15px;
    margin: 10px 0;
    border-radius: 12px;
}

.program img {
    width: 95%;
    border-radius: 12px;
}

.program h3 {
    font-size: 26px;
    text-align: left;
    width: 100%;
    font-weight: 600;
    margin: 20px 0 5px;
}

.program h6 {
    font-size: 18px;
    font-weight: 500;
    text-align: left;
    width: 100%;
}

.program p {
    font-size: 16px;
    font-weight: 700;
    margin: 20px auto;
}
</style>
