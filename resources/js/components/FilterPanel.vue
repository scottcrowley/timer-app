<template>
    <div>
        <div class="flex flex-row">
            <a class="btn-text tracking-wide font-normal text-sm sm:text-base lg:text-lg is-primary" @click.prevent="toggleFilters">Filters</a>
            <p class="ml-auto text-sm font-thin">Showing <span class="font-semibold" v-text="itemCount"></span> <span v-text="label"></span></p>
        </div>
        <div class="flex flex-col lg:flex-row mt-3">
            <div>
                <div v-show="showFilters" class="bg-white py-6 px-3 mb-3 lg:mb-0 lg:mr-3 rounded-lg">
                    <p class="mb-2">Available Filtering Options</p>
                    <div v-for="(filter, param) in filters" class="flex items-center text-secondary mb-2 ml-2 text-sm">
                        <span :id="param" class="switch" @click.self="toggleSwitch">
                            <span></span>
                        </span>
                        <span v-text="filter.label" class="ml-2"></span>
                    </div>
                    <button 
                        class="btn is-small ml-2 is-outlined is-primary" 
                        @click.prevent="applyFilters" 
                        v-if="activeFilters.length">Apply</button>
                    <button class="btn is-small ml-1 is-outlined is-primary" @click.prevent="resetFilters">Reset</button>
                </div>
            </div>
            <div class="flex-1">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'label', 
            'baseUrl', 
            'sessionFilters', 
            'requestObject', 
            'endPoint', 
            'filters', 
            'itemCount'
        ],
        data() {
            return {
                showFilters: false,
                activeFilters: [],
                filteredUrl: '',
                filteredParams: '',
            }
        },
        mounted() {
            this.checkActiveFilters();
        },
        methods: {
            checkActiveFilters() {
                let filtersToCheck = (this.sessionFilters !== null) ? this.sessionFilters : this.requestObject;

                Object.keys(filtersToCheck).forEach(
                    filter => {
                        if (this.filters[filter]) {
                            this.activateSwitch(document.getElementById(filter));
                            this.showFilters = true;
                        }
                    }
                );
            },
            toggleFilters() {
                this.showFilters = !this.showFilters;
            },
            toggleSwitch(event) {
                let el = event.target;

                (el.classList.contains('switch-active')) ? this.deactivateSwitch(el) : this.activateSwitch(el);
            },
            activateSwitch(el) {
                let id = el.id;

                el.classList.add('switch-active');

                this.activeFilters.push(id);

                if (this.filters[id].inverse) {
                    let inverseFilters = this.filters[id].inverse;
                    if (typeof (inverseFilters) === 'string') {
                        inverseFilters = [inverseFilters];
                    }
                    inverseFilters.forEach(
                        filter => {
                            this.deactivateSwitch(document.getElementById(filter));
                        }
                    );
                }
            },
            deactivateSwitch(el) {
                el.classList.remove('switch-active');

                this.removeFilter(el.id);
            },
            removeFilter(id) {
                this.activeFilters = this.activeFilters.filter(item => item !== id);
            },
            applyFilters() {
                this.generateFilteredUrl();

                this.updateSessionFilters('post', this.filteredUrl);
            },
            generateFilteredUrl() {
                let params = '';
                this.activeFilters.forEach(
                    filter => {
                        params += (params != '') ? '&' : '';
                        params += filter + '=1';
                    }
                );
                this.filteredParams = '?' + params;
                this.filteredUrl = this.baseUrl + this.filteredParams;
            },
            updateSessionFilters(action, url) {
                axios[action]('/sessions/' + this.endPoint + this.filteredParams)
                    .then(response => {
                        window.location.href = url;
                    });
            },
            resetFilters() {
                this.updateSessionFilters('delete', this.baseUrl);
            }
        }
    }
</script>