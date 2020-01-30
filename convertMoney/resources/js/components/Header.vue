<template>
    <div class="container is-fluid">

        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <div class=" image is-64x64">
                    <img :src="pathPhoto()"/>
                </div>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
                   data-target="navbarBasicExample">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar-item">
                        Home
                    </a>

                    <a class="navbar-item">
                        Documentation
                    </a>

                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            More
                        </a>

                        <div class="navbar-dropdown">
                            <a class="navbar-item">
                                About
                            </a>
                            <a class="navbar-item">
                                Jobs
                            </a>
                            <a class="navbar-item">
                                Contact
                            </a>
                            <hr class="navbar-divider">
                            <a class="navbar-item">
                                Report an issue
                            </a>
                        </div>
                    </div>
                </div>

                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="columns">
                            <div class="column">
                                <div class="buttons">
                                    <button class="button is-primary" @click="logout">
                                        <strong>Log Out</strong>
                                    </button>

                                </div>
                            </div>


                            <div class="column">
                                <a class="button" @click="back">
                                    <i class="fas fa-arrow-left is-size-3"></i> &nbsp; &nbsp;
                                    <strong>back</strong>
                                </a>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </nav>
        <div class="media ">
            <figure class="logo media-left" style="  display: none;">
                <div class="image is-128x128">
                    <img :src="pathPhoto()"/>

                </div>
            </figure>
            <div class="media-content logo-container" style="  display: none;">
                <div class="content">
                    <p class="title">{{company_name}}</p>
                    <p class="subtitle">{{description}} </p>
                </div>
            </div>
        </div>
        <br>
    </div>
</template>

<script>
    import axios from 'axios';
    import Gate from "../Gate";

    export default {
        data() {
            return {
                headerData: {},
                logo: "",
                company_name: "",
                description: "",

            }
        }, methods: {
            select_permission() {
                axios.get('api/select-permission').then(response => {
                    permissions = response.data;
                    console.log(permissions);
                    console.log('header');
                });
                return permissions;
            },
            selectDataHerder() {
                axios.get('/api/setting-header').then(response => {
                    this.headerData = response.data;
                    this.company_name = response.data.company_name;
                    this.description = response.data.description;

                })
            },
            pathPhoto() {
                return (this.logo.length > 200) ? this.logo : "../img/profile/" + this.headerData.logo;
            },
            back() {
                this.$router.go(-1)
            },
            logout() {
                axios.post('/logout').then(window.location = '/login');
            }
        },
        created() {
            Fire.$on('isAllow', () => {
                this.select_permission();
            });
            Fire.$emit('isAllow');
            this.selectDataHerder();
        },


    }
</script>

<style scoped>

</style>
