<template>
    <div>

        <button type="button" @click="collapse" class="collapsible"> Currencies</button>
        <div class="content">
            <div class="field">
                <a class="button is-primary is-large modal-button" @click="modal"
                   data-target="modal-bis">Add
                    New
                    Currency</a>
            </div>

            <div class="columns">

                <div class="column">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <thead>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Status / Edit / Delete</th>
                        </thead>
                        <tr v-for="currency in currencies" :id="currency.id">
                            <td>{{currency.name}}</td>
                            <td v-if="currency.block===0">
                                <span class="has-text-primary">ACTIVE</span>
                            </td>
                            <td v-else-if="currency.block!==0">
                                <span class="has-text-danger">BLOCK</span>
                            </td>
                            <td v-if="currency.block===0">
                                <input type="checkbox" checked
                                       @change="status_currency(currency.id)">
                                /
                                <a class="has-text-success" @click="editModal(currency)">
                                    <i class="fas fa-edit"></i>
                                </a>
                                /
                                <a class="has-text-danger" @click="delete_currency(currency)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <td v-else-if="currency.block!==0">
                                <input type="checkbox" @change="status_currency(currency.id)"/>
                                /
                                <a class="has-text-success" @click="editModal(currency)">
                                    <i class="fas fa-edit"></i>
                                </a>
                                /
                                <a class="has-text-danger" @click="delete_currency(currency)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>


            </div>
            <!-- Modal -->
            <div class="modal" id="page-modal">
                <div class="modal-background"></div>
                <div class="modal-content" style="margin-top: 200px">
                    <form @submit.prevent="mode ? update_currency():add_currency()">
                        <div class="card">
                            <div class="card-header">
                                <label v-show="mode" class="label">Edit Name Currency</label>
                                <label v-show="!mode" class="label">Name Currency</label>
                            </div>
                            <div class="card-content">
                                <p class="control has-icons-left">
                                    <input
                                        class="input is-rounded"
                                        type="text"
                                        placeholder="Currency"
                                        name="name"
                                        v-model="name"
                                    />
                                    <span class="icon is-small is-left">
                                  <i class="fas fa-dollar"></i>
                                </span>
                                </p>
                            </div>
                            <div class="card-footer">
                                <button v-show="!mode" class="input button is-primary" type="submit">Add</button>
                                <button v-show="mode" class="input button is-primary" type="submit">Update</button>
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
        name: "Currency",
        data() {
            return {
                name: "",
                currencies: [],
                id: "",
                status: "",
                mode: false
            };
        },
        methods: {
            delete_currency(currency) {
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
                        axios.delete('api/setting-currency/' + currency.id).then(swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ));
                        Fire.$emit("AddCurrency");
                    }
                })
            },
            update_currency() {
                axios.patch('api/setting-currency',
                    {
                        id: this.id,
                        name: this.name,
                        status: this.status
                    }).then([
                    Fire.$emit('AddCurrency'),
                    this.name = "",
                    document.getElementById('page-modal').style.display = 'none'
                ]);
            },
            status_currency(id) {
                axios.patch('api/currency/' + id).then(response => {
                    Fire.$emit('AddCurrency');
                    console.log(response.data.message);
                });
            },
            collapse() {
                const coll = document.getElementsByClassName("collapsible");
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
            modal() {
                this.mode = false;
                this.id = "";
                this.name = "";
                this.status = "";
                const modal = document.getElementById('page-modal');
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
            editModal(currency) {
                this.mode = true;
                const modal = document.getElementById('page-modal');
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
                this.id = currency.id;
                this.name = currency.name;
                this.status = currency.block;
            },
            async add_currency() {
                axios.post('api/currency', {
                    name: this.name
                }).then([
                    Fire.$emit('AddCurrency'),
                    this.name = "",

                ]);
                document.getElementById('page-modal').style.display = 'none';

                // // toast.fire({
                // //     icon: 'success',
                // //     title: 'Currency Created Successfully'
                // // })
                swal.fire({
                    title: 'Currency Added Successfully!',
                    // text: 'Do you want to continue',
                    icon: 'success',
                    confirmButtonText: 'Cool'
                })
            },
            async allCurrencies() {
                axios.get('api/setting-currency').then(response => {
                    // eslint-disable-next-line no-console
                    console.log(response.data);
                    this.currencies = response.data.currency_list;
                });
            }
        },
        created() {
            this.allCurrencies();
            Fire.$on('AddCurrency', () => {
                this.allCurrencies();
            });
        }
    }

</script>

<style scoped>
    /* Style the button that is used to open and close the collapsible content */
    .collapsible {
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
    .collapsible:hover {
        background-color: #cacc;
    }

    /* Style the collapsible content. Note: hidden by default */
    .content {
        padding: 18px 18px;
        display: none;
        overflow: hidden;
        background-color: #f1f1f1;
    }
</style>
