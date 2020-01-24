<template>
    <div class="container">
        <div class="column"><strong class="is-size-4 level-left"> Transaction Payout</strong></div>
        <hr>
        <!--        <div class="columns" style="height: 120px"></div>-->
        <div class="field">
            <form @submit.prevent="searchit()">

                <div class="level">
                    <div class="level-item">
                        <label class="is-size-6 "> Search The Transactions Here By Entering TCN Number .The
                            Corresponding Transaction Details Will Be Displayed </label></div>
                </div>
                <div class="level">

                    <div class="level-item">

                        <label class="is-size-6 "> TCN: </label>
                    </div>

                </div>
                <div class=" level">
                    <div class="level-item"></div>
                    <div class="level-item">
                        <input type="search"
                               v-model="code"
                               placeholder="Enter TCN"
                               class="input is-rounded is-centered"/>
                    </div>
                    <div class="level-item">
                        <button type="submit" class="button is-primary "> Search</button>
                    </div>
                </div>

            </form>
        </div>
        <div class="field has-text-danger" v-if="errorMessage!== null">{{errorMessage}}</div>

        <div class="field level-item" v-if="transaction!== null">
            <table class="table is-striped is-center  is-narrow is-block">
                <thead>
                <tr>
                    <th>TCN</th>
                    <th>Sender Name </th>
                    <th>Beneficiary Name </th>
                    <th>Country From</th>
                    <th>Status</th>
                    <th>Transaction Date</th>
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
                    <td>{{ trans.country_from }}</td>

                    <td v-if="trans.status === 'hold'">
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
                    <td v-else-if="trans.status === 'paid'">
              <span class=" has-text-success">
                <i class="">PAID</i>
              </span>
                    </td>
                    <td v-else-if="transaction.status === 'cancelled'">
              <span class="has-text-danger">
                <i class="" style="background-color: #f14668"></i>CANCELLED
              </span>
                    </td>
                    <td>{{ trans.date | MyDate }}</td>
                </tr>

                </tbody>
            </table>
        </div>
        <div class="level-left" v-show="transaction===undefined">
            No Data Available
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
                }).catch(error => {
                    if (error.response.status === 404) {
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
