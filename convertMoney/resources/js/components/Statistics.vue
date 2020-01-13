<template>
    <div class="container">

<!--         agents-->
        <div class="columns">
            <strong class="is-size-1">AGENTS</strong>
        </div>
    <hr>
        <div class="columns agents">
            <div class="column">
                <div class="card blocked">
                    <header class="card-header">
                        <div class="column"><strong class="has-text-danger">Blocked </strong></div>
                        <div class="column"><i class="fas fa-users has-text-danger"></i></div>
                    </header>
                    <div class="card-content"></div>
                    <div class="card-footer"></div>
                </div>

            </div>
            <div class="column">
                <div class="card hold">
                    <header class="card-header">
                        <div class="column"><strong>Hold</strong></div>
                        <div class="column"><i class="fas fa-users"></i></div>

                    </header>
                    <div class="card-content"></div>
                    <div class="card-footer"></div>
                </div>

            </div>
            <div class="column ">
                <div class="card approved">
                    <header class="card-header">
                        <div class="column"><strong class="has-text-primary">Approved</strong></div>
                        <div class="column"><i class="fas fa-users has-text-primary"></i></div>
                    </header>
                    <div class="card-content"></div>
                    <div class="card-footer"></div>
                </div>

            </div>
            <div class="column ">
                <div class="card all">
                    <header class="card-header">
                        <div class="column">
                            ALL<i class="fas fa-users"></i>
                        </div>
                    </header>
                    <div class="card-content"></div>
                    <div class="card-footer"></div>
                </div>

            </div>
        </div>

<!--        users-->
        <div class="columns">
            <strong class="is-size-1">Admins Users</strong>
        </div>
        <hr>
        <div class="columns agents">
            <div class="column">
                <div class="card blocked">
                    <header class="card-header">
                        <div class="column"><strong class="has-text-danger">Blocked </strong></div>
                        <div class="column"><i class="fas fa-users has-text-danger"></i></div>
                    </header>
                    <div class="card-content"></div>
                    <div class="card-footer"></div>
                </div>

            </div>
            <div class="column">
                <div class="card hold">
                    <header class="card-header">
                        <div class="column"><strong>Hold</strong></div>
                        <div class="column"><i class="fas fa-users"></i></div>

                    </header>
                    <div class="card-content"></div>
                    <div class="card-footer"></div>
                </div>

            </div>
            <div class="column ">
                <div class="card approved">
                    <header class="card-header">
                        <div class="column"><strong class="has-text-primary">Approved</strong></div>
                        <div class="column"><i class="fas fa-users has-text-primary"></i></div>
                    </header>
                    <div class="card-content"></div>
                    <div class="card-footer"></div>
                </div>

            </div>
            <div class="column ">
                <div class="card all">
                    <header class="card-header">
                        <div class="column">
                            ALL<i class="fas fa-users"></i>
                        </div>
                    </header>
                    <div class="card-content"></div>
                    <div class="card-footer"></div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Statistics",
        methods:{

        }
    }
</script>

<style scoped>
    .container {
        margin-top: 20px;
    }
</style>
