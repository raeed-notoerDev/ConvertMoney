<template>
    <div class="TransferMoney container is-fluid">
        <div class="column"><strong class="is-size-3"> Transfer Money</strong></div>
        <hr>
        <div class="  is-centered is-fullwidth">
            <ul>
                <div class="tab-link  button is-info" id="info">
                    <div>
                        <strong>Transaction Information</strong>
                    </div>
                </div>
                <div class="tab-link button is-static" id="send">
                    <div>
                        <strong>Sender Information</strong>
                    </div>
                </div>
                <div class="tab-link button is-static" id="receive">
                    <div>
                        <strong>Beneficiary Information</strong>
                    </div>
                </div>
            </ul>
        </div>
        <div class="columns" style="margin: auto">
            <div class="column">
                <table class="table is-fullwidth">
                    <tbody>
                    <tr>
                        <td>Name Agent Sender</td>
                        <td><strong>{{member.first_name}} {{member.last_name}}</strong></td>
                    </tr>
                    <tr>
                        <td>Country Agent Sender</td>
                        <td><strong>{{country_member}}</strong></td>
                    </tr>
                    <tr>
                        <td>Address Agent Sender</td>
                        <td><strong>{{ member.address}}</strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="column ">
            </div>
        </div>
        <form @submit.prevent="send_money()">
            <div class="tabcontent" style="display: block" id="transaction-information">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column"></div>
                    <div v-show="amount>0 " class="column">
                        <div class="button is-link is-outlined tablinks" onclick="openTab(event,'sender')">
                            NEXT<i class="fas fa-angle-double-right"></i>
                        </div>
                    </div>
                    <div v-show="amount===''" class="column">
                        <div class=" button is-link is-outlined tablinks " disabled>
                            NEXT
                        </div>
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="columns">
                            <div class=" column is-8">
                                <p class="has-text-left">Amount ({{ currency_sender_id }})</p>
                                <input
                                    type="number"
                                    placeholder="AMOUNT"
                                    class=" input number "
                                    v-model="amount"
                                />
                            </div>
                            <div class=" column is-3">
                                <p class="has-text-left">Sending Currency</p>
                                <div class="select is-medium">
                                    <select v-model="currency_sender_id" @change="convert">
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
                                <input
                                    type="text"
                                    disabled
                                    placeholder="transaction"
                                    class=" input number "
                                    :value="calcCurrency"
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
                            <span>Destination Country</span>
                        </div>
                        <div class="columns">
                            <div class="select">
                                <select
                                    v-model="country_id">
                                    <option
                                        v-for="country in countries"
                                        :key="country.id"
                                        :id="country.id"
                                        :value="country.id"
                                    >
                                        {{ country.name }}
                                    </option>
                                </select>
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
                    </div>
                </div>
                <div class="columns">
                    <div class="column"></div>
                    <div class="column"></div>
                    <div v-show="amount>0 " class="column">
                        <div class="button is-link is-outlined tablinks" onclick="openTab(event,'sender')">
                            NEXT<i class="fas fa-angle-double-right"></i>
                        </div>
                    </div>
                    <div v-show="amount===''" class="column">
                        <div class=" button is-link is-outlined tablinks " disabled>
                            NEXT
                        </div>
                    </div>
                </div>
            </div>
            <div class="tabcontent" id="sender">
                <div class="columns">
                    <div class="column">
                        <div class="button  is-outlined tablinks"
                             onclick="openTab(event,'transaction-information')">
                            <i class="fas fa-angle-double-left"></i>PREVIOUS
                        </div>

                    </div>
                    <div class="column"></div>
                    <div class="column">
                        <div class="button is-link is-outlined tablinks" onclick="openTab(event,'receiver')">
                            NEXT<i class="fas fa-angle-double-right"></i>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="columns consumer">
                            <p class="">
                                Sender Full Name
                            </p>
                        </div>
                        <div class="columns consumer">
                            <input
                                type="search"
                                class="input is-size-6 "
                                v-model="sender_full_name"
                                @keyup="searchit"
                            />
                        </div>
                        <div v-show="beneficiaries!==null" v-for="beneficiary in beneficiaries"
                             class="list is-hoverable consumer">
                            <a class="list-item" @click="showBeneficiary(beneficiary.uuid)">
                                @ {{beneficiary.full_name}}
                            </a>
                        </div>
                        <div class=" columns consumer
                                ">
                            <p class="">
                                Passport Or ID
                            </p>
                        </div>
                        <div class="columns consumer">
                            <input
                                type="search"
                                class="input is-size-6 "
                                v-model="passport_ID"

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
                                v-model="sender_phone_number"

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
                                v-model="profession"
                                name="profession"
                            />
                        </div>

                    </div>
                    <div class="column">
                        <div class="columns consumer">
                            <p class="">
                                Address
                            </p>
                        </div>
                        <div class="columns consumer">
                            <input
                                type="text"
                                name="address_sender"
                                class="input is-size-6 "
                                v-model="address_sender"

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
                                name="sender_nationality"
                                v-model="sender_nationality"

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
                                v-model="gender_sender"
                                name="sender_gender"

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
                                v-model="birthday"
                                name="birthday"
                            />
                        </div>
                    </div>
                </div>

                <div class="columns">
                    Other Information
                </div>
                <div class="columns">
                        <textarea
                            class="input is-size-6 "
                            v-model="other_info"
                            name="other_info"
                        />
                </div>
                <div class="">

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
                    <div class="columns">
                        <div class="column is-9"></div>
                        <div class="column">
                            <div class="file">
                                <label class="file-label">
                                    <input
                                        class="file-input"
                                        type="file"
                                        name="picture"
                                        @change="uploadPicture"/>
                                    <span class="file-cta">
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
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="button  is-outlined tablinks"
                             onclick="openTab(event,'transaction-information')">
                            <i class="fas fa-angle-double-left"></i>PREVIOUS
                        </div>

                    </div>
                    <div class="column"></div>
                    <div class="column">
                        <div class="button is-link is-outlined tablinks" onclick="openTab(event,'receiver')">
                            NEXT<i class="fas fa-angle-double-right"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tabcontent" id="receiver">
                <div class="columns">
                    <div class="column">
                        <div class="button is-default is-outlined tablinks" onclick="openTab(event,'sender')">
                            <i class="fas fa-angle-double-left"></i>PREVIOUS
                        </div>
                    </div>
                    <div class="column"></div>
                    <div class="column">
                        <!--                        <div class="button is-link is-outlined tablinks" onclick="openTab(event,'receiver')">-->
                        <!--                            next-->
                        <!--                        </div>-->
                    </div>
                </div>
                <div class="columns">
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
                                @keyup="searchitR"
                            />
                        </div>
                        <div v-show="beneficiariesR!==null" v-for="beneficiary in beneficiariesR"
                             class="list is-hoverable consumer">
                            <a class="list-item" @click="showBeneficiaryReceiver(beneficiary.uuid)">
                                @ {{beneficiary.full_name}}
                            </a>
                        </div>
                        <div class="columns consumer">
                            <p class="">
                                Passport Or ID
                            </p>
                        </div>
                        <div class="columns consumer">
                            <input
                                type="search"
                                class="input is-size-6 "
                                disabled
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
                                Profession
                            </p>
                        </div>
                        <div class="columns consumer">
                            <input
                                type="text"
                                class="input is-size-6 "
                                disabled
                            />
                        </div>
                    </div>
                    <div class="column">
                        <div class="columns consumer">
                            <p class="">
                                Address
                            </p>
                        </div>
                        <div class="columns consumer">
                            <input
                                type="search"
                                class="input is-size-6 "
                                disabled
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
                                disabled
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
                                disabled
                            />
                        </div>
                    </div>
                </div>


                <div class="columns">
                    <div class="column">
                        <div class="button is-default is-outlined tablinks"
                             onclick="openTab(event,'sender')">
                            <i class="fas fa-angle-double-left"></i>PREVIOUS
                        </div>
                    </div>
                    <div class="column"></div>
                    <div class="column" v-show="button === true">
                        <button
                            class="button is-outlined  input is-size-3 is-rounded is-success"
                        >

                                <span class="icon is-small">
              <i class="fas fa-paper-plane"></i>
            </span>
                            <span>Send Transaction</span>
                        </button>
                        <!--                        <div class="button is-link is-outlined tablinks" onclick="openTab(event,'receiver')">-->
                        <!--                            next-->
                        <!--                        </div>-->
                    </div>
                    <div class="column" v-show="button === false">
                        <button
                            class="button is-loading  input is-size-3 is-rounded is-success"
                        >

                                <span class="icon is-small">
              <i class="fas fa-paper-plane"></i>
            </span>
                            <span>Send Transaction</span>
                        </button>
                        <!--                        <div class="button is-link is-outlined tablinks" onclick="openTab(event,'receiver')">-->
                        <!--                            next-->
                        <!--                        </div>-->
                    </div>
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

        name: "TransferMoney",
        data() {
            return {
                code: 'adasd',
                member: {},
                country_member: "",
                images: [],
                show_img: false,
                route: false,
                total_money: "",
                currency_receiver_id: "USD",
                currency_sender_id: "EUR",
                sender_full_name: null,
                sender_phone_number: null,
                receiver_phone_number: null,
                receiver_full_name: null,
                passport_ID: null,
                address_sender: null,
                gender_sender: null,
                other_info: null,
                sender_nationality: null,
                currencies: [],
                countries: [],
                country_id: 1,
                convert_price: "",
                commission: "",
                address: "",
                agents: [],
                amount: "",
                photo: "",
                profession: null,
                birthday: null,
                name_image: null,
                beneficiaries: [],
                beneficiariesR: [],
                button: true,
                year: new Date().getFullYear(),
                day: new Date().getDate(),
                hour: new Date().getHours(),
                minute: new Date().getMinutes(),
                month: new Date().getUTCMonth(),
                second: new Date().getSeconds()

                // dropzoneOptions: {
                //     url: this.url_images,
                //     thumbnailWidth: 40,
                //     thumbnailHeight: 30,
                //     maxFilesize: 0.5,
                //     init: function () {
                //         this.on("complete", function () {
                //             Fire.$emit('ShowImages');
                //         });
                //         this.on("success", function (file) {
                //             this.removeFile(file);
                //         });
                //     },
                //     headers: {
                //         "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                //     }
                // }
            };
        },
        methods: {
            infoMember() {
                axios.get('api/info-member').then(response => {
                    this.member = response.data.member;
                    this.country_member = response.data.country
                }).catch();
            },
            showBeneficiaryReceiver(uuid) {
                this.beneficiariesR = null;
                this.receiver_full_name = null;
                this.receiver_phone_number = null;
                axios.get('api/beneficiary/' + uuid).then(data => {
                    this.receiver_full_name = data.data.full_name;
                    this.receiver_phone_number = data.data.phone_number;
                });
            },
            showBeneficiary(uuid) {
                this.beneficiaries = null;
                axios.get('api/beneficiary/' + uuid).then(data => {
                    this.sender_full_name = data.data.full_name;
                    this.gender_sender = data.data.gender;
                    this.profession = data.data.profession;
                    this.sender_nationality = data.data.nationality;
                    this.sender_phone_number = data.data.phone_number;
                    this.passport_ID = data.data.passport_number;
                    this.address_sender = data.data.address;
                    this.birthday = data.data.birthday;
                    this.other_info = data.data.other_info;

                });
            },
            searchit: _.debounce(() => {
                Fire.$emit('searching');
            }, 1000),
            searchitR: _.debounce(() => {
                Fire.$emit('searchingR');
            }, 1000),
            uploadPicture(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if (file['size'] > limit) {
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    });
                    return false;
                }
                this.name_image = file.name;
                reader.onloadend = async (file) => {
                    this.photo = reader.result;
                    await axios.post('api/image-transaction/' + this.code,
                        {
                            name: this.name_image,
                            photo: this.photo
                        }).then(Fire.$emit("ShowImages")).catch(error => {
                        console.log(error)
                    });
                };
                reader.readAsDataURL(file);

            },
            sendMoney() {
                Fire.$emit('Newcode');
                axios.post('/api/create-transaction', {
                    code: this.code,
                    address_sender: this.address_sender,
                    total_money: this.total_money,
                    currency_receiver_id: this.currency_receiver_id,
                    currency_sender_id: this.currency_sender_id,
                    agent_id_receiver: this.agent_id_receiver,
                    convert_price: this.convert_price,
                    commission: this.commission,
                    photo: this.photo,
                    country_id: this.country_id,
                    sender_phone_number: this.sender_phone_number,
                    receiver_phone_number: this.receiver_phone_number,
                    sender_full_name: this.sender_full_name,
                    receiver_full_name: this.receiver_full_name,
                    passport_ID: this.passport_ID,
                    sender_nationality: this.sender_nationality,
                    sender_gender: this.gender_sender,
                    profession: this.profession,
                    birthday: this.birthday,
                    other_info: this.other_info,
                }).then(response => {
                    this.route = true;
                    if (this.route === true)
                        this.$router.push('/fish/' + this.code);
                    Fire.$emit('Newcode');
                }).catch(error => {
                    this.button = true;
                    console.log(error.response.data.message);
                    swal.fire(
                        'You Cant Send!',
                        [error.response.data.message['sender_full_name'], error.response.data.message['sender_phone_number'], error.response.data.message['receiver_phone_number'], error.response.data.message] + "",
                        'error'
                    );
                });
            },
            async sellectAllCurrency() {
                await axios.get('api/currency').then(response => {
                    // eslint-disable-next-line no-console
                    console.log(response.data);
                    this.currencies = response.data.currency_list;
                });
            },
            async sellectAllCountry() {
                await axios.get('api/country').then(response => {
                    // eslint-disable-next-line no-console
                    console.log(response.data);
                    this.countries = response.data.country_list;
                });
            },
            async convert() {
                await axios.get(
                    "https://free.currconv.com/api/v7/convert?q=" +
                    this.currency_sender_id +
                    "_" +
                    this.currency_receiver_id +
                    "&compact=ultra&apiKey=301cb83516aa3d45d387").then(response =>
                    (this.convert_price =
                        response.data[this.currency_sender_id + "_" + this.currency_receiver_id])
                );
            },
            code_transaction() {
                axios.get('/api/transaction').then(response => {
                    this.code = response.data.code;
                    console.log(this.code);
                });
                return this.code;
            },
            url_images() {
                return 'http://localhost:8000/api/image-transaction/' + this.code;
            },
            delete_image(name) {
                axios.post('api/delete-image',
                    {
                        code: this.code,
                        name: name
                    }).then(Fire.$emit('ShowImages'))
            },
            getTransactionPhoto(picture) {
                return "images/" + picture;
            },
            send_transaction: _.debounce(() => {

                Fire.$emit('send');
            }, 1500),
            send_money() {
                Fire.$emit('sending');
            }
        },
        created() {
            this.infoMember();
            this.sellectAllCurrency();
            this.sellectAllCountry();
            this.convert();
            Fire.$on('Newcode', () => {
                this.code_transaction();
            });
            // this.code_transaction();
            Fire.$on('ShowImages', () => {
                this.show_img = true;
                axios.get('api/show-images/' + this.code).then(response => {
                    this.images = response.data.list_images;
                    console.log('images  ' + this.images);
                    console.log('data  ' + response.data.list_images);
                });
            });
            Fire.$on('searching', () => {
                // let query = this.$parent.search;
                if (this.sender_full_name.trim() !== "") {
                    let query = this.sender_full_name;
                    axios.get('api/findBeneficiary?q=' + query)
                        .then((data) => {

                            this.beneficiaries = data.data;
                            console.log(this.beneficiaries)
                        })
                        .catch(() => {
                        })
                } else {
                    this.beneficiaries = null;
                }
            });
            Fire.$on('searchingR', () => {
                if (this.receiver_full_name.trim() !== "") {
                    let query = this.receiver_full_name;
                    axios.get('api/findBeneficiary?q=' + query)
                        .then((data) => {
                            this.beneficiariesR = data.data;
                            console.log(this.beneficiariesR)
                        })
                        .catch(() => {
                        })
                } else
                    this.beneficiariesR = null;
            });
            Fire.$on('sending', () => {
                this.button = false;
                this.send_transaction();
            });
            Fire.$on('send', () => {

                this.sendMoney();
            });
        },
        computed: {
            calcCurrency: function () {
                return this.convert_price * this.amount;
            },
            totalAmount: function () {
                const n1 = Number(this.amount);
                // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                this.commission = n1 * 0.15;
                // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                this.total_money = n1 * 0.15 + n1;
                return this.total_money;
            }
        },
        components: {
            vueDropzone: vue2Dropzone,
        }
    };
</script>
<style lang="css" scoped>
    .consumer {
        margin: auto;
    }

    .file-input {
        height: 100px;
        left: 0;
        opacity: 1;
        outline: none;
        position: absolute;
        top: 0;
        width: 100px;
    }
</style>
