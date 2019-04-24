<script>
    import TimerDetails from "../components/TimerDetails.vue";
    import FilterPanel from "../components/FilterPanel.vue";
    import Timer from "../components/Timer.vue";

    export default {
        props: [],

        components: {
            TimerDetails, FilterPanel, Timer
        },

        data() {
            return {

            }
        },

        computed: {

        },

        methods: {
            updateDetails(timer) {
                console.log(timer);
            }
        }
    }
</script>