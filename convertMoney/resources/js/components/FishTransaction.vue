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
                        {{calcTotal}} ({{ currency_sender_id }})
                    </td>
                </tr>
                <tr>
                    <td>
                        Commission
                    </td>
                    <td>
                        {{ commission }} {{ currency_sender_id }}
                    </td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td>0 {{ currency_sender_id }}</td>
                </tr>
                <tr>
                    <td>Total Amount Paid</td>
                    <td>{{ totalAmount }} {{ currency_sender_id }}</td>
                </tr>
                <tr>
                    <td>Exchange Rate</td>
                    <td>20 {{ currency_sender_id }} = 100 {{currency_receiver_id}} <br>(1 {{ currency_sender_id }} = {{convert_price}} {{currency_receiver_id}})</td>
                </tr>

                <tr class="has-background-grey-lighter">
                    <td>Total Amount Send</td>
                    <td> 100  {{currency_receiver_id}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class="columns">

            <table class="table agent">
                <tbody>
                <tr>
                    <td>PCN<br>MNALKFO32</td>
                    <td>Agent Name<br>
                        MUHAMMED RAID CUMA
                    </td>
                </tr>
                <tr>
                    <td>Transaction Status<br>
                        <strong class="has-text-success">APPROVED</strong>
                    </td>
                    <td>Transaction Date<br>
                        11/1/2020
                    </td>
                </tr>
                <tr>
                    <td>Sending Country<br>
                        Turkey
                    </td>
                    <td>Receiving Country<br>
                        IRAQ
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
                    <td>Muhammed</td>
                </tr>
                <tr>
                    <td>Sender Country</td>
                    <td>Turkey</td>
                </tr>
                <tr>
                    <td>Sender Address</td>
                    <td>Turkey Istanbul Esen Sher mh D:1/3</td>
                </tr>
                <tr>
                    <td>Sender Phone</td>
                    <td>+90 534 773 95 76</td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class=""><strong class="is-size-4"> BENEFICIARY Details</strong></div>
        <hr>
        <div class="columns">
            <table class="table">
                <tbody>
                <tr>
                    <td>Beneficiary Name</td>
                    <td>EYMEN</td>
                </tr>
                <tr>
                    <td>Beneficiary Country</td>
                    <td>IRAQ</td>
                </tr>
                <tr>
                    <td>Beneficiary Address</td>
                    <td>IRAQ BAGHDAD SUL H:1/3</td>
                </tr>
                <tr>
                    <td>Beneficiary Phone</td>
                    <td>+90 534 773 95 76</td>
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

    export default {
        name: "FishTransaction",
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
                return "/images/" + picture;
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
                const n1 = Number(this.amount);
                this.commission = n1 * 0.15;
                this.total_money = n1 * 0.15 + n1;
                return this.total_money;
            },
        }
    }
</script>

<style scoped>

</style>
