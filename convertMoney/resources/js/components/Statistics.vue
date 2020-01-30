<template>
    <div class="container is-fluid">
        <div class="column"><strong class="is-size-5 level-left"> DASHBOARD</strong></div>
        <div class="columns agents">
            <div class="column">
                <div class="card ">
                    <header class="card-header">
                        <div class=""><strong class=" heading">Total NO OF Transactions </strong></div>
                        <div class="column"></div>
                        <div class=""><i class="fas fa-exchange-alt is-size-4"> </i> <i
                            class="fas fa-dollar-sign is-size-4"> </i></div>

                    </header>
                    <div class="card-content">
                        <div class="level is-size-3">
                            <div class="level-left">{{transactions_total}}</div>
                        </div>
                        <div class="columns">
                            <p class="is-bold">waiting :</p>
                            <p class="level-item tag  is-warning"> {{transactions_wait}}</p>
                        </div>
                        <div class="columns"><p>approved :
                            <p class="level-item tag  is-success"> {{transactions_approved}}</p></div>
                        <div class="columns">
                            <p>paid :
                            <p class="level-item tag is-light is-success"> {{transactions_paid}}</p></div>
                        <div class="columns"><p>cancelled :
                            <p class="level-item tag  is-danger"> {{transactions_cancel}}</p></div>
                        <div class="columns"><p>hold :
                            <p class="level-item tag"> {{transactions_hold}}</p></div>
                        <div class="columns"><p>blocked :
                            <p class="level-item tag is-light is-danger"> {{transactions_blocked}}</p></div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card ">
                    <header class="card-header">
                        <div class=" "><strong class="heading ">Percentages OF Transactions</strong>
                        </div>
                        <div class="column"></div>
                        <div class=""><i class="fas fa-exchange-alt is-size-4"> </i> <i
                            class="fas fa-percentage is-size-4"> </i></div>

                    </header>
                    <div class="card-content">
                        <div class="tags ">
                            <span class="tag heading is-link is-light">0.8 %</span>
                            <!--                            <div class="" style="width:39px;background: red">0.8 %</div>-->
                            <div class=" "> down from</div>
                            <span class="tag is-success is-light ">  paid </span>
                            Transaction
                        </div>

                        <div class="tags ">
                            <span class="tag heading is-link is-light">0.8 %</span>
                            <!--                            <div class="" style="width:39px;background: red">0.8 %</div>-->
                            <div class=" "> down from</div>
                            <span class="tag is-success  ">  approved </span>
                            Transaction
                        </div>
                        <div class="tags ">
                            <span class="tag heading is-link is-light">0.8 %</span>
                            <!--                            <div class="" style="width:39px;background: red">0.8 %</div>-->
                            <div class=" "> down from</div>
                            <span class="tag is-danger  ">  cancelled </span>
                            Transaction
                        </div>
                        <div class="tags ">
                            <span class="tag heading is-link is-light">0.8 %</span>
                            <!--                            <div class="" style="width:39px;background: red">0.8 %</div>-->
                            <div class=" "> down from</div>
                            <span class="tag   ">  hold </span>
                            Transaction
                        </div>
                        <div class="tags ">
                            <span class="tag heading is-link is-light">0.8 %</span>
                            <!--                            <div class="" style="width:39px;background: red">0.8 %</div>-->
                            <div class=" "> down from</div>
                            <span class="tag is-light  is-danger">  blocked </span>
                            Transaction
                        </div>
                    </div>

                </div>

            </div>
            <div class="column ">
                <div class="card " style="height: 315px">
                    <header class="card-header">
                        <div class=" "><strong class="heading is-size-5">Users Admins</strong>
                        </div>
                        <div class="column"></div>
                        <div class=""><i class="fas fa-users is-size-4"></i></div>
                    </header>
                    <div class="card-content">
                        <div class="level is-size-2">
                            <div class="level-left">{{users_total}}</div>
                        </div>
                        <div class="columns"><p>Admins :
                            <p class="level-item tag  is-light is-danger"> {{users_admins}}</p></div>
                        <div class="columns"><p>users :
                            <p class="level-item tag  is-danger is-light"> {{users_sub_admins}}</p></div>
                    </div>

                </div>

            </div>
            <div class="column ">
                <div class="card " style="height: 315px">
                    <header class="card-header">
                        <div class=" "><strong class="heading is-size-5">AGENTS</strong>
                        </div>
                        <div class="column"></div>
                        <div class=""><i class="fas fa-user-tie is-size-4"></i></div>
                    </header>
                    <div class="card-content">
                        <div class="level is-size-3">
                            <div class="level-left">{{agents_total}}</div>
                        </div>

                        <div class="columns"><p>approved :
                            <p class="level-item tag  is-success"> {{agents_activated}}</p></div>

                        <div class="columns"><p>hold :
                            <p class="level-item tag"> {{agents_holds}}</p></div>
                        <div class="columns"><p>blocked :
                            <p class="level-item tag is-light is-danger"> {{agents_blocked}}</p></div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Statistics",
        data() {
            return {
                agents_total:0,
                agents_blocked:0,
                agents_activated:0,
                agents_holds:0,
                users_sub_admins:0,
                users_admins:0,
                users_total:0,
                transactions_total:0,
                transactions_wait:0,
                transactions_paid:0,
                transactions_approved:0,
                transactions_blocked:0,
                transactions_hold:0,
                transactions_cancel:0,
            }
        },
        methods: {
            get_users_details() {
                axios.get('api/statistics').then(response=>{
                    this.agents_total =response.data.agents;
                    this.users_total =response.data.users;
                    this.users_admins =response.data.users_sub_admins;
                    this.agents_activated =response.data.agents_approved;
                    this.agents_holds =response.data.agents_hold;
                    this.users_admins =response.data.users_admins;
                    this.transactions_total =response.data.transactions;
                    this.transactions_wait =response.data.transactions_waiting;
                    this.transactions_paid =response.data.transactions_paid;
                    this.transactions_approved =response.data.transactions_approved;
                    this.transactions_hold =response.data.transactions_holds;
                    this.transactions_cancel =response.data.transactions_cancelled;
                    this.transactions_blocked =response.data.transactions_blocked;
                });
            }
        }, created() {
            this.get_users_details();
        }
    }
</script>

<style scoped>
    .container {
        margin-top: 20px;
    }
</style>
