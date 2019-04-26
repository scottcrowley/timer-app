<template>
    <div>
        <timer-details 
                :billable="totalBillable"
                :non-billable="totalNonBillable"
                :billed="totalBilled"
                :not-billed="totalNotBilled"/>
        <filter-panel 
            :label="label"
            :item-count="timers.length"
            :base-url="baseUrl"
            :request-object="requestObject" 
            :session-filters="sessionFilters"
            :end-point="endPoint" 
            :filters="filters">
            <div slot="content" class="card-container">
                <timer :key="index" :timer="timer" v-for="(timer, index) in timers" @timerUpdated="timerUpdate"></timer>
                <p class="p-2 mt-4 ml-8" v-if="! timers.length">There are no Timers matching your filtering options.</p>
            </div>
        </filter-panel>
    </div>
</template>

<script>
    import FilterPanel from "./FilterPanel";
    import Timer from "./Timer";

    export default {
        props: [
            'timers',
            'label', 
            'baseUrl', 
            'sessionFilters', 
            'requestObject', 
            'endPoint', 
            'filters'
        ],
        components: {
            FilterPanel,
            Timer
        },
        data() {
            return {
                totalBillable: 0,
                totalNonBillable: 0,
                totalBilled: 0,
                totalNotBilled: 0
            }
        },
        created() {
            this.updateDetails();
        },
        methods: {
            timerUpdate({type, key, timer}) {
                if (type == 'billable') {
                    timer = this.calculateBillableState(key, timer);
                } else {
                    timer.billed = ! this.timers[key].billed;
                }

                axios.post(`/timers/${this.timers[key].id}/edit`, timer)
                    .then(({data}) => {
                        this.timers[key] = data;

                        this.updateDetails();
                        flash('Timer updated!', 'success');
                    })
                    .catch(error => {
                        if (error.response.status == '419') {
                            flash('Your session has expired. Please refresh the page.', 'danger');
                        } else {
                            flash(error.response.data.message, 'danger');
                        }
                    });
            },
            updateDetails() {
                this.resetDetails();
                this.timers.map((timer) => {
                    this.totalBillable += timer.total_billable_time;
                    this.totalNonBillable += timer.total_non_billable_time;
                    this.totalBilled += timer.total_billed_time;
                    this.totalNotBilled += timer.total_not_billed_time;
                });
            },
            calculateBillableState(key, data) {
                data.billable = ! this.timers[key].billable;
                if (!data.billable) {
                    data.billed = false;
                }
                return data;
            },
            resetDetails() {
                this.totalBillable = 0;
                this.totalNonBillable = 0;
                this.totalBilled = 0;
                this.totalNotBilled = 0;
            }
        }
    }
</script>