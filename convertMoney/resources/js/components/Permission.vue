<template>
    <div class="container is-fluid">
        <div class="level">
            <span class="is-size-2 level-left">Set Permissions</span>
            <span class="is-size-3 level-right">Print</span>
        </div>
        <hr>
        <div class="columns">
            <span class="is-size-4">Transactions</span>
        </div>
        <div class="columns">
            <div class="column">
                <input class="" type="checkbox" id="filter-transaction" v-model="roles.filter_transaction[0]['status']">
                <label for="filter-transaction">Transaction Filter </label>
            </div>
            <div class="column">
                <input class="" type="checkbox" id="block-transaction" v-model="roles.block_transaction[0]['status']">
                <label for="block-transaction">Transaction Block </label>
            </div>
            <div class="column">
                <input class="" type="checkbox" id="approve-transaction"
                       v-model="roles.approve_transaction[0]['status']">
                <label for="approve-transaction">Transaction Approve </label>
            </div>
            <div class="column">
                <input class="" type="checkbox" id="cancel-transaction" v-model="roles.cancel_transaction[0]['status']">
                <label for="cancel-transaction">Transaction Cancel </label>
            </div>
        </div>
        <hr>
        <div class="columns">
            <span class="is-size-4">Agents</span>
        </div>
        <div class="columns">
            <div class="column">
                <input class="" type="checkbox" id="agent-view" v-model="roles.agents_view[0]['status']">
                <label for="agent-view">Agents Views</label>
            </div>
            <div class="column">
                <input class="" type="checkbox" id="agent-register" v-model="roles.agent_register[0]['status']">
                <label for="agent-register">Agent Register</label>
            </div>

            <div class="column">
                <input class="" type="checkbox" id="agent-approve" v-model="roles.agents_accept[0]['status']">
                <label for="agent-approve">Agent Approve </label>
            </div>
            <div class="column">
                <input class="" type="checkbox" id="agent-block" v-model="roles.agents_block[0]['status']">
                <label for="agent-block">Agent Block</label>
            </div>
            <div class="column">
                <input class="" type="checkbox" id="agent-hold" v-model="roles.agents_hold[0]['status']">
                <label for="agent-hold">Agent Hold</label>
            </div>
            <div class="column">
                <input class="" type="checkbox" id="agent-profile" v-model="roles.agent_profile[0]['status']">
                <label for="agent-profile">Agent Profile Update</label>
            </div>
        </div>
        <hr>
        <div class="columns">
            <span class="is-size-4">Admins Users</span>
        </div>
        <div class="columns">
            <div class="column">
                <input class="" type="checkbox" id="user-view" v-model="roles.users_view[0]['status']">
                <label for="user-view">Users View</label>
            </div>

        </div>
        <hr>
        <div class="columns">
            <span class="is-size-4">Roles</span>
        </div>
        <div class="columns">
            <div class="column">
                <input class="" type="checkbox" id="role-view" v-model="roles.roles_view[0]['status']">
                <label for="role-view">Roles View</label>
            </div>
            <div class="column">
                <input class="" type="checkbox" id="role-add" v-model="roles.role_add[0]['status']">
                <label for="role-add">Role Add </label>
            </div>
            <div class="column">
                <input class="" type="checkbox" id="role-edit" v-model="roles.role_edit[0]['status']">
                <label for="role-edit">Role Edit </label>
            </div>

        </div>
        <hr>
        <button class="button is-rounded  is-success " @click="insert_permissions">Update</button>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Permission",
        data() {
            return {
                roles: {
                    cancel_transaction: [{status: false}, {name: 'cancel_transaction'}, {route: 'cancel.transaction'}],
                    approve_transaction: [{status: false}, {name: 'approve_transaction'}, {route: 'accept.transaction'}],
                    block_transaction: [{status: false}, {name: 'block_transaction'}, {route: 'block.transaction'}],
                    filter_transaction: [{status: false}, {name: 'filter_transaction'}, {route: 'filter.transaction'}],
                    agent_profile: [{status: false}, {name: 'agent_profile'}, {route: 'profile.update'}],
                    agent_register: [{status: false}, {name: 'agent_register'}, {route: 'member.register'}],
                    agents_block: [{status: false}, {name: 'agents_block'}, {route: 'member.block'}],
                    agents_hold: [{status: false}, {name: 'agents_hold'}, {route: 'member.hold'}],
                    agents_view: [{status: false}, {name: 'agents_view'}, {route: 'member.view'}],
                    agents_accept: [{status: false}, {name: 'agents_accept'}, {route: 'member.active'}],
                    users_view: [{status: false}, {name: 'users_view'}, {route: 'user.view'}],
                    roles_view: [{status: false}, {name: 'roles_view'}, {route: 'role.view'}],
                    role_add: [{status: false}, {name: 'role_add'}, {route: 'role.store'}],
                    role_edit: [{status: false}, {name: 'role_edit'}, {route: 'role.update'}],
                }
            }
        },
        methods: {
            get_permissions() {
                axios.get('/api/permission/' + this.$route.params.id).then(response => {
                    console.log(response.data);
                    var i;
                    for (i = 0; i < response.data.length; i++) {
                        console.log(response.data[i]['name']);
                        if (response.data[i]['name'] === 'agents_block') {
                            this.roles.agents_block[0]['status'] = true;
                            continue;
                        }

                        if (response.data[i]['name'] === 'users_view') {
                            this.roles.users_view[0]['status'] = true;
                            continue;
                        }

                        if (response.data[i]['name'] === 'role_add') {
                            this.roles.role_add[0]['status'] = true;
                            continue;
                        }

                        if (response.data[i]['name'] === 'roles_view') {
                            this.roles.roles_view [0]['status'] = true;
                            continue;
                        }

                        if (response.data[i]['name'] === 'role_edit') {
                            this.roles.role_edit[0]['status'] = true;
                            continue;
                        }
                        if (response.data[i]['name'] === 'cancel_transaction') {
                            this.roles.cancel_transaction[0]['status'] = true;
                            continue;
                        }
                        if (response.data[i]['name'] === 'approve_transaction') {
                            this.roles.approve_transaction[0]['status'] = true;
                            continue;
                        }
                        if (response.data[i]['name'] === 'block_transaction') {
                            this.roles.block_transaction[0]['status'] = true;
                            continue;
                        }
                        if (response.data[i]['name'] === 'filter_transaction') {
                            this.roles.filter_transaction[0]['status'] = true;
                            continue;
                        }
                        if (response.data[i]['name'] === 'agent_profile') {
                            this.roles.agent_profile[0]['status'] = true;
                            continue;
                        }
                        if (response.data[i]['name'] === 'agent_register') {
                            this.roles.agent_register[0]['status'] = true;
                            continue;
                        }
                        if (response.data[i]['name'] === 'agents_hold') {
                            this.roles.agents_hold[0]['status'] = true;
                            continue;
                        }
                        if (response.data[i]['name'] === 'agents_view') {
                            this.roles.agents_view[0]['status'] = true;
                            continue;
                        }
                        if (response.data[i]['name'] === 'agents_accept') {
                            this.roles.agents_accept[0]['status'] = true;
                            // continue;
                        }


                    }

                }).catch(error => {
                    swal.fire('Error', error.response.data.message, 'info');
                })
            },
            insert_permissions() {
                console.log(this.roles);
                axios.post('/api/permission', {
                    role_id: this.$route.params.id,
                    roles: this.roles,
                    // roles_name:this.roles_name,

                }).then(
                    response => {
                        // swal.fire('Updated', 'Updataed Successfully', 'success');
                        location.reload();
                    }
                ).catch(error => {
                    swal.fire('Error', error.response.data.message, 'info');
                });
            }
        }, created() {
            this.get_permissions();
        }
    }
</script>

<style scoped>

</style>
