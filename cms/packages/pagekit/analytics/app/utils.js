var _ = require('lodash');

module.exports = {

    createMetricFormatter: function (metric) {
        if (metric == 'ga:bounceRate' || metric == 'ga:percentNewSessions') {
            return new google.visualization.NumberFormat({
                pattern: '#.#',
                suffix: '%'
            });
        }

        if (metric == 'ga:pageviewsPerSession') {
            return new google.visualization.NumberFormat({
                pattern: '#.##'
            });
        }

        if (metric == 'ga:avgSessionDuration') {
            return new google.visualization.NumberFormat({
                pattern: '#.##',
                suffix: ' min'
            });
        }

        return false;
    },

    transCols: function (result) {
        _.forEach(result.dataTable.cols, function (value) {
            value.label = Vue.prototype.$trans(value.label);
        });
    },

    parseRows: function (result, params) {

        if (params.dimensions === 'ga:yearMonth') {
            result.dataTable.cols[0].type = 'date';
            result.columnHeaders[0].dataType = 'DATE';
        }

        _.forEach(result.dataTable.rows, function (value) {
            if (params.dimensions === 'ga:yearMonth') {
                var month = value.c[0].v.substr(4, 2) - 1;

                if (month < 10) {
                    month = '0' + month;
                }

                value.c[0].v = 'Date(' + value.c[0].v.substr(0, 4) + ',' + month + ',01)';
            }

            if (params.metrics === 'ga:avgSessionDuration') {
                value.c[value.c.length - 1].v = parseInt(value.c[value.c.length - 1].v, 10) / 60;
            }
        });

        _.forEach(result.totalsForAllResults, function (value, metric) {
            if (params.metrics === 'ga:avgSessionDuration') {
                result.totalsForAllResults[metric] = value / 60;
            }
        });
    }
};