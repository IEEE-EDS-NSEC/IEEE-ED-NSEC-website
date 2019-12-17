<template>

    <div class="pk-text-large" v-show="widget.counter">{{ total }}</div>

    <h3 class="uk-panel-title uk-width-3-4" v-show="config.dimensions != 'ga:date'">
        <span class="uk-text-nowrap">{{ config.dimensions | trans }}</span>
        <span class="uk-text-nowrap">by {{ config.metrics | trans }} this {{ config.startDate | trans }}</span>
    </h3>

    <h3 class="uk-panel-title uk-width-3-4" v-show="config.dimensions == 'ga:date'">
        {{ config.metrics | trans }} this {{ config.startDate | trans }}
    </h3>

    <div v-el:chart></div>

</template>

<script>
    var utils = require('../../utils.js');

    module.exports = {

        chart: {
            id: 'column',
            label: 'Column Chart',
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
                    colors: ['#56a4e1'],
                    legend: 'none',
                    lineWidth: 4,
                    pointSize: 8,
                    theme: 'maximized',
                    hAxis: {
                        baselineColor: '#fff',
                        format: 'E',
                        gridlines: {
                            color: 'none'
                        },
                        showTextEvery: 1,
                        textPosition: 'out',
                        textStyle: {
                            color: '#56a4e1'
                        }
                    },
                    vAxis: {
                        baselineColor: '#ccc',
                        gridlines: {
                            color: '#fafafa'
                        },
                        textPosition: 'out',
                        textStyle: {
                            color: '#56a4e1'
                        }
                    },
                    chartArea: {
                        height: '85%',
                        width: '85%',
                        top: 5
                    },
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

            this.$on('render', function () {
                this.dataTable = new google.visualization.DataTable(this.result.dataTable);
                this.chart = new google.visualization.ColumnChart(this.$els.chart);

                if (this.formatter) {
                    this.formatter.format(this.dataTable, 1);
                }

                if (this.config.startDate == '7daysAgo') {
                    this.options.hAxis.format = 'E';
                    this.options.hAxis.showTextEvery = 1;
                } else if (this.config.startDate == '30daysAgo') {
                    this.options.hAxis.format = 'MMM d';
                    this.options.hAxis.showTextEvery = 1;
                } else if (this.config.startDate == '365daysAgo') {
                    this.options.hAxis.showTextEvery = 4;
                    this.options.hAxis.format = 'MMM yy';

                    var formatter = new google.visualization.DateFormat({
                        pattern: 'MMMM yyyy'
                    });

                    formatter.format(this.dataTable, 0);
                }

                this.chart.draw(this.dataTable, this.options);
            });

            this.$on('resize', function () {
                if (this.chart) {
                    this.chart.draw(this.dataTable, this.options);
                }
            });
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