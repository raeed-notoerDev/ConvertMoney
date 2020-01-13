<template>
    <div class="container">
        <div class=""><strong class="is-size-4"> Transaction Details</strong></div>
        <hr>


        <div class="columns">
            <table class="table transaction">
                <tbody>
                <tr>
                    <td>Code Transaction</td>
                    <td><strong class="is-size-4">CKIE34HT</strong></td>
                </tr>
                <tr>
                    <td>
                        Amount
                    </td>
                    <td>
                        20 USD
                    </td>
                </tr>
                <tr>
                    <td>
                        Commission
                    </td>
                    <td>
                        5.0 USD
                    </td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td>0 USD</td>
                </tr>
                <tr>
                    <td>Total Amount Paid</td>
                    <td>25 USD</td>
                </tr>
                <tr>
                    <td>Exchange Rate</td>
                    <td>20 USD = 100 TRY <br>(1 USD = 5.87 TRY)</td>
                </tr>

                <tr class="has-background-grey-lighter">
                    <td>Total Amount Send</td>
                    <td> 100 TRY</td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class="columns">

            <table class="table agent">
                <tbody>
                <tr>
                    <td>PCN<br>MNALKFO32</td>
                    <td>Agent Name<br>
                        MUHAMMED RAID CUMA
                    </td>
                </tr>
                <tr>
                    <td>Transaction Status<br>
                        <strong class="has-text-success">APPROVED</strong>
                    </td>
                    <td>Transaction Date<br>
                        11/1/2020
                    </td>
                </tr>
                <tr>
                    <td>Sending Country<br>
                        Turkey
                    </td>
                    <td>Receiving Country<br>
                        IRAQ
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class=""><strong class="is-size-4"> Sender Details</strong></div>
        <hr>
        <div class="columns">
            <table class="table">
                <tbody>
                <tr>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FishTransaction"
    }
</script>

<style scoped>

</style>
