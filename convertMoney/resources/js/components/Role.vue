<template>
    <div class="container">
        <div class="level">
            <div class="level-left">
                <span class="is-size-2">Roles</span>
            </div>
            <div class="level-right">
                <div class="button" @click="print">Print</div>
            </div>
        </div>
        <hr>
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
            <tr>
                <th class="has-text-danger">ID</th>
                <th class="has-text-danger">Role</th>
                <th class="has-text-danger">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="role in roles" :key="role.id">
                <td>
                    {{role.id}}
                </td>
                <td class="is-size-3">{{role.name}}</td>
                <td>
                    <div class="columns">
                        <div class="column">
                            <router-link class="button has-background-primary"
                                         :to="{ name: 'permission', params: { id: role.id } }">
                                Permission
                            </router-link>
                        </div>
                        <div class="column">
                            <div class="button has-background-primary">
                                <i class="fas fa-edit"></i>Edit
                            </div>
                        </div>
                        <div class="column">
                            <div class="button has-background-danger">
                                <i class="fa fa-trash"></i>Delete
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

    </div>

</template>

<script>
    import axios from "axios";

    export default {
        name: "Role",
        data() {
            return {
                roles: []
            }
        },
        methods: {
            print(){
                window.print()
            },
            get_roles() {
                var i;
                if (permissions.length === 0) {
                    axios.get('api/select-permission').then(response => {
                        permissions = response.data;
                        for (i = 0; i < permissions.length; i++) {
                            if (permissions[i]['name'] === 'roles_view') {
                                axios.get('api/role')
                                    .then(({data}) => this.roles = data)
                                    .catch(error => {
                                        console.log(error)
                                    });
                                break;
                            }
                        }
                    });
                }
                for (i = 0; i < permissions.length; i++) {
                    if (permissions[i]['name'] === 'roles_view') {
                        axios.get('api/role')
                            .then(({data}) => this.roles = data)
                            .catch(error => {
                                console.log(error)
                            });
                        break;
                    }
                }
            },
        },
        created() {
            Fire.$on("select_roles", () => {
                this.get_roles();
            });
            Fire.$emit('select_roles');
        }
    }
</script>

<style scoped>

</style>
