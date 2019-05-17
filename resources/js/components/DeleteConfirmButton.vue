<template>
    <div class="flex-1">
        <a :class="classList" v-text="label" @click.prevent="doAction"></a>
    </div>
</template>

<script>
    import swal from 'sweetalert';

    export default {
        props: ['classes', 'label', 'dataSet', 'path', 'message', 'title'],

        data() {
            return {
                classList: this.classes,
                data: this.dataSet
            }
        },
        methods: {
            async doAction() {
                let confirmed = await swal({
                    title: this.title,
                    text: this.message,
                    icon: 'warning',
                    buttons: [
                        'Cancel',
                        'Yes'
                    ],
                    dangerMode: true
                });

                if (! confirmed) return;

                this.doDelete();
            },

            doDelete() {
                location.assign(this.path + '/' + this.data.id + '/delete');
            }
        }
    }
</script>