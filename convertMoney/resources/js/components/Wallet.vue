<template>
    <div class="container-fluid">
        <div class="level">
            <div class=""><strong class="is-size-4 level-left"> AGENTS LIST</strong></div>
            <div class=""><button class="button level-right print-none" @click="printData"><i class="fas fa-print"></i>print</button></div>
        </div>
        <hr>
        <div class="table-container">
            <table class="table is-striped is-hoverable is-narrow is-block">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Agent Name</th>
                    <th>User Name</th>
                    <th>Gender</th>
                    <th>Nationality</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Commission</th>
                    <th>Amount</th>
                    <th>Address</th>
                    <th>Registered At</th>
                    <th><span class="level-item">Control</span></th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="member in members" :key="member.ref_id">
                    <td>
                        <router-link
                            :to="{ name: 'profile', params: { code: member.ref_id } }"
                        >
                            {{ member.ref_id }}
                        </router-link>
                    </td>
                    <td>{{ member.first_name }} {{ member.last_name }}</td>
                    <td>{{ member.user_name }}</td>
                    <td>{{ member.gender }}</td>
                    <td>{{ member.nationality }}</td>
                    <td v-if="member.status === 'hold'">
              <span class="icon has-text">
                <i class="fas fa-spinner fa-pulse"></i>
                  HOLD
              </span>
                    </td>
                    <td v-else-if="member.status === 'block'">
              <span class="icon has-text-danger">
                <i class="fas fa-ban"></i>
                  BLOCK
              </span>
                    </td>
                    <td v-else-if="member.status === 'active'">
              <span class="icon has-text-info">
                <i class="fas fa-info-circle"></i>
                  ACTIVE
              </span>
                    </td>
                    <td>{{ member.email }}</td>
                    <td>{{ member.phone_number }}</td>
                    <td>{{ member.agent_commission }}%</td>
                    <td>{{ member.wallet }}</td>
                    <td>{{ member.address }}</td>
                    <td>{{ member.created_at | MyDate }}</td>
                    <td>
                        <div class="columns">
                            <div class="column">
                                <div
                                    @click="addModal(member.ref_id)"
                                    class="has-text-success">
                                    <a class="button">
                                        <i class="fas fa-plus"></i>Account
                                    </a>
                                </div>
                            </div>
                            <div class="column">
                                <div
                                    @click="editModal(member)"
                                    class="has-text-primary">
                                    <a class="button">
                                        <i class="fas fa-dollar-sign"></i>Commission
                                    </a>
                                </div>
                            </div>
                            <div class="column">

                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal" id="page-modal">
            <div class="modal-background"></div>
            <div class="modal-content" style="margin-top: 200px">
                <form @submit.prevent="mode_modal ? update_commission():add_wallet()">
                    <div class="card">
                        <div class="card-header level">
                            <label v-show="mode_modal" class="label level-left">Edit Commission</label>
                            <label v-show="!mode_modal" class="label level-left">Add Amount For Account</label>
                            <div class="button level-right modal-exit"> Close</div>
                        </div>
                        <div class="card-content">
                            <p class="control has-icons-left">
                                <input
                                    class="input is-rounded"
                                    type="text"
                                    placeholder="Amount"
                                    name="country"
                                    v-model="amount"
                                />
                                <span class="icon is-small is-left">
                                  <i class="fas fa-dollar"></i>
                                </span>
                            </p>
                        </div>
                        <div class="card-footer">
                            <button v-show="!mode_modal" class="input button is-primary" type="submit">Add
                            </button>
                            <button v-show="mode_modal" class="input button is-primary" type="submit">Update
                            </button>
                        </div>
                    </div>


                </form>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Wallet",
        data() {
            return {
                members: {},
                amount: "",
                agent: "",
                mode_modal: false,
                commission: ""
            };
        },
        methods: {
            printData(){
                window.print()
            },
            update_commission() {
                axios.patch('api/commission', {
                    commission: this.amount,
                    ref_id: this.agent
                }).then(response => {
                    swal.fire('Updated Successfully', 'The Commission Has Been Updated ', 'success')
                })
                    .catch(error => {
                        console.log(error);
                        swal.fire('wrong', 'this Commission Not Updated ', 'error')
                    });
                this.amount = "";
                const modal = document.getElementById('page-modal');
                modal.style.display = 'none';
                Fire.$emit("AfterCreate");
            },
            add_wallet() {
                axios.post('api/wallet', {
                    amount: this.amount,
                    agent: this.agent
                }).then(response => {
                    this.amount = "";
                    swal.fire('Added Successfully', 'The Amount Has Been Added ', 'success')
                })
                    .catch(error => {
                        console.log(error);
                        swal.fire('wrong', 'this account not added ', 'info')
                    });
                const modal = document.getElementById('page-modal');
                modal.style.display = 'none';
                Fire.$emit("AfterCreate");
            },
            addModal(ref_id) {
                this.agent = ref_id;
                const modal = document.getElementById('page-modal');
                const close = document.getElementsByClassName('modal-exit')[0];
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
            editModal(member) {
                this.mode_modal = true;
                this.amount = member.agent_commission;
                const modal = document.getElementById('page-modal');
                const close = document.getElementsByClassName('modal-exit')[0];
                modal.style.display = 'block';
                close.onclick = function closeModal() {
                    modal.style.display = 'none';
                    this.mode_modal = false;
                };
                window.onclick = function (event) {
                    if (event.target.className === 'modal-background') {
                        modal.style.display = 'none';
                        this.mode_modal = false;
                    }
                };
                this.agent = member.ref_id;
            },
            async get_membrs() {
                await axios
                    .get('api/member')
                    .then(({data}) => this.members = data)

                    .catch(error => {
                        console.log(error)
                    });
            },
            async block_member(ref_id) {
                await axios.post('api/block-member', {
                    ref_id: ref_id
                }).then(
                    // eslint-disable-next-line no-undef
                    console.log(ref_id),
                    // eslint-disable-next-line no-undef
                    // swal.fire("Member Blocked!", "You clicked the button!", "success")
                )
                    .catch(error => {
                        // eslint-disable-next-line no-undef
                        console.log(error)
                        // swal.fire({
                        //     icon: "error",
                        //     title: error.data,
                        //     text: error,
                        //     footer: "<a href>Why do I have this issue?</a>"
                        // });
                    });
                Fire.$emit("AfterCreate");
            },
            async hold_member(ref_id) {
                await axios.post('api/hold-member', {
                    ref_id: ref_id
                }).then(
                    // eslint-disable-next-line no-undef

                    // eslint-disable-next-line no-undef
                    // swal.fire("Member Hold!", "You clicked the button!", "success")
                )
                    .catch(error => {
                        // eslint-disable-next-line no-undef
                        // swal.fire({
                        //     icon: "error",
                        //     title: error.data,
                        //     text: error,
                        //     footer: "<a href>Why do I have this issue?</a>"
                        // });
                    });
                Fire.$emit("AfterCreate");
            },

            async accept_member(ref_id) {
                await axios.post('api/active-member', {
                        ref_id: ref_id
                    }
                )
                    .then(
                        // eslint-disable-next-line no-undef

                        // eslint-disable-next-line no-undef
                        // swal.fire("Member Accepted!", "You clicked the button!", "success")
                    )
                    .catch(error => {
                        // eslint-disable-next-line no-undef
                        // swal.fire({
                        //     icon: "error",
                        //     title: error.data,
                        //     text: error,
                        //     footer: "<a href>Why do I have this issue?</a>"
                        // });
                    });
                Fire.$emit("AfterCreate");
            },
            // async is_admin() {
            //     // eslint-disable-next-line no-undef
            //     await new Gate().isAdmin;
            // }
        },
        created() {
            this.get_membrs();

            Fire.$on("AfterCreate", () => {
                this.get_membrs();
            });
        }
    };
</script>

<style scoped></style>
