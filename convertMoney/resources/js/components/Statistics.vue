<template>
    <div class="container is-fluid">
        <div class="column"><strong class="is-size-5 level-left"> DASHBOARD</strong></div>
        <div class="columns agents">
            <div class="column">
                <div class="card ">
                    <header class="card-header">
                        <div class=""><strong class=" heading">Total NO OF Transactions </strong></div>
                        <div class="column"></div>
                        <div class=""><i class="fas fa-exchange-alt is-size-4"> </i> <i class="fas fa-dollar-sign is-size-4"> </i></div>

                    </header>
                    <div class="card-content">
                        <div class="level is-size-3">
                            <div class="level-left">42</div>
                        </div>
                        <div class="columns">
                            <p class="is-bold">waiting :</p>
                            <p class="level-item tag  is-warning"> 14</p>
                        </div>
                        <div class="columns"><p>approved :
                            <p class="level-item tag  is-success"> 15</p></div>
                        <div class="columns">
                            <p>paid :
                            <p class="level-item tag is-light is-success"> 16</p></div>
                        <div class="columns"><p>cancelled :
                            <p class="level-item tag  is-danger"> 17</p></div>
                        <div class="columns"><p>hold :
                            <p class="level-item tag"> 15</p></div>
                        <div class="columns"><p>blocked :
                            <p class="level-item tag is-light is-danger"> 1</p></div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card ">
                    <header class="card-header">
                        <div class=" "><strong class="heading ">Percentages OF Transactions</strong>
                        </div>
                        <div class="column"></div>
                        <div class=""><i class="fas fa-exchange-alt is-size-4"> </i> <i class="fas fa-percentage is-size-4"> </i></div>

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
                            <div class="level-left">6</div>
                        </div>
                        <div class="columns"><p>Admins :
                            <p class="level-item tag  is-light is-danger"> 1</p></div>
                        <div class="columns"><p>users :
                            <p class="level-item tag  is-danger is-light"> 5</p></div>
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
                            <div class="level-left">42</div>
                        </div>

                        <div class="columns"><p>approved :
                            <p class="level-item tag  is-success"> 15</p></div>

                        <div class="columns"><p>hold :
                            <p class="level-item tag"> 15</p></div>
                        <div class="columns"><p>blocked :
                            <p class="level-item tag is-light is-danger"> 1</p></div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Statistics",
        methods: {}
    }
</script>

<style scoped>
    .container {
        margin-top: 20px;
    }
</style>
