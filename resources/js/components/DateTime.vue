<template>
    <div>
        <VueCtkDateTimePicker  
            :no-value-to-custom-elem="false" 
            v-model="dateValue" 
            :no-header="true" 
            :formatted="'M/D/YY hh:mm a'" 
            :minute-interval="5" 
            :output-format="'YYYY-MM-DD HH:mm:ss'"
            :right="true">

            <input type="datetime" name="picker" value="" placeholder="Select date and time">
            <input type="hidden" :name="name" ref="dataInput" value="">

            <span class="text-error-dark text-sm mt-2" v-show="hasError" v-text="errorMessage"></span>

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
            'value', 
            'error',
            'errorMessage'
        ],
        data() {
            return {
                dateValue: this.value,
                hasError: this.error
            }
        },
        mounted() {
            this.setInputValue(this.dateValue);

            if (this.hasError) {
                this.addErrorClass();
            }
        },
        watch: {
            dateValue(value) {
                this.setInputValue(value);
                if (this.hasError) {
                    this.removeErrorClass();
                }
            }
        },
        methods: {
            setInputValue(value) {
                this.$refs.dataInput.value = value;
            },
            addErrorClass() {
                this.$refs.dataInput.previousElementSibling.classList.add('border-error');
            },
            removeErrorClass() {
                this.hasError = false;
                this.$refs.dataInput.previousElementSibling.classList.remove('border-error');
            }
        }
    }
</script>