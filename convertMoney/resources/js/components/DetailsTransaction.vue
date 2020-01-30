<template>
    <div id="details">
        <div class="container" id="det">
            <div class="field" v-for="transaction in transfer">
                <div class=" card">
                    <header class=" card-header">
                        <div class="container">
                            <div class="columns">
                                <div class="column">
                                <span>
                                  <br/>
                                  Sending  Date :<strong>{{ transaction.date }}</strong>
                                </span>
                                </div>
                                <br/>
                                <div class="column">
                                    <span class="is-size-1"> Code :{{ transaction.code }}</span>
                                </div>
                                <div class="column">
                                    <br/>
                                    <div class="columns print-none">
<!--                                        <export-excel-->
<!--                                            class="button column  is-small is-outlined is-fullwidth is-size-6"-->
<!--                                            :data="transfer">-->
<!--                                            <i class="fas fa-file-excel"></i>-->
<!--                                            Excel-->
<!--                                        </export-excel>-->
                                        <div class="column"></div>
                                        <div class="column"></div>
                                        <div class="button column  is-outlined  is-size-6"
                                             @click.prevent="someJSONdata">
                                            <i class="fas fa-print"> </i>Print Data
                                        </div>
                                    </div>
                                    <div class="columns">
                                        <span class="column"> Status:</span> <span class="column">
                                      <span v-if="transaction.status === 'hold'">
                                        <span class=" has-text"> <i class=" "> </i>HOLD </span>
                                      </span>
                                      <span v-else-if="transaction.status === 'blocked'">
                                        <span class=" has-text-danger">
                                          <i class="">BLOCKED </i>
                                        </span>
                                      </span>
                                      <span v-else-if="transaction.status === 'approved'">
                                        <span class=" has-text-info">
                                          <i class="">APPROVED</i>
                                        </span>
                                      </span>
                                      <span v-else-if="transaction.status === 'paid'">
                                        <span class=" has-text-success">
                                          <i class="">PAIDOUT</i>
                                        </span>
                                          <div class="button is-static is-outlined is-rounded is-success ">
                                              <div class="is-size-4">Delivered On:	&nbsp;</div><br>
                                               <strong class="">{{transaction.delivered_at}}</strong>
                                          </div>
                                      </span>
                                      <span v-else-if="transaction.status === 'cancelled'">
                                        <span class="has-text-danger">
                                          <i style="background-color: #f14668"></i>CANCELLED
                                        </span>
                                      </span>
                                    </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <div class="columns">
                                <div class="column">
                                    <div class="columns">
                                        Name Sender :{{ transaction.name_sender }}
                                    </div>
                                    <hr/>
                                    <div class="columns">
                                        Name Receiver :{{ transaction.name_receiver }}
                                    </div>
                                    <hr/>
                                    <div class="columns">
                                        City Destination :{{ transaction.city_destination }}
                                    </div>
                                    <hr/>
                                </div>
                                <div class="column">
                                    <div class="columns">
                                        <span> Commission : {{ transaction.commission }}</span>
                                    </div>
                                    <hr/>
                                    <div class="columns">
                                        <span> Total : {{ transaction.total_money }} </span>
                                    </div>
                                    <hr/>
                                    <div class="columns">
                                        <div class="columns" v-if="images!==null">
                                            <div class="column" v-for="image in images">
                                                <div class="image is-128x128" style="margin: auto">
                                                    <a :href="getTransactionPhoto(image.path)" data-lity>
                                                        <img :src="getTransactionPhoto(image.path)"
                                                             alt="Image Transaction"
                                                             style="height: inherit;width: inherit;"
                                                             class="is-128x128"/>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="columns">
                                        Agent Name Sender :{{ transaction.agent_sender }}
                                    </div>
                                    <hr/>
                                    <div class="columns">
                                        Agent Name Receiver :{{ transaction.agent_receiver }}
                                    </div>
                                    <hr/>
                                    <div class="columns">
                                        Currency Receiver :{{ transaction.currency_receiver }}
                                    </div>
                                    <hr/>
                                    <div class="columns">
                                        Currency Sender :{{ transaction.currency_sender }}
                                    </div>
                                    <hr/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer print-none" v-if="transaction.status!=='paid'">
                        <a class=" is-danger card-footer-item" @click="blocked_transaction">
                            <span class="has-text-danger">Block</span>
                        </a>
                        <a class=" is-primary card-footer-item" @click="accepted_transaction"
                        > <span class="has-text-success">Approve</span></a
                        >
                        <a class=" is-link card-footer-item">Cancel</a>
                    </footer>
                    <footer class="card-footer print-none" v-else-if="transaction.status==='paid'">
                        <div class=" is-static  card-footer-item" >
                            <span class="has-text-grey">Block</span>
                        </div>
                        <div class="  card-footer-item"
                        > <span class="has-text-grey">Approve</span></div
                        >
                        <div class="  card-footer-item has-text-grey">Cancel</div>
                    </footer>
                </div>
            </div>
            <div class="field">
                <button class="collapsible" @click="collapse">Send Message</button>
                <div class="contents">
                    <div class="field" v-for="message in messages" :key="message.id">
                        <article v-if="message.sender_id === ref_id" class="message is-primary">
                            <div class="message-body">
                                {{message.message}}
                            </div>
                            <div class="message-footer">
                                {{message.date | myDate}}
                            </div>
                        </article>
                        <article v-else-if="message.sender_id !== ref_id" class="message">
                            <div class="message-body">
                                {{message.message}}
                            </div>
                            <div class="message-footer">
                                {{message.date | myDate}}
                            </div>
                        </article>
                    </div>
                    <div class="section is-medium print-none">
                        <div class="container">
                            <div class="columns">
                                <div class="column is-6 is-offset-3">
                                    <div class="box">

                                        <div class="body">
                                            <form @submit.prevent="send_message" class="form-wrapper form">
                                                <div class="field">
                                                    <label>Message</label>
                                                    <div class="control">
                                                        <textarea v-model="message" class="textarea"
                                                                  placeholder="Say something..." required></textarea>
                                                    </div>
                                                </div>
                                                <button type="submit" class="button is-primary is-save">
                                                    Send
                                                </button>
                                            </form>
                                            <div class="success-block is-hidden">
                                                <div class="inner">
                                                    <div class="dot"></div>
                                                    <div class="caption">
                                                        <div class="wrap has-text-centered">
                                                            <i data-feather="check"></i>
                                                            <h3>Your message was sent !</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="reset has-text-centered is-hidden">
                                <button type="button" class="button is-medium">Reset</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "DetailsTransaction",
        data() {
            return {
                transfer: [],
                messages: [],
                images: [],
                code: this.$route.params.code,
                ref_id: "",
                receiver_id: "",
                message: ""
            };
        },
        methods: {
            someJSONdata() {
                // printJS({
                //     printable: this.transfer,
                //     properties: ['code', 'name_sender', 'name_receiver', 'tax', 'commission', 'currency_sender', 'currency_receiver', 'total_money', 'city_destination', 'status', 'agent_sender', 'agent_receiver', 'convert_price', 'date'],
                //     type: 'json',
                //     gridHeaderStyle: 'color: red;  border: 2px solid #3971A5;',
                //     gridStyle: 'border: 2px solid #3971A5;'
                // });
                // printJS({
                //     printable: 'det',
                //     properties: ['code', 'name_sender', 'name_receiver', 'tax', 'commission', 'currency_sender', 'currency_receiver', 'total_money', 'city_destination', 'status', 'agent_sender', 'agent_receiver', 'convert_price', 'date'],
                //     type: 'html',
                //     css:import('bulma/bulma.sass')
                // });
                window.print()
                // printJS('det', 'html')
            },
            collapse() {
                const coll = document.getElementsByClassName("collapsible");
                for (var i = 0; i < coll.length; i++) {
                    coll[i].addEventListener("click", function () {
                        this.classList.toggle("active");
                        const content = this.nextElementSibling;
                        if (content.style.display === "block") {
                            content.style.display = "none";
                        } else {
                            content.style.display = "block";
                        }
                    });
                }
            },
            getTransactionPhoto(picture) {
                return "/storage/images/" + picture;
            },
            async details_transaction() {
                console.log(this.code);
                await axios.post('/api/find-transaction/' + this.code)
                    .then(response => {
                        this.transfer = response.data.transaction;
                        console.log(this.transfer);
                        this.images = response.data.images;
                        this.receiver_id = response.data.receiver_id;
                        console.log('asda   ' + response.data.receiver_id)
                    })
                    .catch(error => console.log(error));
            },
            blocked_transaction() {
                axios
                    .patch('/api/blocked-transaction',
                        {
                            code: this.code
                        })
                    .then(response =>
                        // eslint-disable-next-line no-undef
                        swal.fire("Transaction Blocked!", response.data.message, "success")
                    );
                Fire.$emit('AfterStatus');
            },
            accepted_transaction() {
                axios.patch('/api/accepted-transaction',
                    {code: this.code}
                ).then(response =>

                    // eslint-disable-next-line no-undef
                    swal.fire("Transaction Approved!", response.data.message, "success")
                );
                Fire.$emit('AfterStatus');
            },
            async select_messages() {
                await axios.get('/api/show-messages/' + this.code)
                    .then(response => {
                        this.messages = response.data.list_messages;
                        this.ref_id = response.data.ref_id;
                        // this.receiver_id = response.data.receiver_id;
                    })
            },
            async send_message() {
                await axios.post('/api/message',
                    {
                        transaction_id: this.code,
                        receiver_id: this.receiver_id,
                        message: this.message
                    }).then()
                    .catch();
                this.message = "";
                Fire.$emit('AfterSend');
            }
        },
        created() {
            this.select_messages();
            this.details_transaction();

            Fire.$on('AfterStatus', () => {
                this.details_transaction();
            });
            Fire.$on('AfterSend', () => {
                this.select_messages();
            });
        }
    };
