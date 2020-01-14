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
                <div class="field">
                    <div class="columns">

                        <div class="column is-2">
                            <label>
                                Local Currency
                            </label>
                        </div>
                        <div class="select column" >
                            <select name="currency" class="form-control" required v-model="currency_current">
                                <option value="USD">US Dollar (USD) $</option>
                                <option value="TRY"> Turkish Lira (TRY) ₺</option>
                                <option value="EUR">Euro (EUR) €</option>
<!--                                <option value="د.ك">Kuwaiti Dinar (KWD) د.ك</option>-->
<!--                                <option value="د.ب">Bahraini Dinar (BHD) د.ب</option>-->
<!--                                <option value="﷼">Omani Rial (OMR) ﷼</option>-->
                                <option value="GBP">British Pound (GBP) £</option>
                                <option value="CHF">Swiss Franc (CHF) CHF</option>
<!--                                <option value="ل.د">Libyan Dinar (LYD) ل.د</option>-->
<!--                                <option value="B$">Bruneian Dollar (BND) B$</option>-->
<!--                                <option value="S$">Singapore Dollar (SGD) S$</option>-->
                                <option value="AUD"> Australian Dollar (AUD) AU$</option>
<!--                                <option value="AU$"> Malaysian Ringgit (MYR) AU$</option>-->
                            </select>
                        </div>

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
                commission_admin: "",
                currency_current: "",
            }
        },
        methods: {
            getCommission() {
                axios.get('api/setting/commission_currency').then((data) => this.commission_currency = data.data);
                axios.get('api/setting/commission_admin').then((data) => this.commission_admin = data.data);
                axios.get('api/setting/current_currency').then((data) => this.currency_current = data.data);
            },
            updateCommission() {
                axios.patch('api/setting-commission', {
                    commission_admin: this.commission_admin,
                    commission_currency: this.commission_currency,
                    current_currency:this.currency_current
                }).then(
                    swal.fire("Finances !", "DATA Updated!", "success")
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
