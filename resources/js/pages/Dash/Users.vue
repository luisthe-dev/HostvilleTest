<template>
    <div class="tablecontainer">
        <h3>Users</h3>
        <RouterLink to="/dashboard/users/add"> &plus; Create User </RouterLink>
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
            this.tableData = responseData.data.data
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

.tablecontainer a {
    font-weight: 300;
    font-size: 24px;
    background: #5676cd;
    color: #ffffff;
    border-radius: 8px;
    padding: 8px 12px;
    display: inline-block;
    width: 150px;
    text-align: center;
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
</style>
