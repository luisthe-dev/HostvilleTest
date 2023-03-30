<template>
    <div class="tablecontainer">
        <h3>Users</h3>
        <table>
            <thead>
                <tr>
                    <th> S/N </th>
                    <th> Full Name </th>
                    <th> Email </th>
                    <th> Phone </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(data, index) in tableData">
                    <td> {{ index + 1 }} </td>
                    <td> {{ `${data.last_name} ${data.first_name}` }} </td>
                    <td> {{ data.email }} </td>
                    <td> {{ data.phone }} </td>
                </tr>
            </tbody>
        </table>
        <div class="navigation">
            <button @click="() => fetchUsers(navData.previousPage)" :class="{ hidden: navData.previousPage === 0 }"> &lt;
                Previous </button>
            <button @click="() => fetchUsers(navData.nextPage)" :class="{ hidden: navData.nextPage === null }"> Next &gt;
            </button>
        </div>
    </div>
</template>

<script>
import { fetchSiteUsers } from '../../assets/apis/adminApi';

export default {
    data() {
        return {
            navData: {
                previousPage: 0,
                currentPage: 0,
                nextPage: null
            },
            tableData: []
        }
    },
    created() {
        this.fetchUsers(1);
    },
    methods: {
        async fetchUsers(pageNumber) {
            if (pageNumber === 0) return;
            const responseData = await fetchSiteUsers(pageNumber);
            console.log(responseData)
            this.tableData = responseData.data.data
            if (pageNumber > this.navData.currentPage) {
                this.navData.previousPage = this.navData.currentPage
                this.navData.currentPage = this.navData.nextPage
            } else {
                this.navData.currentPage = this.navData.previousPage
                this.navData.previousPage = (this.navData.previousPage - 1)
            }
            this.navData.nextPage = responseData.data.next_page_url === null ? null : Number(responseData.data.next_page_url.split('=')[1])
            console.log(responseData)
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

table {
    align-items: center;
    text-align: center;
}

th {
    padding: 8px 0;
    border-bottom: 1px solid #123495;
}

td {
    padding: 18px 0;
    border-bottom: 1px solid #12121254;
}

.navigation {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-end;
    gap: 20px;
}

.navigation button {
    background: #ffffff;
    box-shadow: 0px 0px 3px 2px #acacac65;
    border: 1px solid #347896;
    padding: 6px 12px;
    font-weight: 500;
    font-size: 18px;
    cursor: pointer;
    border-radius: 8px;
}

.navigation button.hidden {
    display: none;
}

.navigation button:hover {
    background: #adadad25;
}
</style>
