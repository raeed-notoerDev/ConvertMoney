<template>
    <div>
        <button type="button" @click="collapse" class="collapsibleheader"><span
            class="is-size-4"> Company Details </span></button>
        <div class="content">
            <form @submit.prevent="updateHeader">
                <div class="field">
                    <div class="is-size-3 level-left">
                        <label class="label"> Company Name </label>
                    </div>
                    <input class="input" type="text" v-model="company_name" placeholder="Company Name"/>
                </div>
                <div class="field">
                    <div class="is-size-3 level-left">
                        <label class="label"> Description </label>
                    </div>
                    <input class="input" v-model="description" type="text" placeholder="Description"/>
                </div>
                <div class="field media">
                    <div class="image media-left is-128x128">
                        <img :src="pathPhoto()"/>
                    </div>
                    <div class="media-content">
                        <div class="file ">
                            <label class="file-label">
                                <input class="file-input" type="file" name="logo" @change="updateProfile">
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
                        <button type="submit" class="button is-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import Header from '../Header'

    export default {
        name: "DataHeader",
        data() {
            return {
                company_name: "",
                description: "",
                logo: "",
                headerData: ""
            };
        },
        methods: {
            updateHeader() {
                axios.patch('api/setting-header', {
                    company_name: this.company_name,
                    logo: this.logo,
                    description: this.description
                }).then(response => {
                    swal.fire(
                        'Update!',
                        'Your file has been updated.',
                        'success'
                    );
                    // location.reload()
                }).catch(error=>{
                    console.log(error);
                    swal.fire(
                        'error!',
                        error.response.data.message,
                        'info'
                    )
                })
            },
            selectDataHerder() {
                axios.get('api/setting-header').then(response => {
                    this.headerData = response.data;
                    this.company_name = response.data.company_name;
                    this.description = response.data.description;
                })
            },
            pathPhoto() {
                return (this.logo.length > 200) ? this.logo : "../img/profile/" + this.headerData.logo;
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
                    this.logo = reader.result;

                };
                reader.readAsDataURL(file);
            },

            collapse() {
                var i = 0;
                const coll = document.getElementsByClassName("collapsibleheader");
                for (i = 0; i < coll.length; i++) {
                    coll[i].addEventListener("click", function () {
                        this.classList.toggle("active");
                        const content = this.nextElementSibling;
                        if (content.style.display === "block") {
                            content.style.display = "none";
                        } else {
                            content.style.display = "block";
                        }
                    });
                }
            },
        },
        created() {
            this.selectDataHerder();
        }
    }

</script>

<style scoped>
    /* Style the button that is used to open and close the collapsibleheader content */
    .collapsibleheader {
        background-color: #eee;
        color: #383d44;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
    }

    /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
    .active,
    .collapsibleheader:hover {
        background-color: #a67f59;
    }

    /* Style the collapsibleheader content. Note: hidden by default */
    .content {
        padding: 18px 18px;
        display: none;
        overflow: hidden;
        background-color: #f1f1f1;
    }
</style>


