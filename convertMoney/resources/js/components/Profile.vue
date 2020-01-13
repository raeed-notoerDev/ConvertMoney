<template>
    <div class="container">
        <div class="">
            <div class="card ">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <header class="card-header widget-user-header" style="background-image:url('../img/user-cover.jpg')">
                    <figure class="image is-128x128" style="margin: auto">
                        <img class="is-rounded" :src="getProfilePhoto()" alt="User Avatar"
                             style="width: 250px;height: 130px">
                    </figure>
                </header>
                <footer class="card-footer">
                    <div class="card-footer-item">
                        Wallet : ( {{wallet}} )
                    </div>

                    <div class="card-footer-item">
                        Status :(
                        <span v-if="member.status === 'hold'">
                    <span class=" has-text">
                        <div class="is-size-5"> </div>HOLD </span>
                  </span>
                        <span v-else-if="member.status === 'block'">
                    <span class=" has-text-danger">
                      <div class="is-size-5">BLOCK </div>
                    </span>
                  </span>
                        <span v-else-if="member.status === 'active'">
                    <span class=" has-text-info">
                      <div class="is-size-5">Active</div>
                    </span>
                  </span>)

                    </div>
                    <div class="card-footer-item">
                        Commission : ({{commission}})
                    </div>
                </footer>
            </div>
            <div class="field">
                <div class="card">
                    <div class="card-content">
                        <form class="form-horizontal" @submit.prevent="updateInfo">
                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label for="inputName" class="col-sm-2 control-label">User Name</label>
                                        <div class="col-sm-12">
                                            <input type="text"
                                                   v-model="user_name"
                                                   name="user_name"
                                                   class="input"
                                                   id="inputName"
                                                   placeholder="User Name"/>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label for="inputFirstName">First Name</label>

                                        <div class="col-sm-12">
                                            <input type="text"
                                                   v-model="first_name"
                                                   name="first_name" class="input"
                                                   id="inputFirstName"
                                                   placeholder="First Name"/>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label for="inputPhoneNumber">Phone Number</label>
                                        <div class="col-sm-12">
                                            <input type="text"
                                                   name="phone_number"
                                                   class="input"
                                                   id="inputPhoneNumber"
                                                   placeholder="Phone Number"
                                                   v-model="phone_number"
                                            />
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label for="gender">Gender</label>
                                        <div class="col-sm-12">
                                            <input class="input"
                                                   v-model="gender"
                                                   name="gender"
                                                   id="gender"
                                                   placeholder="Gender"/>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label for="address" class="">Address</label>
                                        <input type="text"
                                               v-model="address"
                                               name="address"
                                               class="input"
                                               id="address"
                                               placeholder="Address">
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field">
                                        <label for="inputEmail">Email</label>
                                        <input type="email"
                                               class="input"
                                               id="inputEmail"
                                               placeholder="Email"
                                               v-model="email"
                                               name="email"
                                        />
                                    </div>
                                    <div class="field">
                                        <label for="inputLastName" class="">Last Name</label>
                                        <div class="col-sm-12">
                                            <input type="text"
                                                   name="last_name"
                                                   class="input"
                                                   id="inputLastName"
                                                   placeholder="Last Name"
                                                   v-model="last_name"/>
                                        </div>
                                    </div>
                                    <div class="file">
                                        <label class="file-label">
                                            <input
                                                class="file-input"
                                                type="file"
                                                name="picture"
                                                @change="updateProfile"/>
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
                                    <div class="field">
                                        <label for="password" class="col-sm-12 control-label">Passport (leave empty if
                                            not changing)</label>
                                        <input type="password"
                                               name="password"
                                               v-model="password"
                                               class="input"
                                               id="password"
                                               placeholder="Passport">
                                    </div>
                                    <div class="field">
                                        <label for="zip_code" class="col-sm-12 control-label">Zip Code</label>
                                        <input type="text"
                                               v-model="zip_code"
                                               class="input"
                                               id="zip_code"
                                               placeholder="Zip Code">
                                    </div>
                                    <div class="field">
                                        <button  type="submit"
                                                class="button is-outlined is-rounded  is-success ">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "Profile",
        data() {
            return {
                member: {},
                code: this.$route.params.code,
                picture: '',
                name: '',
                password: '',
                email: '',
                user_name: '',
                first_name: '',
                last_name: '',
                phone_number: '',
                gender: '',
                status: '',
                address: '',
                wallet: '',
                commission: '',
                nationality: '',
                zip_code: '',
            }
        },
        methods: {
            async details_member() {
                await axios.get('/api/member/' + this.code)
                    .then(response => {
                        this.member = response.data.member;
                        this.last_name = response.data.member.last_name;
                        this.first_name = response.data.member.first_name;
                        this.user_name = response.data.member.user_name;
                        this.phone_number = response.data.member.phone_number;
                        this.email = response.data.member.email;
                        this.status = response.data.member.status;
                        this.wallet = response.data.member.wallet;
                        this.commission = response.data.member.agent_commission;
                        this.password = response.data.member.password;
                        this.nationality = response.data.member.nationality;
                        this.zip_code = response.data.member.zip_code;
                        this.gender = response.data.member.gender;
                        this.address = response.data.member.address;
                    })
                    .catch(error => console.log(error));
            },
            getProfilePhoto() {
                return (this.picture.length > 200) ? this.picture : "../img/profile/" + this.member.picture;
            },
            updateInfo() {
                // this.$Progress.start();
                if (this.password === '') {
                    this.password = undefined;
                }
                axios.patch('/api/profile/'+this.code,
                    {
                        email: this.email,
                        user_name: this.user_name,
                        phone_number: this.phone_number,
                        gender: this.gender,
                        zip_code: this.zip_code,
                        address: this.address,
                        password: this.password,
                        nationality: this.nationality,
                        first_name: this.first_name,
                        last_name: this.last_name,
                        picture:this.picture
                    })
                    .then(response => {
                        console.log(response);
                        // Fire.$emit('AfterCreate');
                        // this.$Progress.finish();
                    })
                    .catch(error => {
                        // this.$Progress.fail();
                        console.log(error);
                    });
            },
            updateProfile(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                console.log(file);
                // let limit = 1024 * 1024 * 2;
                // if (file['size'] > limit) {
                //     swal({
                //         type: 'error',
                //         title: 'Oops...',
                //         text: 'You are uploading a large file',
                //     });
                //     return false;
                // }
                reader.onloadend = (file) => {
                    this.picture = reader.result;

                };
                reader.readAsDataURL(file);
            }
        },
        created() {
            this.details_member();
        }
    }
</script>

<style scoped>
    .widget-user-header {
        background-position: center center;
        background-size: cover;
        height: 250px !important;
    }

</style>
