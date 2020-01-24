<template>
    <div class="container">


        <div class="print-none">
            <a class="level-right" @click="printme()">
                <i class="fas fa-print"> </i> Print
            </a>
        </div>
        <div class=""><strong class="is-size-4"> Transaction Details</strong></div>
        <hr>


        <div class="columns">
            <table class="table transaction">
                <tbody>
                <tr>
                    <td>TCN</td>
                    <td><strong class="is-size-4">{{this.$route.params.code}}</strong></td>
                </tr>
                <tr>
                    <td>
                        Amount
                    </td>
                    <td>
                        {{calcTotal}} (<strong>{{ currency_sender_id }}</strong>)
                    </td>
                </tr>
                <tr>
                    <td>
                        Commission
                    </td>
                    <td>
                        {{ commission }} <strong>{{ currency_sender_id }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td>0<strong> {{ currency_sender_id }}</strong></td>
                </tr>
                <tr>
                    <td>Total Amount Paid</td>
                    <td>{{ totalAmount + commission}} <strong>{{ currency_sender_id }}</strong></td>
                </tr>
                <tr>
                    <td>Exchange Rate</td>
                    <td>
                        {{ totalAmount }} <strong>{{ currency_sender_id }}</strong> = {{calcTotal * convert_price}}
                        <strong> {{currency_receiver_id}} </strong><br>
                        (1 <strong>{{ currency_sender_id }}</strong> = {{convert_price}} <strong>{{currency_receiver_id}}</strong>)
                    </td>
                </tr>

                <tr class="has-background-grey-lighter">
                    <td>Total Amount Sent</td>
                    <td><strong>{{calcTotal * convert_price }} {{currency_receiver_id}}</strong></td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class="columns">

            <table class="table agent">
                <tbody>
                <tr>
                    <td>ACN<br>
                        <strong>{{transfer.code_agent_sender}}</strong>
                    </td>
                    <td>Agent Name<br>
                        <strong>{{transfer.agent_sender}}</strong>
                    </td>
                </tr>
                <tr>
                    <td>Transaction Status<br>
                        <strong v-if="transfer.status==='blocked'" class="has-text-danger">BLOCK</strong>
                        <strong v-if="transfer.status==='canceled'" class="has-text-danger">CANCEL</strong>
                        <strong v-if="transfer.status==='approved'" class="has-text-success">APPROVED</strong>
                        <strong v-if="transfer.status==='paid'" class="has-text-primary">PAID</strong>
                        <strong v-if="transfer.status==='waiting'" class="has-text-warning">WAITE</strong>
                        <strong v-if="transfer.status==='hold'">HOLD</strong>
                    </td>
                    <td>Transaction Date<br>
                        <strong>{{transfer.date }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>Sending Country<br>
                        <strong> {{transfer.country_agent_sender}}</strong>
                    </td>
                    <td>Receiving Country<br>
                        <strong>{{transfer.city_destination}}</strong>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class=""><strong class="is-size-4"> Sender Details</strong></div>
        <hr>
        <div class="columns">
            <table class="table">
                <tbody>
                <tr>
                    <td>Sender Name</td>
                    <td><strong>{{transfer.name_sender}}</strong></td>
                </tr>
                <tr>
                    <td>Sender Address</td>
                    <td><strong>{{transfer.address_sender}}</strong></td>
                </tr>
                <tr>
                    <td>Sender Phone</td>
                    <td><strong>{{transfer.phone_number_sender}}</strong></td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class=""><strong class="is-size-4"> BENEFICIARY DETAILS</strong></div>
        <hr>
        <div class="columns">
            <table class="table">
                <tbody>
                <tr>
                    <td>Beneficiary Name</td>
                    <td><strong>{{receiver_full_name}}</strong></td>
                </tr>
                <tr>
                    <td>Beneficiary Country</td>
                    <td><strong>{{transfer.city_destination}}</strong></td>
                </tr>
                <tr>
                    <td>Beneficiary Address</td>
                    <td><strong>{{transfer.receiver_address}}</strong></td>
                </tr>
                <tr>
                    <td>Beneficiary Phone</td>
                    <td><strong>{{transfer.phone_number_receiver}}</strong></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="columns" v-if="images!==null">
            <div class="column" v-for="image in images">
                <div class="image is-128x128" style="margin: auto">
                    <a :href="getTransactionPhoto(image.path)" data-lity>
                        <img :src="getTransactionPhoto(image.path)"
                             alt="Image Transaction"
                             style="height: inherit;width: inherit;" class="is-128x128"/>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import SearchTransaction from "./SearchTransaction";

    export default {
        name: "FishTransaction",
        components: {SearchTransaction},
        data() {
            return {
                code: this.$route.params.code,
                transfer: {},
                commission: "",
                amount: "",
                currency_sender_id: "",
                currency_receiver_id: "",
                convert_price: "",
                receiver_money: "",
                images: [],
                receiver_full_name: "",
                receiver_phone_number: "",
            }
        },
        methods: {
            getTransactionPhoto(picture) {
                return "/storage/images/" + picture;
            },
            async details_transaction() {
                console.log(this.$route.params.code);
                await axios.post('/api/show-transaction/' + this.code)
                    .then(response => {
                        this.transfer = response.data.transaction;
                        this.commission = response.data.transaction.commission;
                        this.amount = response.data.transaction.total_money;
                        this.currency_sender_id = response.data.transaction.currency_sender;
                        this.currency_receiver_id = response.data.transaction.currency_receiver;
                        this.convert_price = response.data.transaction.convert_price;
                        this.receiver_money = response.data.transaction.receiver_money;
                        this.images = response.data.images;
                    })
                    .catch(error => console.log(error));
                this.receiver_full_name = this.transfer.receiver_full_name;
                this.receiver_phone_number = this.transfer.phone_number_receiver;
            },
            printme() {
                window.print();
            }
        },
        created() {
            this.details_transaction();
        }, computed: {
            calcTotal: function () {
                return this.amount = this.amount - this.commission;
            },
            totalAmount: function () {
                // const n1 = Number(this.amount);
                // this.commission = n1 * 0.15;
                // this.total_money = (n1 * 0.15) + n1;
                // return this.total_money;
                return this.amount;
            },
        }
    }
</script>

<style scoped>

</style>
