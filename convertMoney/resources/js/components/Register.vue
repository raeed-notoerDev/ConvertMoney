<template>
    <div class="container">
        <div class="card">
            <div class="card-content">
                <p class="subtitle">
                    Add Members.
                </p>
                <div class="container is-12">
                    <form @submit.prevent="register">
                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Email</label>
                                        <p class="control has-icons-left has-icons-right">
                                            <input
                                                class="input is-rounded"
                                                type="text"
                                                placeholder="E-mail"
                                                name="email"
                                                v-model="email"
                                            />
                                            <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                  </span>
                                            <span class="icon is-small is-right">
                    <i class="fas fa-check"></i>
                  </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">First Name</label>
                                        <p class="control has-icons-left">
                                            <input
                                                class="input is-rounded"
                                                type="text"
                                                placeholder="First Name"
                                                name="first_name"
                                                v-model="first_name"
                                            />
                                            <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Address</label>
                                        <p class="control has-icons-left">
                                            <input
                                                class="input is-rounded"
                                                type="text"
                                                placeholder="Address"
                                                name="address"
                                                v-model="address"
                                            />
                                            <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Phone Number</label>
                                        <p class="control has-icons-left">
                                            <input
                                                class="input is-rounded"
                                                type="text"
                                                placeholder="Phone Number"
                                                name="phone_number"
                                                v-model="phone_number"
                                            />
                                            <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Gender</label>
                                        <p class="control has-icons-left">
                                            <input
                                                class="input is-rounded"
                                                type="text"
                                                placeholder="Gender"
                                                name="gender"
                                                v-model="gender"
                                            />
                                            <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                        </p>
                                    </div>
                                </div>
                                <label class="label">Country</label>
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
                            <div class="column">
                                <div class="field">
                                    <div class="control">
                                        <label class="label">User Name</label>
                                        <p class="control has-icons-left">
                                            <input
                                                class="input is-rounded"
                                                type="text"
                                                placeholder="user_name"
                                                name="user_name"
                                                v-model="user_name"
                                            />
                                            <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Last Name</label>
                                        <p class="control has-icons-left">
                                            <input
                                                class="input is-rounded"
                                                type="text"
                                                placeholder="Last Name"
                                                name="last_name"
                                                v-model="last_name"
                                            />
                                            <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Zip Code</label>
                                        <p class="control has-icons-left">
                                            <input
                                                class="input is-rounded"
                                                type="text"
                                                placeholder="Zip Code"
                                                name="zip_code"
                                                v-model="zip_code"
                                            />
                                            <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <label class="label">Nationality</label>
                                        <p class="control has-icons-left">
                                            <input
                                                class="input is-rounded"
                                                type="text"
                                                placeholder="Nationality"
                                                name="nationality"
                                                v-model="nationality"
                                            />
                                            <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Commission</label>
                                        <p class="control has-icons-left">
                                            <input
                                                class="input is-rounded"
                                                type="text"
                                                placeholder="Agent Commission"
                                                name="agent_commission"
                                                v-model="agent_commission"
                                            />
                                            <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="level-left">
                                    Attach Image…… <span style="color: #f14668"> *</span>
                                </div>
                                <div class="file">
                                    <label class="file-label">
                                        <input
                                            class="file-input"
                                            type="file"
                                            name="picture"
                                            @change="uploadPictuer"
                                        />
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


                        <div class="field">
                            <button type="submit" class="button input is-primary">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "Register",
        data() {
            return {
                email: "",
                password: "12345678",
                user_name: "",
                first_name: "",
                last_name: "",
                country_id: "",
                nationality: "",
                gender: "",
                phone_number: "",
                agent_commission: "",
                zip_code: "",
                picture: "",
                address: "",
                status: "hold",
                countries: []
            }
        },
        methods: {
            uploadPictuer(e) {
                var file = e.target.files[0];
                var reader = new FileReader();
                // eslint-disable-next-line no-unused-vars
                reader.onloadend = (file) => {
                    this.picture = reader.result;
                };
                reader.readAsDataURL(file);
            },
            async register() {
                await axios.post('api/user/register',
                    {
                        email: this.email,
                        password: this.password,
                        user_name: this.user_name,
                        first_name: this.first_name,
                        last_name: this.last_name,
                        country_id: this.country_id,
                        nationality: this.nationality,
                        gender: this.gender,
                        status: this.status,
                        phone_number: this.phone_number,
                        agent_commission: this.agent_commission,
                        zip_code: this.zip_code,
                        picture: this.picture,
                        address: this.address
                    }).then(response => {
                    console.log(response.data);
                }).catch(
                    error => {
                        console.log(error);
                    }
                );
            },
            async selectAllCountry() {
                await axios.get('api/country').then(response => {
                    // eslint-disable-next-line no-console
                    console.log(response.data);
                    this.countries = response.data.country_list;
                });
            },
        },
        created() {
            this.selectAllCountry();
        }
    }
</script>

<style scoped>

</style>
