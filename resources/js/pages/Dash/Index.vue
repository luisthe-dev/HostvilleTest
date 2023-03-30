<template>
    <div class="container">
        <div class="sidemenu">
            <h2> HostVille </h2>
            <router-link to="/dashboard">Home</router-link>
            <router-link to="/dashboard/users">Users</router-link>
            <router-link to="/dashboard/programs">Programs</router-link>
        </div>
        <div class="mainContainer">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style scoped>
.container {
    display: flex;
    width: 100%;
    height: 100vh;
    flex-direction: row;
    align-items: flex-start;
    justify-content: center;
}

.container .sidemenu {
    width: 250px;
    background: #f1f1f1;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    height: 100vh;
}

.container .sidemenu h2 {
    align-self: center;
    font-size: 36px;
    margin: 20px auto;
}

.container .sidemenu a {
    font-size: 18px;
    font-weight: 600;
    padding: 18px 0;
    text-align: center;
    color: #ffffff;
    margin: 0 auto;
    width: 100%;
    background: #126785;
}

.container .sidemenu a:hover {
    color: #126785;
    background: #12121242;
}

.container .mainContainer {
    width: calc(100% - 250px);
    max-height: 100vh;
    overflow-y: scroll;
}
</style>