</script>


<style scoped lang="scss">
    /* Style the button that is used to open and close the collapsible content */
    .collapsible {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
    }

    /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
    .active,
    .collapsible:hover {
        background-color: #cca;
    }

    /* Style the collapsible content. Note: hidden by default */
    .contents {
        padding: 18px 18px;
        display: none;
        overflow: hidden;
        background-color: #f1f1f1;
    }

    body {
        min-height: 100vh;
        background: #eaeaea;
        font-family: "Montserrat", sans-serif;
    }

    .is-hidden {
        display: none !important;
    }

    .is-disabled {
        pointer-events: none;
        opacity: 0.4;
        cursor: default !important;
    }

    .box {
        padding: 0;

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ededed;
            padding: 16px;
            padding-bottom: 20px;

            img {
                height: 52px;
                width: 52px;
                border-radius: 50%;
            }
        }

        .body {
            position: relative;
            overflow: hidden;
            min-height: 254px;
            padding: 1.25rem;

            .field {
                &:first-child {
                    margin-bottom: 10px;
                }

                label {
                    font-weight: 600;
                    font-size: 0.9rem;
                }

                .control {
                    input,
                    textarea {
                        box-shadow: none !important;
                        transition: all 0.3s;

                        &:focus {
                            border-color: #00d1b2;
                        }
                    }
                }
            }

            .success-block {
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                //background: #00d1b2;
                .inner {
                    position: relative;
                    width: 100%;
                    height: 254px;

                    .dot {
                        position: absolute;
                        top: -40px;
                        right: -40px;
                        height: 108px;
                        width: 108px;
                        border-radius: 50%;
                        background: #00d1b2;
                        z-index: 0;
                        transform: scale(0);
                        //transform: scale(18);
                        //transition: all .35s;
                        -webkit-transition: all 0.35s cubic-bezier(0.645, 0.045, 0.355, 1);
                        transition: all 0.35s cubic-bezier(0.645, 0.045, 0.355, 1);
                    }

                    .caption {
                        position: relative;
                        width: 100%;
                        height: 100%;
                        display: flex;
                        justify-content: center;
                        align-items: center;

                        svg {
                            display: block;
                            height: 40px;
                            width: 40px;
                            stroke: #fff;
                            stroke-width: 3px;
                            margin: 0 auto;
                            opacity: 0;
                            transform: translateY(20px);
                            transition: all 0.3s;
                            transition-delay: 0.35s;
                        }

                        h3 {
                            margin-top: 6px;
                            color: #fff;
                            font-weight: 600;
                            font-size: 1.2rem;
                            opacity: 0;
                            transform: translateY(20px);
                            transition: all 0.3s;
                            transition-delay: 0.4s;
                        }
                    }
                }

                &.is-active {
                    .dot {
                        transform: scale(25);
                    }

                    .caption {
                        svg,
                        h3 {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }
                }
            }
        }
    }


    //Css Ninja link
    .link-button {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #6dacff;
        position: absolute;
        bottom: 20px;
        right: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: all .4s;

        img {
            width: 32px;
            height: 32px;
            display: block;
        }

        &:hover {
            transform: scale(1.1) rotate(180deg);
            background: #00d1b2;
        }
    }

</style>

