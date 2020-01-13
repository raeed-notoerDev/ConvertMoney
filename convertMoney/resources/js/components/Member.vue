<template>
    <div class="home">
        <div class="table-container">
            <table class="table is-striped is-hoverable is-narrow is-block">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Nationality</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Agent Commission</th>
                    <th>Wallet</th>
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
                    <td>{{ member.first_name }}</td>
                    <td>{{ member.last_name }}</td>
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
                    <td>{{ member.agent_commission }}</td>
                    <td>{{ member.wallet }}</td>
                    <td>{{ member.address }}</td>
                    <td>{{ member.created_at | MyDate }}</td>
                    <td>
                        <div class="columns">
                            <div class="column">
                                <button
                                    @click="block_member(member.ref_id)"
                                    class="button is-danger is-outlined is-size-7 is-rounded"
                                >
                                    Block
                                </button>
                            </div>
                            <div class="column">
                                <button
                                    @click="accept_member(member.ref_id)"
                                    class="button is-success is-outlined is-size-7 is-rounded"
                                >
                                    Activate
                                </button>
                            </div>
                            <div class="column">
                                <button
                                    @click="hold_member(member.ref_id)"
                                    class="button is-link is-outlined is-size-7 is-rounded"
                                >
                                    Hold
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Member",
        data() {
            return {
                members: {}
            };
        },
        methods: {
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
