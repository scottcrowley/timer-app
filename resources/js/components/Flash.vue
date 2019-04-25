<template>
    <div
        class="notification-box" 
        :class="classes"
         role="alert"
         v-show="show"
         v-text="body">
    </div>
</template>

<script>
    export default {
        props: ['message', 'baselevel'],
        data() {
            return {
                body: this.message,
                level: this.baselevel, //success, warning, danger
                show: false
            }
        },
        computed: {
            classes() {
                let defaults = [];

                defaults.push(this.level);

                return defaults;
            }
        },
        created() {
            if (this.message) {
                this.flash();
            }

            window.events.$on(
                'flash', data => this.flash(data)
            );
        },
        methods: {
            flash(data) {
                if (data) {
                    this.body = data.message;
                    this.level = data.level;
                }

                this.show = true;

                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    };
</script>
