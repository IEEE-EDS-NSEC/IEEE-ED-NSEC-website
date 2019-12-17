<template>

    <div class="pk-text-large" v-show="widget.counter">{{ total }}</div>

    <h3 class="uk-panel-title uk-width-3-4">
        <span class="uk-text-nowrap">{{ config.dimensions | trans }}</span>
        <span class="uk-text-nowrap">by {{ config.metrics | trans }} this {{ config.startDate | trans }}</span>
    </h3>

    <table class="uk-table" v-if="result">
        <thead>
        <tr>
            <th v-for="col in result.dataTable.cols ">{{ col.label }}</th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="row in result.dataTable.rows | pagination page">
            <td v-for="c in row.c">{{ c.f || c.v | format $index }}</td>
        </tr>
        </tbody>
    </table>

    <ul class="uk-pagination" v-el="pageination"></ul>

</template>

<script>
    var _ = require('lodash');
    var UIkit = require('uikit');

    var utils = require('../../utils.js');

    module.exports = {

        chart: {
            id: 'list',
            label: 'List',
            description: function () {

            },
            defaults: {}
        },

        el: function () {
            return document.createElement('div');
        },

        data: function () {
            return {
                itemsPerPage: 5,
                page: 0
            };
        },

        created: function () {
            this.formatter = utils.createMetricFormatter(this.config.metrics);

            this.$on('request', function (params) {
                params.maxResults = 15;
                params.sort = '-' + params.metrics;
            });

            this.$on('render', function () {
                var vm = this;
                var pages = Math.floor(this.result.dataTable.rows.length / this.itemsPerPage);

                if (pages > 1) {
                    this.pageination = UIkit.pagination(this.$els.pageination, {
                        pages: pages,
                        onSelectPage: function (page) {
                            vm.page = page;
                        }
                    });
                }
            });
        },

        filters: {
            pagination: function (data, page) {
                return _.chunk(data, this.itemsPerPage)[page] || [];
            },

            format: function (value, col) {

                if (col == 1 && this.formatter) {
                    return this.formatter.formatValue(value);
                }

                return value;
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
