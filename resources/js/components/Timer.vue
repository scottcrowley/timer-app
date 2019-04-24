<template>
    <div class="w-full md:w-1/2 lg:w-1/3 px-3 pb-6">
        <div class="card flex flex-col" style="height: 14rem;">
            <div class="card-header flex">
                <div class="flex-1 text-sm sm:text-lg">
                    <p class="text-lg" v-text="totalTime + ' ' + totalTimeLabel"></p>
                    <p class="font-thin text-xs mt-2" v-text="timeRange"></p>
                </div>
                <div>
                    <a :href="`/timers/${timerData.id}/edit`" class="btn-text is-primary is-small">edit</a>
                </div>
            </div>
            <div class="card-body flex flex-col flex-1">
                <p class="text-secondary flex-1" v-text="timerData.description"></p>
                <div class="flex justify-between items-center">
                    <p class="text-success" v-if="timerData.billable && timerData.billed">Billed</p>
                    <p class="text-blue" v-if="timerData.billable && ! timerData.billed">Not Yet Billed</p>
                    <p class="text-secondary-dark" v-if="! timerData.billable">Non-Billable</p>
                    <div class="mt-2 flex justify-end">
                        <a class="btn is-primary is-small is-narrow is-outlined mr-1" 
                            v-text="billableBtn"
                            @click.prevent="updateTimer('billable')"></a>
                        <a class="btn is-primary is-small is-narrow is-outlined" 
                            v-text="billedBtn" 
                            v-show="billedBtn" 
                            @click.prevent="updateTimer('billed')">billed</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from "moment";

    export default {
        props: ['timer', 'totalTime', 'totalTimeLabel'],
        data() {
            return {
                timerData: this.timer,
            }
        },
        computed: {
            timeRange() {
                return moment(this.timerData.start).format('M/DD/YYYY hh:mm a') + ' - ' + moment(this.timerData.end).format('M/DD/YYYY hh:mm a');
            },
            billableBtn() {
                return (this.timerData.billable) ? 'non-billable' : 'billable';
            },
            billedBtn() {
                if (! this.timerData.billable) {
                    return '';
                }
                return (this.timerData.billable && this.timerData.billed) ? 'not billed' : 'billed';
            }
        },
        methods: {
            updateTimer(type) {
                let timer = this.timerData;

                if (type == 'billable') {
                    timer = this.calculateBillableState(timer);
                } else {
                    timer.billed = ! this.timerData.billed;
                }

                axios.post(`/timers/${this.timerData.id}/edit`, timer)
                    .then(({data}) => {
                        this.timerData = data;
                        this.$emit('updated', data);
                    })
                    .catch(error => {
                        if (error.response.status == '419') {
                            flash('Your session has expired. Please refresh the page.', 'danger');
                        } else {
                            flash(error.response.data.message, 'danger');
                        }
                    });

                flash('Timer updated!', 'success');
            },
            calculateBillableState(timer) {
                timer.billable = ! this.timerData.billable;

                if (!timer.billable) {
                    timer.billed = false;
                }

                return timer;
            }
        },
    }
</script>
