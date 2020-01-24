<template>
    <div id="master">
        <div class="dashboard container-fluid">
            <div class="column"><strong class="is-size-5 level-left"> SETTINGS</strong></div>
            <hr>
            <div class="tabs is-toggle is-toggle-rounded is-centered">
                <ul>
                    <li class="tablinks is-active" onclick="openTab(event,'cog')">
                        <a>
                            <span class="icon is-small"><i class="fas fa-cog"></i></span>
                            <span>General Settings</span>
                        </a>
                    </li>
                    <li class="tablinks" onclick="openTab(event,'commission')">
                        <a>
                            <span class="icon is-small"><i class="fas fa-hand-holding-usd"></i></span>
                            <span>Commission</span>
                        </a>
                    </li>
                    <li class="tablinks" onclick="openTab(event,'videos')">
                        <a>
                            <span class="icon is-small"><i class="fas fa-film"></i></span>
                            <span>Videos</span>
                        </a>
                    </li>
                    <li class="tablinks" onclick="openTab(event,'documents')">
                        <a>
                            <span class="icon is-small"><i class="fas fa-file-alt"></i></span>
                            <span>Documents</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div id="cog" class="tabcontent" style="display: block">
                <div class="field">
                    <Currency/>
                </div>
                <div class="field">
                    <Country/>
                </div>
                <div class="field">
                    <DataHeader/>
                </div>
            </div>
            <div id="documents" class="tabcontent">
                Members
            </div>
            <div id="videos" class="tabcontent">
                Reports
            </div>
            <div id="commission" class="tabcontent">

                <div class="field">
                    <Commission/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Country from "./Country.vue";
    import Currency from "./Currency.vue";
    import Commission from "./Commission.vue";
    import DataHeader from "./DataHeader.vue";
    import axios from 'axios';

    export default {
        name: "GeneralSetting",
        data() {
            return {
                currency: '',
                country: '',
                countries: [],
                currencies: []
            }
        },
        components: {
            Country,
            Currency,
            Commission,
            DataHeader
        },
        methods: {
            addCurrency() {
                axios.post('api/setting-currency').then()
            }
        },
    }
</script>

<style lang="scss">
    #app {
        font-family: "Avenir", Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
    }

    #nav {
        padding: 30px;

        a {
            font-weight: bold;
            color: #2c3e50;

            &.router-link-exact-active {
                color: #42b983;
            }
        }
    }

    .tabcontent {
        display: none;
    }

    #pictures {
        display: block;
    }

</style>

