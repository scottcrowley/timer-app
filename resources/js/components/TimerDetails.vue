<template>
    <div class="card-container justify-center" style="margin: 0;">
        <div class="w-2/5 card" style="height: auto;">
            <div class="card-body">
                <div class="card-detail">
                    <div class="w-1/4">
                        <h3 v-text="billable.toFixed(1)"></h3> 
                        <span>billable<br/>
                            hours
                        </span>
                    </div>
                    <div class="w-1/4">
                        <h3 v-text="nonBillable.toFixed(1)"></h3> 
                        <span>non-billable<br/>
                            hours
                        </span>
                    </div>
                    <div class="w-1/4">
                        <h3 v-text="billed.toFixed(1)"></h3> 
                        <span>hours<br/>
                            billed
                        </span>
                    </div>
                    <div class="w-1/4">
                        <h3 v-text="notBilled.toFixed(1)"></h3> 
                        <span>hours<br/>
                            to be billed
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'billable' : Number, 
            'nonBillable' : Number, 
            'billed' : Number, 
            'notBilled' : Number, 
        }
    }
</script>