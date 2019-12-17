<template>

    <div class="pk-text-large" v-show="widget.counter">{{ total }}</div>

    <h3 class="uk-panel-title uk-width-3-4">
        {{ config.metrics | trans }} this {{ config.startDate | trans }}
    </h3>

    <div v-el:chart></div>

</template>

<script>
    var _ = require('lodash');
    var utils = require('../../utils.js');

    var continents = require('../../data/continents.json');
    var subcontinents = require('../../data/sub-continents.json');

    module.exports = {

        chart: {
            id: 'geo',
            label: 'Geo Chart',
            description: function () {

            },
            defaults: {},

            customOptions: require('./geo-options.vue')
        },

        el: function () {
            return document.createElement('div');
        },

        data: function () {
            return {
                options: {
                    colors: ['#92c8f1', '#56a4e1'],
                    displayMode: 'auto',
                    tooltip: {
                        textStyle: {
                            color: '#666'
                        }
                    }
                }
            }
        },

        created: function () {
            this.formatter = utils.createMetricFormatter(this.config.metrics);

            this.$on('request', function (params) {
                if (params.dimensions == 'ga:city') {
                    params.dimensions = 'ga:latitude,ga:longitude,'.concat(params.dimensions);
                }

                if (this.config.region && this.config.region != '0') {
                    var filter;

                    if (filter = _.result(_.find(continents, {code: this.config.region}), 'label')) {
                        // region is a continent
                        params.filters = 'ga:continent==' + filter;
                    } else if (filter = _.result(_.find(subcontinents, {code: this.config.region}), 'label')) {
                        // region is a subcontinent
                        params.filters = 'ga:subcontinent==' + filter;
                    } else {
                        // region is a country
                        params.filters = 'ga:countryIsoCode==' + this.config.region;
                    }
                }
            });

            this.$on('render', function () {
                if (this.config.region && this.config.region != '0') {
                    this.options.region = this.config.region;
                }

                switch (this.config.dimensions) {
                    case 'ga:city':
                        this.options.displayMode = 'markers';

                        this.result.dataTable.cols[0].type = 'number';
                        this.result.dataTable.cols[1].type = 'number';

                        break;

                    case 'ga:country':
                        this.options.resolution = 'countries';

                        break;

                    case 'ga:continent':
                        this.options.resolution = 'continents';

                        this.result.dataTable.rows = _.forEach(this.result.dataTable.rows, function (value) {
                            value.c[0].f = value.c[0].v;
                            value.c[0].v = _.result(_.find(continents, {label: value.c[0].v}), 'code');
                        });

                        break;

                    case 'ga:subContinent':
                        this.options.resolution = 'subcontinents';

                        this.result.dataTable.rows = _.forEach(this.result.dataTable.rows, function (value) {
                            value.c[0].f = value.c[0].v;
                            value.c[0].v = _.result(_.find(subcontinents, {label: value.c[0].v}), 'code');
                        });

                        break;
                }

                this.dataTable = new google.visualization.DataTable(this.result.dataTable);
                this.chart = new google.visualization.GeoChart(this.$els.chart)

                if (this.formatter) {
                    this.formatter.format(this.dataTable, 1);
                }

                if (this.config.metrics == 'ga:bounceRate' || this.config.metrics == 'ga:percentNewSessions') {
                    this.options.legend = {numberFormat: '#\'%\''};
                }

                this.chart.draw(this.dataTable, this.options);
            });

            this.$on('resize', function () {
                if (this.chart) {
                    this.setSize();
                    this.chart.draw(this.dataTable, this.options);
                }
            });
        },

        methods: {

            setSize: function () {
                this.options.height = this.$el.parentElement.offsetWidth * 347 / 556;
            }

        },

        computed: {

            total: function () {
                if (this.result && this.result.totalsForAllResults) {
                    var total = this.result.totalsForAllResults[this.config.metrics];
                    if (this.formatter !== false) {
                        return this.formatter.formatValue(total);
                    }

                    return total;
                }
            }
        }

    };

</script>