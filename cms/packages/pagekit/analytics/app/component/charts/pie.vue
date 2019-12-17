<template>

    <div class="pk-text-large" v-show="widget.counter">{{ total }}</div>

    <h3 class="uk-panel-title uk-width-3-4">
        <span class="uk-text-nowrap">{{ config.dimensions | trans }}</span>
        <span class="uk-text-nowrap">by {{ config.metrics | trans }} this {{ config.startDate | trans }}</span>
    </h3>
    <div v-el:chart></div>

</template>

<script>
    var _ = require('lodash');
    var utils = require('../../utils.js');

    module.exports = {

        chart: {
            id: 'pie',
            label: 'Pie Chart',
            description: function () {

            },
            defaults: {}
        },

        el: function () {
            return document.createElement('div');
        },

        data: function () {
            return {
                options: {
                    theme: 'maximized',
                    pieHole: 0.5,
                    legend: {
                        alignment: 'center',
                        position: 'bottom',
                        textStyle: {
                            color: '#666'
                        },
                        pagingTextStyle: {
                            color: '#666'
                        },
                        scrollArrows: {
                            activeColor: '#666',
                            inactiveColor: '#aaa'
                        }
                    },
                    chartArea: {
                        height: '75%',
                        top: 7
                    },
                    tooltip: {
                        textStyle: {
                            color: '#666'
                        },
                        showColorCode: 1
                    },
                    sliceVisibilityThreshold: 1 / 120,
                    colors: ['#56a4e1', '#aed581', '#f4d97b', '#ff8a65', '#ff6a6a', '#fe6e85', '#ac76f6', '#7c84f5', '#628cea', '#6cd5de']
                }
            }
        },

        created: function () {
            this.formatter = utils.createMetricFormatter(this.config.metrics);

            this.$on('request', function (params) {
                params.sort = '-' + params.metrics;
            });

            this.$on('resize', function () {
                if (this.chart) {
                    this.setSize();
                    this.chart.draw(this.dataTable, this.options);
                }
            });

            this.$on('render', function () {
                _.forEach(this.result.dataTable.rows, function (value) {
                    value.c[value.c.length - 1].v = parseFloat(value.c[value.c.length - 1].v);
                });

                this.dataTable = new google.visualization.DataTable(this.result.dataTable);

                this.chart = new google.visualization.PieChart(this.$els.chart)

                if (this.formatter) {
                    this.formatter.format(this.dataTable, 1);
                }

                this.setSize();
                this.chart.draw(this.dataTable, this.options);
            });
        },

        methods: {

            setSize: function () {
                this.options.height = this.$el.parentElement.offsetWidth + 20;
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