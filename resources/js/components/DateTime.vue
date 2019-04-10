<template>
    <div>
        <VueCtkDateTimePicker  
            :no-value-to-custom-elem="false" 
            v-model="dateValue" 
            :no-header="true" 
            :formatted="'M/D/YY hh:mm a'" 
            :minute-interval="5" 
            :output-format="'YYYY-MM-DD HH:mm:ss'">

            <input type="datetime" id="picker" value="" placeholder="Select date and time">
            <input type="hidden" :name="name" ref="dataInput" value="">

        </VueCtkDateTimePicker>
    </div>
    
</template>

<script>
    import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
    import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

    export default {
        components: { VueCtkDateTimePicker },

        props: [
            'name',
            'value'
        ],

        data() {
            return {
                dateValue: this.value
            }
        },

        mounted() {
            this.setInputValue(this.dateValue);
        },

        watch: {
            dateValue(value) {
                this.setInputValue(value);
            }
        },

        methods: {
            setInputValue(value) {
                this.$refs.dataInput.value = value;
            }
        }
    }
</script>