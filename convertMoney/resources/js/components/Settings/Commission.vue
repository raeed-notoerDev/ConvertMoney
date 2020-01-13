<template>

    <div class="card">
        <header class="card-header">
            <strong> COMMISSIONS</strong>
        </header>
        <form @submit.prevent="updateCommission">
            <div class="card-content">


                <div class="field">
                    <div class="columns">

                        <div class="column is-2">
                            <label>
                                Commission Admin
                            </label>
                        </div>
                        <div class="column">
                            <input type="text" class="input" v-model="commission_admin">
                        </div>
                        <div class="column"><strong>%</strong></div>
                        <div class="column"></div>

                    </div>
                </div>
                <div class="field">
                    <div class="columns">

                        <div class="column is-2">
                            <label>
                                Commission Currency
                            </label>
                        </div>
                        <div class="column">
                            <input type="text" class="input" v-model="commission_currency">
                        </div>
                        <div class="column "><strong>%</strong></div>
                        <div class="column "></div>

                    </div>
                </div>
            </div>
            <footer class="card-footer">
                <div class="columns">
                    <div class="column">
                        <button type="submit" class="button is-primary">Update</button>
                    </div>

                </div>

            </footer>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Commission",
        data() {
            return {
                commission_currency: "",
                commission_admin: ""
            }
        },
        methods: {
            getCommission() {
                axios.get('api/setting/commission_currency').then((data) => this.commission_currency = data.data);
                axios.get('api/setting/commission_admin').then((data) => this.commission_admin = data.data);
            },
            updateCommission() {
                axios.patch('api/setting-commission', {
                    commission_admin: this.commission_admin,
                    commission_currency: this.commission_currency
                }).then(
                    swal.fire("Commission!", "Commission Updated!", "success")
                ).catch();
            }
        },
        created() {
            this.getCommission();
        }
    }
</script>

<style scoped>

</style>
