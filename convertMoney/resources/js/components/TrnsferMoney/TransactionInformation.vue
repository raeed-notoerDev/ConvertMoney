<template>
<div class="transaction-information">
    <div class="columns">
        <div class="column">
            <div class="columns">
                <div class=" column is-8">
                    <p class="has-text-left">Amount ({{ currency_sender_id }})</p>
                    <input
                        type="number"
                        placeholder="transaction"
                        class=" input number "
                        v-model="amount"
                    />
                </div>
                <div class=" column is-3">
                    <p class="has-text-left">Sending Currency</p>
                    <div class="select is-medium">
                        <select v-model="currency_sender_id" @change="convert">
                            <option
                                v-for="currency in currencies"
                                :key="currency.name"
                                :value="currency.name"
                            >
                                {{ currency.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class=" column is-8">
                    <p class="has-text-left">
                        Receiver Amount ({{ currency_receiver_id }})
                    </p>
                    <input
                        type="text"
                        disabled
                        placeholder="transaction"
                        class=" input number "
                        :value="calcCurrency"
                    />
                </div>
                <div class=" column is-3">
                    <p class="has-text-left">ReceivingCurrency</p>
                    <div class="select is-medium">
                        <select v-model="currency_receiver_id" @change="convert">
                            <option
                                v-for="currency in currencies"
                                :key="currency.name"
                                :value="currency.name"
                            >
                                {{ currency.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="columns">
                <div class="has-text-left column is-4">
                    <div>
                        <p class="heading">Exchange Rate</p>
                        <p class="">
                            1 <span>{{ currency_sender_id }}</span> =
                            <span class="is-danger">{{ convert_price }}</span>
                            <span> {{ currency_receiver_id }}</span>
                        </p>
                        <p>................................................</p>
                    </div>
                </div>
                <div class="has-text-left column is-4">
                    <div>
                        <p class="heading">Fare</p>
                        <p class="">{{ commission }} {{ currency_sender_id }}</p>
                        <p>................................................</p>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="has-text-left column is-4">
                    <div>
                        <p class="heading">Total Amount</p>
                        <p class="">{{ totalAmount }} {{ currency_sender_id }}</p>
                        <p>..................................................</p>
                    </div>
                </div>
                <div class="has-text-left column is-4">
                    <div>
                        <p class="heading">Tax</p>
                        <p class="">0 {{ currency_sender_id }}</p>
                        <p>..........................................</p>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="has-text-left column ">
                    <div>
                        <p class="heading">Balance</p>
                        <p class="">0 {{ currency_sender_id }}</p>
                        <p>................................................</p>{{infoinfo}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        name: "TransactionInformation",
        data(){
            return{
                infoinfo:"raed"
            }
        }
    }
</script>

<style scoped>

</style>
