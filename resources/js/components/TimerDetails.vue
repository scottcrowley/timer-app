<template>
    <div class="card-container justify-center" style="margin: 0;">
        <div class="w-2/5 card" style="height: auto;">
            <div class="card-body">
                <div class="card-detail">
                    <div class="w-1/4">
                        <h3 v-text="billable"></h3> 
                        <span>billable<br/>
                            <span v-text="billableLabel"></span>
                        </span>
                    </div>
                    <div class="w-1/4">
                        <h3 v-text="nonBillable"></h3> 
                        <span>non-billable<br/>
                            <span v-text="nonBillableLabel"></span>
                        </span>
                    </div>
                    <div class="w-1/4">
                        <h3 v-text="billed"></h3> 
                        <span><span v-text="billedLabel"></span><br/>
                            billed
                        </span>
                    </div>
                    <div class="w-1/4">
                        <h3 v-text="notBilled"></h3> 
                        <span><span v-text="notBilledLabel"></span><br/>
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
        props: ['billable', 'billableLabel', 'nonBillable', 'nonBillableLabel', 'billed', 'billedLabel', 'notBilled', 'notBilledLabel'],
    }
</script>