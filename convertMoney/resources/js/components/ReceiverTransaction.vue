<template>
    <div class="TransferMoney container" v-if="transfer.status!=='blocked'">
        <form @submit.prevent="receiverMoney">
            <div class="columns">


                <div class="column"><strong class="is-size-3 level-left"> Transaction Payout</strong></div>
                <div class="column"></div>
                <div class="column">
                    <button v-if="transfer.status!=='paid'"
                            class="button is-outlined  input is-size-3 is-rounded is-success"
                            type="submit">
            <span class="icon is-small">
              <i class="fas fa-check"></i>
            </span>
                        <span>PAYOUT</span>
                    </button>
                    <div v-else-if="transfer.status==='paid'"
                         class="button is-static is-outlined is-rounded is-success ">
                        <div class="is-size-4">Delivered On: &nbsp;</div>
                        <br>
                        <strong class="">{{transfer.delivered_at}}</strong>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column"></div>
                <div class="column"><strong class="is-size-5"> Transaction Details</strong></div>
                <div class="column">

                </div>
            </div>
            <hr>

            <div class="columns">
                <div class="column">
                    <div class="columns">
                        <span class="is-size-6">TCN:</span>
                    </div>
                    <div class="columns">
                        <strong class="is-size-5"> {{this.$route.params.code}}</strong>
                    </div>
                    <hr>
                    <div class="columns">
                        <span class="is-size-6">Convert Price</span>
                    </div>
                    <div class="columns">
                        <strong class="is-size-5"> {{transfer.convert_price}}</strong>
                    </div>
                    <hr>
                    <div class="columns">
                        <span>Sending Amount</span>
                    </div>
                    <div class="columns"><strong class="is-size-5"> {{calcTotal}} {{currency_sender_id}} </strong></div>
                    <hr>
                </div>
                <div class="column">

                    <div class="columns"> Transaction Date</div>
                    <div class="columns"><strong> {{transfer.date}}</strong></div>
                    <hr>
                    <div class="columns"> Transaction Status</div>
                    <div class="columns">
                        <strong v-if="transfer.status==='blocked'" class="has-text-danger"> BLOCK</strong>
                        <strong v-else-if="transfer.status==='approved'" class="has-text-primary"> APPROVED</strong>
                        <strong v-else-if="transfer.status==='paid'" class="has-text-success"> PAIDOUT</strong>
                        <strong v-else-if="transfer.status==='hold'"> HOLD</strong>
                        <strong v-else-if="transfer.status==='waiting'" class="has-text-warning"> WAITED</strong>
                    </div>
                    <hr>
                    <div class="columns">
                        <span>Payout Amount</span>
                    </div>
                    <div class="columns">
                        <!--                        <strong v-if="receiver_money === null">{{calcCurrency}} {{ currency_receiver_id }}</strong>-->


                        <!--                       <strong      v-else-if="receiver_money !== null">{{receiver_money}} {{ currency_receiver_id }}</strong>-->
                        <strong>{{paymentAmount}} {{ currency_receiver_id }}</strong>
                    </div>
                    <hr>

                </div>

            </div>
            <div class="columns">
                <div class="column"></div>
                <div class="column"><strong class="is-size-5"> Beneficiary Details</strong></div>
                <div class="column"></div>
            </div>
            <hr>
            <div class="columns">
                <div class="column">
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
                                v-model="receiver_address"

                            />
                        </div>


                        <div class="columns consumer">
                            <p class="">
                                Other Information
                            </p>
                        </div>
                        <div class="columns consumer">
                            <input
                                type="text"
                                class="input is-size-6 "
                                v-model="receiver_other_info"/>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="columns consumer">
                        <p class="">
                            Passport Or ID
                        </p>
                    </div>
                    <div class="columns consumer">
                        <input
                            type="text"
                            class="input is-size-6 "
                            v-model="receiver_passport_ID"

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
                            class="input is-size-6 "
                            v-model="receiver_profession"/>
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
                            v-model="receiver_gender"
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
                            v-model="receiver_nationality"

                        />
                    </div>
                    <div class="columns consumer">
                        <p class="">
                            Birthday
                        </p>
                    </div>
                    <div class="columns consumer">
                        <input
                            type="text"
                            class="input is-size-6 "
                            v-model="receiver_birthday"

                        />
                    </div>
                </div>

            </div>
            <div class="columns">
                <div class="column"></div>
                <div class="column"><strong class="is-size-5"> Sender Details</strong></div>
                <div class="column"></div>
            </div>
            <hr>


            <div class="columns ">
                <div class="column">
                    <div class="columns">
                        Destination Country
                    </div>
                    <hr>
                    <div class="columns">
                        Sender Full Name
                    </div>
                    <hr>
                    <div class="columns">
                        Passport Or ID
                    </div>
                    <hr>
                    <div class="columns">
                        Phone Number
                    </div>
                    <hr>
                    <div class="columns">
                        Address
                    </div>
                    <hr>
                    <div class="columns">
                        Nationality
                    </div>
                    <hr>
                    <div class="columns">
                        Gender
                    </div>
                    <hr>
                    <div class="columns">
                        Profession
                    </div>
                    <hr>
                    <div class="columns">
                        Other Information
                    </div>
                    <hr>

                </div>
                <div class="column">
                    <div class="columns">
                        <strong> {{transfer.city_destination}}</strong>
                    </div>
                    <hr>
                    <div class="columns">
                        <strong> {{transfer.name_sender}}</strong>
                    </div>
                    <hr>
                    <div class="columns">
                        <strong>{{transfer.passport_number_sender}}</strong>
                    </div>
                    <hr>
                    <div class="columns">
                        <strong>{{transfer. phone_number_sender}}</strong>
                    </div>
                    <hr>
                    <div class="columns">
                        <strong> {{transfer.address_sender}}</strong>
                    </div>
                    <hr>
                    <div class="columns">
                        <strong>{{transfer.nationality_sender}}</strong>
                    </div>
                    <hr>
                    <div class="columns">
                        <strong> {{transfer.gender_sender}}</strong>
                    </div>
                    <hr>
                    <div class="columns">
                        <strong> {{transfer.profession_sender}}</strong>
                    </div>
                    <hr>
                    <div class="columns">
                        <strong v-show="transfer.other_info_sender===null"> NO DATA AVAILABLE</strong>
                        <strong> {{transfer.other_info_sender}}</strong>
                    </div>
                    <hr>

                </div>
            </div>
            <div class="columns ">
                <table class="table is-fullwidth" v-if="show_img!==false">
                    <thead>
                    <th>File</th>
                    <th>File Name</th>
                    <th>Control</th>
                    </thead>
                    <tbody>
                    <tr v-for="image in images">
                        <td>
                            <a :href="getTransactionPhoto(image.path)" data-lity>
                                <img class="image is-48x48"
                                     :src="getTransactionPhoto(image.path)"
                                     alt="Image Transaction"/>
                            </a>
                        </td>
                        <td>
                            <a :href="getTransactionPhoto(image.path)" data-lity>
                                <span>{{image.name}}</span>
                            </a>
                        </td>
                        <td>
                            <a :href="getTransactionPhoto(image.path)" data-lity>
                                <i class="fas fa-eye"></i>
                            </a>
                            <i class="delete" @click="delete_image(image.path)"></i>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
            <div class="columns ">
                <div class="file ">
                    <label class="file-label ">
                        <input
                            class="file-input "
                            type="file"
                            name="picture"
                            @change="uploadPicture"/>
                        <span class="file-cta ">
                                            <span class="file-icon">
                                              <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">
                                              Choose a file…
                                            </span>
                                          </span>
                    </label>
                </div>
            </div>
        </form>
    </div>
    <div class="container" v-else-if="transfer.status==='blocked'">
        <br>
        <br>
        <br>
        <div class="icon has-text-danger is-size-3"><i class="fas fa-info-circle"></i></div>
        <br>
        <strong class="is-size-5">NO DATA AVAILABLE</strong>
        <br>
        <br>
        <br>
        <strong>
            <div class="is-size-3">This Transaction It's</div>

            <div class="has-text-danger is-size-3">BLOCKED</div>
            <div class="is-size-3">You cannot PAIDOUT ......</div>
        </strong>
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
                name_sender: "",
                passport_ID: "",
                other_info: "",
                currencies: [],
                countries: [],
                show_img: false,
                convert_price: 0,
                commission: "",
                address: "",
                address_sender: "",
                agents: [],
                amount: "",
                photo: "",
                profession: "",
                birthday: "",
                images: [],
                name_image: "",
                receiver_money: null,
                receiver_nationality: "",
                receiver_gender: "",
                receiver_profession: "",
                receiver_phone_number: "",
                receiver_full_name: "",
                receiver_birthday: "",
                receiver_address: "",
                receiver_other_info: "",
                receiver_passport_ID: "",

            }
        },
        methods: {
            uploadPicture(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if (file['size'] > limit) {
                    swal.fire({
                        type: 'info',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    });
                    return false;
                }
                this.name_image = file.name;
                reader.onloadend = async (file) => {
                    this.photo = reader.result;
                    await axios.post('/api/image-transaction/' + this.$route.params.code,
                        {
                            name: this.name_image,
                            photo: this.photo
                        }).then(Fire.$emit("ShowImages")).catch(error => {
                        console.log(error)
                    });
                };
                reader.readAsDataURL(file);

            },
            getTransactionPhoto(picture) {
                return "/images/" + picture;
            },
            delete_image(name) {
                axios.post('/api/delete-image',
                    {
                        code: this.$route.params.code,
                        name: name
                    }).then(Fire.$emit('ShowImages'))
            },
            async details_transaction() {
                console.log(this.$route.params.code);
                await axios.post('/api/show-transaction/' + this.$route.params.code)
                    .then(response => {
                        this.transfer = response.data.transaction;
                        this.commission = response.data.transaction.commission;
                        this.amount = response.data.transaction.total_money;
                        this.currency_sender_id = response.data.transaction.currency_sender;
                        this.currency_receiver_id = response.data.transaction.currency_receiver;
                        this.convert_price = response.data.transaction.convert_price;
                        this.receiver_money = response.data.transaction.receiver_money;
                        this.receiver_nationality = response.data.transaction.receiver_nationality;
                        this.receiver_gender = response.data.transaction.receiver_gender;
                        this.receiver_profession = response.data.transaction.receiver_profession;
                        this.receiver_full_name = response.data.transaction.receiver_full_name;
                        this.receiver_birthday = response.data.transaction.receiver_birthday;
                        this.receiver_address = response.data.transaction.receiver_address;
                        this.receiver_other_info = response.data.transaction.receiver_other_info;
                        this.receiver_passport_ID = response.data.transaction.receiver_passport_ID;
                        this.images = response.data.images;
                        if (this.images !== null) {
                            this.show_img = true;
                        }
                    })
                    .catch(error => console.log(error));
                this.receiver_full_name = this.transfer.receiver_full_name;
                this.receiver_phone_number = this.transfer.phone_number_receiver;
            },
            async receiverMoney() {
                await axios.patch('/api/receiver-transaction', {
                    code: this.$route.params.code,
                    total_money: this.paymentAmount,
                    currency_receiver_id: this.currency_receiver_id,
                    currency_sender_id: this.currency_sender_id,
                    convert_price: this.convert_price,
                    commission: this.commission,
                    country_id: this.country_id,
                    receiver_phone_number: this.receiver_phone_number,
                    receiver_full_name: this.receiver_full_name,
                    receiver_passport_number: this.receiver_passport_ID,
                    receiver_address: this.receiver_address,
                    receiver_nationality: this.receiver_nationality,
                    receiver_gender: this.receiver_gender,
                    receiver_profession: this.receiver_profession,
                    receiver_birthday: this.receiver_birthday,
                    receiver_other_info: this.receiver_other_info,
                    code_receiver: this.transfer.code_receiver
                }).then(response => {
                    swal.fire('Success', response.data.message + "", 'success');
                    console.log(response.data);
                    location.reload();
                });
            },
            async sellectAllCurrency() {
                await axios.get('/api/currency').then(response => {
                    console.log(response.data);
                    this.currencies = response.data.currency_list;
                });
            },
        },
        created() {
            this.details_transaction();
            Fire.$on('ShowImages', () => {
                this.show_img = true;
                axios.get('/api/show-images/' + this.$route.params.code).then(response => {
                    this.images = response.data.list_images;
                    console.log('images  ' + this.images);
                    console.log('data  ' + response.data.list_images);
                });
            });
        },
        computed: {
            // calcCurrency: function () {
            //     this.receiver_money = null;
            //     return this.convert_price * this.amount;
            // },
            // totalAmount: function () {
            //     const n1 = Number(this.amount);
            //     this.commission = n1 * 0.15;
            //     this.total_money = n1 * 0.15 + n1;
            //     return this.total_money;
            // },
            calcTotal: function () {
                return this.amount - this.commission;
            },
            paymentAmount: function () {
                return this.calcTotal * this.convert_price;
            },
        }
    };
</script>
<style lang="css" scoped>
    .consumer {
        margin: auto;
    }

</style>
