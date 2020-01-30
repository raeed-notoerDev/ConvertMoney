<template>
    <div class="container-fluid">
        <div class="level">
            <div class="column"><strong class="is-size-3 level-left"> Transaction Reports</strong></div>
            <div class="level-right print-none">
                <!--            <export-excel-->
                <!--                class="button column is-1 is-small is-outlined is-fullwidth is-size-6   "-->
                <!--                :data="transactions">-->
                <!--                <i class="fas fa-file-excel"> </i> Excel-->
                <!--            </export-excel>-->
                <div class=" button is-fullwidth " @click="someJSONdata">
                    <i class="fas fa-print"></i> Print
                </div>
            </div>
        </div>

        <hr>
        <div class="columns">
            <div class="column">
                <label>Date From</label>
                <input
                    type="date"
                    data-display-mode="inline"
                    data-is-range="true"
                    data-close-on-select="false"
                    v-model="date_from"
                />
            </div>
            <div class="column">
                <label>Date To</label>
                <input
                    type="date"
                    data-display-mode="inline"
                    data-is-range="true"
                    data-close-on-select="false"
                    v-model="date_to"
                />
            </div>
            <div class="column">
                Status
                <div class="select">
                    <select v-model="status">
                        <option>all</option>
                        <option value="paid">PaidOut</option>
                        <option value="hold">Hold</option>
                        <option value="blocked">Blocked</option>
                        <option value="approved">Approved</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="waiting">Waiting</option>
                    </select>
                </div>
            </div>

            <div class="column" v-if="result===true">
                Agents
                <div class="select">
                    <select v-model="agent">
                        <option id="all" value="all">all</option>
                        <option
                            v-for="agent in agents"
                            :key="agent.id"
                            :id="agent.id"
                            :value="agent.ref_id"
                        >{{ agent.user_name}}
                        </option>
                    </select>
                </div>
            </div>

            <div class="column">
                <button v-if="result===true"
                        @click="filter_transaction"
                        class="button is-rounded is-outlined is-primary print-none"
                >
                    Filter
                </button>
                <button v-else-if="result_client===true"
                        @click="filter_transaction_client"
                        class="button is-rounded is-outlined is-primary print-none"
                >
                    Filter
                </button>
            </div>
        </div>

        <div class="table-container">


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
                <tr
                    v-for="transaction in transactions"
                    :key="transaction.code"
                >
                    <td>
                        <router-link
                            :to="{ name: 'details', params: { code: transaction.code } }"
                        >
                            {{ transaction.code }}
                        </router-link>
                    </td>
                    <td>{{ transaction.sender_consumer_name }}</td>
                    <td>{{ transaction.receiver_consumer_name }}</td>
                    <td>{{ transaction.tax }}</td>
                    <td>{{ transaction.commission }}</td>
                    <td>{{ transaction.currency_sender_id }}</td>
                    <td>{{ transaction.currency_receiver_id }}</td>
                    <td>{{ transaction.total_money }}</td>
                    <td>{{ transaction.city_destination }}</td>
                    <td v-if="transaction.status === 'hold'">
                        <span class=" has-text"> <i class=" "> </i>HOLD </span>
                    </td>
                    <td v-else-if="transaction.status === 'blocked'">
              <span class=" has-text-danger">
                <i class="">BLOCKED </i>
              </span>
                    </td>
                    <td v-else-if="transaction.status === 'approved'">
              <span class=" has-text-info">
                <i class="">APPROVED</i>
              </span>
                    </td>
                    <td v-else-if="transaction.status === 'paid'">
              <span class=" has-text-success">
                <i class="">PAIDOUT</i>
              </span>
                    </td>
                    <td v-else-if="transaction.status === 'cancelled'">
              <span class="has-text-danger">
                <i class="" style="background-color: #f14668"></i>CANCELLED
              </span>
                    </td>
                    <td v-else-if="transaction.status === 'waiting'">
              <span class="has-text-warning">
                <i class="" style="background-color: #f14668"></i>WAITED
              </span>
                    </td>
                    <td>{{ transaction.agent_sender }}</td>
                    <td>{{ transaction.agent_receiver }}</td>
                    <td>{{ transaction.convert_price }}</td>
                    <td>{{ transaction.date | myDate }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    import axios from "axios";


    export default {
        name: "Transaction",
        data() {
            return {
                status: "all",
                date_from: "all",
                date_to: "all",
                agent: "all",
                search: "",
                transactions: [],
                agents: [],
                code: null,
                transfer: {},
                result: false,
                result_client: false
            };
        },
        methods: {
            isAdmin() {
                axios.get('api/select-role').then(response => {
                    console.log(response.data.admin);
                    this.result = response.data.admin;
                    this.result_client = response.data.client;
                    console.log(this.result);
                    if (this.result === true)
                        Fire.$emit('is_Admin');
                });
            },
            someJSONdata() {
                // printJS({
                //     printable: this.transactions,
                //     properties: ['code', 'sender_consumer_name', 'receiver_consumer_name', 'tax', 'commission', 'currency_sender_id', 'currency_receiver_id', 'total_money', 'city_destination', 'status', 'agent_sender', 'agent_receiver', 'convert_price', 'date'],
                //     type: 'json',
                //     gridHeaderStyle: 'color: red;  border: 2px solid #3971A5;',
                //     gridStyle: 'border: 2px solid #3971A5;'
                // });
                window.print()
            },
            async filter_transaction() {
                if (this.date_from === "")
                    this.date_from = 'all';
                if (this.date_to === "")
                    this.date_to = 'all';
                await axios.post(
                    'api/filter-transactions',
                    {
                        status: this.status,
                        date_from: this.date_from,
                        date_to: this.date_to,
                        agent: this.agent,

                    }
                ).then(response => {
                    console.log(response);
                    this.transactions = response.data
                })
                    .catch(error => {
                        // eslint-disable-next-line no-console
                        console.log(error);
                    });
            },
            async filter_transaction_client() {
                if (this.date_from === "")
                    this.date_from = 'all';
                if (this.date_to === "")
                    this.date_to = 'all';
                await axios.post(
                    'api/filter-transactions-client',
                    {
                        status: this.status,
                        date_from: this.date_from,
                        date_to: this.date_to,
                    }
                ).then(response => {
                    console.log(response);
                    this.transactions = response.data
                })
                    .catch(error => {
                        // eslint-disable-next-line no-console
                        console.log(error);
                    });
            },
            async details(code) {
                this.$router.push("/details/" + code)
            },
            async selectAllAgents() {
                await axios
                    .get('api/member')
                    .then(
                        ({data}) =>
                            this.agents = data
                    )
            },
            // details_transaction(code) {
            //     this.code = code;
            //     // eslint-disable-next-line no-console
            //     console.log(this.code);
            //     service
            //         .detailsTransaction({
            //             code: this.code
            //         })
            //         // eslint-disable-next-line no-console
            //         .then(response => (this.transfer = response.data.transaction));
            // }
        },
        created() {
            this.isAdmin();
            Fire.$on('is_Admin', () => {
                this.selectAllAgents();
            });


        }
    };
</script>
