<template>
    <div class="w-full md:w-1/2 lg:w-1/3 px-3 pb-6">
        <div class="card flex flex-col" style="height: 14rem;">
            <div class="card-header flex">
                <div class="flex-1 text-sm sm:text-lg">
                    <p class="text-lg" v-text="timer.total_time + ' ' + timer.total_time_label"></p>
                    <p class="font-thin text-xs mt-2" v-text="timeRange"></p>
                </div>
                <div>
                    <a :href="`/timers/${timer.id}/edit`" class="btn-text is-primary is-small">edit</a>
                </div>
            </div>
            <div class="card-body flex flex-col flex-1">
                <p class="text-secondary flex-1" v-text="timer.description"></p>
                <div class="flex justify-between items-center">
                    <p class="text-success" v-if="timer.billable && timer.billed">Billed</p>
                    <p class="text-blue" v-if="timer.billable && ! timer.billed">Not Yet Billed</p>
                    <p class="text-secondary-dark" v-if="! timer.billable">Non-Billable</p>
                    <div class="mt-2 flex justify-end">
                        <a class="btn is-primary is-small is-narrow is-outlined mr-1" 
                            v-text="billableBtn" 
                            @click.prevent="updateTimer('billable')"></a>
                        <a class="btn is-primary is-small is-narrow is-outlined" 
                            v-text="billedBtn" 
                            v-if="showBilledBtn" 
                            @click.prevent="updateTimer('billed')"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from "moment";

    export default {
        props: ['timer'],
        computed: {
            timeRange() {
                return moment(this.timer.start).format('M/DD/YYYY hh:mm a') + ' - ' + moment(this.timer.end).format('M/DD/YYYY hh:mm a');
            },
            billableBtn() {
                return (this.timer.billable) ? 'non-billable' : 'billable';
            },
            showBilledBtn() {
                return this.timer.billable;
            },
            billedBtn() {
                return (this.timer.billable && this.timer.billed) ? 'not billed' : 'billed';
            }
        },
        methods: {
            updateTimer(type) {
                this.$emit('timerUpdated', {type, key: this.$vnode.key, timer: this.timer});
            }
        },
    }
</script>
