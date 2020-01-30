<template>
    <div class="container-fluid">

        <div class="level">
            <strong class="is-size-3 level-left"> USERS ADMINS</strong>
            <button class="button level-right print-none" @click="printData"><i class="fas fa-print"></i>print</button>
        </div>

        <hr>
        <!--        {{$gate.isAllows()}}-->
        <div class="table-container">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>User Name</th>
                    <th>User Log</th>
                    <th>Role</th>
                    <th>Nationality</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Registered At</th>
                    <th><span class="level-item">Control</span></th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="user in users" :key="user.ref_id">
                    <td>
                        <!--                        <router-link-->
                        <!--                            :to="{ name: 'profile', params: { code: user.ref_id } }"-->
                        <!--                        >-->
                        <!--                            {{ user.ref_id }}-->
                        <!--                        </router-link>-->
                        {{ user.ref_id }}
                    </td>
                    <td>{{ user.first_name }} {{ user.last_name }}</td>
                    <td>{{ user.user_name }}</td>
                    <td class="is-size-5">
                        <span class="icon has-text-danger ">{{ user.role }}</span>
                    </td>
                    <td>{{ user.nationality }}</td>

                    <td v-if="user.status === 'block'">
              <span class="icon has-text-danger">
                <i class="fas fa-ban"></i>
                  BLOCK
              </span>
                    </td>
                    <td v-else-if="user.status === 'active'">
              <span class="icon has-text-info">
                <i class="fas fa-info-circle"></i>
                  ACTIVE
              </span>
                    </td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone_number }}</td>

                    <td>{{ user.address }}</td>
                    <td>{{ user.created_at | MyDate }}</td>
                    <td>
                        <div class="columns">
                            <div class="column" v-if="block_agent===true">
                                <button
                                    @click="block_member(user.ref_id)"
                                    class="button is-danger is-outlined is-size-7 is-rounded"
                                >
                                    Block
                                </button>
                            </div>
                            <div class="column">
                                <button
                                    @click="accept_member(user.ref_id)"
                                    class="button is-success is-outlined is-size-7 is-rounded"
                                >
                                    Activate
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
        name: "User",
        data() {
            return {
                users: {},
                block_agent: false
            };
        },
        methods: {
            printData() {
                window.print()
            },
            get_users() {
                console.log('permissions');
                console.log(permissions);
                var i;
                if (permissions.length === 0) {
                    axios.get('api/select-permission').then(response => {
                        permissions = response.data;
                        console.log(permissions);
                        console.log('user');
                        for (i = 0; i < permissions.length; i++) {
                            console.log('foe');
                            console.log(permissions.length);
                            if (permissions[i]['name'] === 'agents_block') {
                                this.block_agent = true;
                            }
                            if (permissions[i]['name'] === 'users_view') {
                                axios.get('api/user')
                                    .then(({data}) => this.users = data)
                                    .catch(error => {
                                        console.log(error)
                                    });
                                break;
                            }
                        }

                    });

                }
                for (i = 0; i < permissions.length; i++) {
                    if (permissions[i]['name'] === 'users_view') {
                        axios.get('api/user')
                            .then(({data}) => this.users = data)
                            .catch(error => {
                                console.log(error)
                            });
                        break;
                    }
                    if (permissions[i]['name'] === 'agents_block') {
                        this.block_agent = true;
                    }
                }
            },
            async block_member(ref_id) {
                var i;
                for (i = 0; i < permissions.length; i++) {
                    if (permissions[i]['name'] === 'agents_block') {
                        await axios.post('api/block-member', {
                            ref_id: ref_id
                        }).then(
                            // eslint-disable-next-line no-undef
                            console.log(ref_id),
                            // eslint-disable-next-line no-undef
                            swal.fire("Member Blocked!", "the user has been blocked", "success")
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
                        Fire.$emit("select_users");
                        break;
                    }

                }
            },
            async accept_member(ref_id) {
                await axios.post('api/active-member', {
                        ref_id: ref_id
                    }
                )
                    .then(
                        // eslint-disable-next-line no-undef
                        swal.fire("Member Active!", "the user has been activate", "success")
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
                Fire.$emit("select_users");
            },
            // async is_admin() {
            //     // eslint-disable-next-line no-undef
            //     await new Gate().isAdmin;
            // }
        },
        created() {
            Fire.$on("select_users", () => {
                this.get_users();
            });

            Fire.$emit('select_users');
        }
    };
</script>

<style scoped></style>
