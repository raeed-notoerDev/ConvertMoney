<template>
    <div class="container">

        <div class="columns" style="height: 200px"></div>
        <div class="field">
            <form @submit.prevent="searchit()">

                <div class="columns">

                    <div class="column"><label class="is-size-1"> Search For Transaction </label></div>

                </div>
                <div class=" level">
                    <div class="level-item"></div>
                    <div class="level-item">
                        <input type="search"
                               v-model="code"
                               class="input is-rounded is-centered"/>
                    </div>
                    <div class="level-item">
                        <button type="submit" class="button is-primary "> Search</button>
                    </div>
                </div>

            </form>
        </div>
        <div class="field has-text-danger" v-if="errorMessage!== null">{{errorMessage}}</div>
        <div class="field" v-if="transaction!== null">
            <table class="table is-striped is-hoverable is-narrow is-block">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Sender Consumer</th>
                    <th>Receiver Consumer</th>
                    <th>Tax</th>
                    <th>Commission</th>
                    <th>Sender Currency</th>
                    <th>Receiver Currency</th>
                    <th>Total Money</th>
                    <th>Destination City</th>
                    <th>Status</th>
                    <th>Sender Agent</th>
                    <th>Receiver Agent</th>
                    <th>Convert Price</th>
                    <th>Create Date</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="trans in transaction">
                    <td>
                        <router-link
                            :to="{ name: 'receiver', params: { code: code } }"
                        >
                            {{ trans.code }}
                        </router-link>
                    </td>
                    <td>{{ trans.name_sender }}</td>
                    <td>{{ trans.name_receiver }}</td>
                    <td>{{ trans.tax }}</td>
                    <td>{{ trans.commission }}</td>
                    <td>{{ trans.currency_sender }}</td>
                    <td>{{ trans.currency_receiver }}</td>
                    <td>{{ trans.total_money }}</td>
                    <td>{{ trans.city_destination }}</td>
                    <td v-if="trans.status === 'holed'">
                        <span class=" has-text"> <i class=" "> </i>HOLD </span>
                    </td>
                    <td v-else-if="trans.status === 'blocked'">
              <span class=" has-text-danger">
                <i class="">BLOCKED </i>
              </span>
                    </td>
                    <td v-else-if="trans.status === 'approved'">
              <span class=" has-text-info">
                <i class="">APPROVED</i>
              </span>
                    </td>
                    <td v-else-if="trans.status === 'received'">
              <span class=" has-text-success">
                <i class="">RECEIVED</i>
              </span>
                    </td>
                    <td v-else-if="transaction.status === 'cancelled'">
              <span class="has-text-danger">
                <i class="" style="background-color: #f14668"></i>CANCELLED
              </span>
                    </td>
                    <td>{{ trans.agent_sender }}</td>
                    <td>{{ trans.agent_receiver }}</td>
                    <td>{{ trans.convert_price }}</td>
                    <td>{{ trans.date  | MyDate }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <circle-spin v-show="isLoading"></circle-spin>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "SearchTransaction",
        data() {
            return {
                code: '',
                isLoading: false,
                transaction: null,
                errorMessage: null,
            }
        },
        methods: {

            find_transaction: _.debounce(() => {

                Fire.$emit('searching');
            }, 1500),
            searchit() {
                if (this.code !== '') {
                    this.errorMessage = null;
                    this.transaction = null;
                    this.isLoading = true;
                    Fire.$emit('searchit');
                }
            }
        },
        created() {
            Fire.$on('searching', () => {

                axios.post('/api/find-transaction/' + this.code).then(response => {
                    this.transaction = response.data.transaction;
                    console.log(response)
                }).catch(error =>{
                    if (error.response.status === 404){
                        this.errorMessage = 'this code not true !!'
                    }
                });
                this.isLoading = false;
            });
            Fire.$on('searchit', () => {
                this.find_transaction();
            });
        }
    }
</script>

<style scoped>

</style>
