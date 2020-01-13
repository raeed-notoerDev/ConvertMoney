<template>
    <div class="TransferMoney container is-fluid">
        <form @submit.prevent="receiverMoney">
            <div class="columns">
                <div class="column"></div>
                <div class="column"> <strong class="is-size-2">Code Transaction</strong></div>
                <div class="column">
                    <span class="strong is-size-2">: {{this.$route.params.code}}</span>
                </div>
                <div class="column"></div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="columns">
                        <div class=" column is-8">
                            <p class="has-text-left">Amount ({{ currency_sender_id }})</p>
                            <input
                                type="number"
                                placeholder="transaction"
                                class=" input number "
                                v-model="calcTotal"
                                disabled
                            />
                        </div>
                        <div class=" column is-3">
                            <p class="has-text-left">Sending Currency</p>
                            <div class="select is-medium">
                                <select v-model="currency_sender_id" @change="convert" disabled>
                                    <option
                                        v-for="currency in currencies"
                                        :key="currency.name"
                                        :value="currency.name"
                                    >
                                        {{ currency.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class=" column is-8">
                            <p class="has-text-left">
                                Receiver Amount ({{ currency_receiver_id }})
                            </p>
                            <input v-if="receiver_money === null"
                                   type="text"
                                   disabled
                                   placeholder="transaction"
                                   class=" input number "
                                   :value="calcCurrency"
                            />
                            <input v-else-if="receiver_money !== null"
                                   type="text"
                                   disabled
                                   placeholder="transaction"
                                   class=" input number "
                                   :value="receiver_money"
                            />
                        </div>
                        <div class=" column is-3">
                            <p class="has-text-left">ReceivingCurrency</p>
                            <div class="select is-medium">
                                <select v-model="currency_receiver_id" @change="convert">
                                    <option
                                        v-for="currency in currencies"
                                        :key="currency.name"
                                        :value="currency.name"
                                    >
                                        {{ currency.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="columns">
                                <span>Sender Details</span>
                            </div>
                            <div class="columns consumer">
                                <table class="table is-bordered is-striped  is-hoverable is-fullwidth">
                                    <tr>
                                        <th>
                                            Destination Country
                                        </th>
                                        <td> {{transfer.city_destination}}</td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Sender Full Name
                                        </th>
                                        <td> {{transfer.name_sender}}</td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Passport Or ID
                                        </th>
                                        <td> {{transfer.passport_number_sender}}</td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Phone Number
                                        </th>
                                        <td> {{transfer. phone_number_sender}}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Address
                                        </th>
                                        <td> {{transfer.address_sender}}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Nationality
                                        </th>
                                        <td> {{transfer.nationality_sender}}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Gender
                                        </th>
                                        <td> {{transfer.gender_sender}}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Profession
                                        </th>
                                        <td>{{transfer.profession_sender}}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Other Information
                                        </th>
                                        <td>{{transfer.other_info_sender}}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="column consumer">
                            <div class="columns">
                                <p class="">
                                    Receiver Full Name
                                </p>
                            </div>
                            <div class="columns consumer">
                                <input
                                    type="text"
                                    class="input is-size-6 "
                                    v-model="receiver_full_name"
                                    name="receiver_full_name"
                                    disabled
                                />
                            </div>
                            <div class="columns consumer">
                                <p class="">
                                    Passport Or ID
                                </p>
                            </div>
                            <div class="columns consumer">
                                <input
                                    type="text"
                                    class="input is-size-6 "

                                />
                            </div>
                            <div class="columns consumer">
                                <p class="">
                                    Phone Number
                                </p>
                            </div>
                            <div class="columns consumer">
                                <input
                                    type="search"
                                    class="input is-size-6 "
                                    v-model="receiver_phone_number"
                                    name="receiver_phone_number"
                                    disabled
                                />
                            </div>
                            <div class="columns consumer">
                                <p class="">
                                    Address
                                </p>
                            </div>
                            <div class="columns consumer">
                                <input
                                    type="text"
                                    class="input is-size-6 "

                                />
                            </div>
                            <div class="columns consumer">
                                <p class="">
                                    Nationality
                                </p>
                            </div>
                            <div class="columns consumer">
                                <input
                                    type="text"
                                    class="input is-size-6 "

                                />
                            </div>
                            <div class="columns consumer">
                                <p class="">
                                    Gender
                                </p>
                            </div>
                            <div class="columns consumer">
                                <input
                                    type="text"
                                    class="input is-size-6 "
                                />
                            </div>
                            <div class="columns consumer">
                                <p class="">
                                    Profession
                                </p>
                            </div>
                            <div class="columns consumer">
                                <input
                                    type="text"
                                    class="input is-size-6 "/>
                            </div>
                            <div class="columns consumer">
                                <p class="">
                                    Other Information
                                </p>
                            </div>
                            <div class="columns consumer">
                                <input
                                    type="text"
                                    class="input is-size-6 "/>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="column">
                    <div class="columns">
                        <div class="has-text-left column is-4">
                            <div>
                                <p class="heading">Exchange Rate</p>
                                <p class="">
                                    1 <span>{{ currency_sender_id }}</span> =
                                    <span class="is-danger">{{ convert_price }}</span>
                                    <span> {{ currency_receiver_id }}</span>
                                </p>
                                <p>................................................</p>
                            </div>
                        </div>
                        <div class="has-text-left column is-4">
                            <div>
                                <p class="heading">Fare</p>
                                <p class="">{{ commission }} {{ currency_sender_id }}</p>
                                <p>................................................</p>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="has-text-left column is-4">
                            <div>
                                <p class="heading">Total Amount</p>
                                <p class="">{{ totalAmount }} {{ currency_sender_id }}</p>
                                <p>..................................................</p>
                            </div>
                        </div>
                        <div class="has-text-left column is-4">
                            <div>
                                <p class="heading">Tax</p>
                                <p class="">0 {{ currency_sender_id }}</p>
                                <p>..........................................</p>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="has-text-left column ">
                            <div>
                                <p class="heading">Balance</p>
                                <p class="">0 {{ currency_sender_id }}</p>
                                <p>................................................</p>
                            </div>
                        </div>
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
            </div>
            <div class="columns">
                <div class="column">
                    <button
                        class="button is-outlined  input is-size-3 is-rounded is-success"
                    >
            <span class="icon is-small">
              <i class="fas fa-check"></i>
            </span>
                        <span>PAY</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    import axios from "axios";
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    export default {

        name: "ReceiverTransaction",
        data() {
            return {
                transfer: {},
                code: this.$route.params.code,
                total_money: "",
                currency_receiver_id: "",
                currency_sender_id: "",
                receiver_phone_number: "",
                receiver_full_name: "",
                name_sender: "",
                passport_ID: "",
                other_info: "",
                currencies: [],
                countries: [],
                convert_price: 0,
                commission: "",
                address: "",
                address_sender: "",
                agents: [],
                amount: "",
                photo: "",
                profession: "",
                birthday: "",
                receiver_money: null,
                images: []
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
            // uploadPictuer(e) {
            //     var file = e.target.files[0];
            //     var reader = new FileReader();
            //     reader.onloadend = (file) => {
            //         this.photo = reader.result;
            //     };
            //     reader.readAsDataURL(file);
            // },
            async receiverMoney() {
                await axios.patch('/api/receiver-transaction', {
                    code: this.code,
                    total_money: this.total_money,
                    currency_receiver_id: this.currency_receiver_id,
                    currency_sender_id: this.currency_sender_id,
                    convert_price: this.convert_price,
                    commission: this.commission,
                    country_id: this.country_id,
                    receiver_phone_number: this.receiver_phone_number,
                    receiver_full_name: this.receiver_full_name,
                    receiver_passport_number: this.passport_ID,
                    receiver_address: this.address,
                    receiver_nationality: this.sender_nationality,
                    receiver_gender: this.gender_sender,
                    receiver_profession: this.profession,
                    receiver_birthday: this.birthday,
                    other_info: this.other_info,
                }).then(response => {
                    console.log(response.data);
                });
            },
            async sellectAllCurrency() {
                await axios.get('/api/currency').then(response => {
                    console.log(response.data);
                    this.currencies = response.data.currency_list;
                });
            },
            async convert() {
                await axios.get(
                    "https://free.currconv.com/api/v7/convert?q=" +
                    this.currency_sender_id +
                    "_" +
                    this.currency_receiver_id +
                    "&compact=ultra&apiKey=301cb83516aa3d45d387").then(response =>
                    (this.convert_price = response.data[this.currency_sender_id + "_" + this.currency_receiver_id])
                );
            },
            code_transaction() {
                axios.get('/api/transaction').then(response => {
                    // this.dropzoneOptions.url = 'http://localhost:8000/api/transaction/' + response.data.code;
                    this.code = response.data.code;
                });
                return this.code;
            }
        },
        created() {
            this.sellectAllCurrency();
            this.details_transaction();
            this.code_transaction();
        },
        computed: {
            calcCurrency: function () {
                this.receiver_money = null;
                return this.convert_price * this.amount;
            },
            totalAmount: function () {
                const n1 = Number(this.amount);
                this.commission = n1 * 0.15;
                this.total_money = n1 * 0.15 + n1;
                return this.total_money;
            },
            calcTotal: function () {
                return this.amount = this.amount - this.commission;
            }
        }
    };
</script>
<style lang="css" scoped>
    .consumer {
        margin: auto;
    }

</style>
