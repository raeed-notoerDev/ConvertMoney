<template>
    <div>

        <button type="button" @click="collapse" class="collapsibleCountry"> Countries</button>
        <div class="content">
            <div class="field">
                <a class="button is-primary is-large modal-button" @click="modalCountry"
                   data-target="modal-bis">Add
                    New
                    Country</a>
            </div>

            <div class="columns">

                <div class="column">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <thead>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Status / Edit / Delete</th>
                        </thead>
                        <tr v-for="country in countries" :id="country.id">
                            <td>{{country.name}}</td>
                            <td v-if="country.block===0">
                                <span class="has-text-primary">ACTIVE</span>
                            </td>
                            <td v-else-if="country.block!==0">
                                <span class="has-text-danger">BLOCK</span>
                            </td>
                            <td v-if="country.block===0">
                                <input type="checkbox" checked
                                       @change="status_country(country.id)">
                                /
                                <a class="has-text-success" @click="editModalCountry(country)">
                                    <i class="fas fa-edit"></i>
                                </a>
                                /
                                <a class="has-text-danger" @click="delete_country(country)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <td v-else-if="country.block!==0">
                                <input type="checkbox" @change="status_country(country.id)"/>
                                /
                                <a class="has-text-success" @click="editModalCountry(country)">
                                    <i class="fas fa-edit"></i>
                                </a>
                                /
                                <a class="has-text-danger" @click="delete_country(country)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>


            </div>
            <!-- Modal -->
            <div class="modal" id="page-modal-country">
                <div class="modal-background"></div>
                <div class="modal-content" style="margin-top: 200px">
                    <form @submit.prevent="mode_country ? update_country():add_country()">
                        <div class="card">
                            <div class="card-header">
                                <label v-show="mode_country" class="label">Edit Name Country</label>
                                <label v-show="!mode_country" class="label">Name Country</label>
                            </div>
                            <div class="card-content">
                                <p class="control has-icons-left">
                                    <input
                                        class="input is-rounded"
                                        type="text"
                                        placeholder="Country"
                                        name="country"
                                        v-model="country"
                                    />
                                    <span class="icon is-small is-left">
                                  <i class="fas fa-dollar"></i>
                                </span>
                                </p>
                            </div>
                            <div class="card-footer">
                                <button v-show="!mode_country" class="input button is-primary" type="submit">Add
                                </button>
                                <button v-show="mode_country" class="input button is-primary" type="submit">Update
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
                <button class="modal-close is-large" aria-label="close"></button>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    export default {
        name: "Country",
        data() {
            return {
                country: "",
                countries: [],
                idCountry: "",
                statusCountry: "",
                mode_country: false
            };
        },
        methods: {
            delete_country(country) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Close',
                    confirmButtonText: 'Delete'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('api/setting-country/' + country.id).then(swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ));
                        Fire.$emit("AddCountry");
                    }
                })
            },
            update_country() {
                axios.patch('api/setting-country',
                    {
                        idCountry: this.idCountry,
                        country: this.country,
                        status: this.statusCountry
                    }).then([
                    Fire.$emit('AddCountry'),
                    this.country = "",
                    document.getElementById('page-modal-country').style.display = 'none'
                ]);
            },
            status_country(id) {
                axios.patch('api/country/' + id).then(response => {
                    Fire.$emit('AddCountry');
                    console.log(response.data.message);
                });
            },
            collapse() {
                const coll = document.getElementsByClassName("collapsibleCountry");
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
            modalCountry() {
                this.mode_country = false;
                this.idCountry = "";
                this.country = "";
                this.statusCountry = "";
                const modal = document.getElementById('page-modal-country');
                const close = document.getElementsByClassName('modal-close')[0];
                modal.style.display = 'block';
                close.onclick = function closeModal() {
                    modal.style.display = 'none';
                };
                window.onclick = function (event) {
                    if (event.target.className === 'modal-background') {
                        modal.style.display = 'none';
                    }
                };
            },
            editModalCountry(country) {
                this.mode_country = true;
                const modal = document.getElementById('page-modal-country');
                const close = document.getElementsByClassName('modal-close')[0];
                modal.style.display = 'block';
                close.onclick = function closeModal() {
                    modal.style.display = 'none';
                };
                window.onclick = function (event) {
                    if (event.target.className === 'modal-background') {
                        modal.style.display = 'none';
                    }
                };
                this.idCountry = country.id;
                this.country = country.name;
                this.statusCountry = country.block;
            },
            async add_country() {
                axios.post('api/country', {
                    country: this.country
                }).then([
                    Fire.$emit('AddCountry'),
                    this.country = "",

                ]);
                document.getElementById('page-modal-country').style.display = 'none';

                // // toast.fire({
                // //     icon: 'success',
                // //     title: 'Country Created Successfully'
                // // })
                swal.fire({
                    title: 'Country Added Successfully!',
                    // text: 'Do you want to continue',
                    icon: 'success',
                    confirmButtonText: 'Cool'
                })
            },
            allCountries() {
                axios.get('api/setting-country').then(response => {
                    // eslint-disable-next-line no-console
                    console.log(response.data);
                    this.countries = response.data.country_list;
                });
            }
        },
        created() {
            this.allCountries();
            Fire.$on('AddCountry', () => {
                this.allCountries();
            });
        }
    }

</script>

<style scoped>
    /* Style the button that is used to open and close the collapsibleCountry content */
    .collapsibleCountry {
        background-color: #eee;
        color: #444;
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
    .collapsibleCountry:hover {
        background-color: #aaa;
    }

    /* Style the collapsibleCountry content. Note: hidden by default */
    .content {
        padding: 18px 18px;
        display: none;
        overflow: hidden;
        background-color: #f1f1f1;
    }
</style>
