<template>

    <div v-if="result">
        <div class="uk-text-center" v-for="(key, result) in result.totalsForAllResults">
            <div class="pk-text-xlarge uk-margin-small-bottom">{{ result | format }}</div>
            <h3 class="uk-panel-title uk-margin-remove">{{ key | trans }}<template v-show="config.startDate"> this {{ config.startDate | trans}}</template></h3>
        </div>
    </div>
    <div v-if="false"><!-- v-if Hack --></div>

</template>

<script>
    var utils = require('../../utils.js');

    module.exports = {

        chart: {
            id: 'counter',
            label: 'Counter',
            description: function () {

            },
            defaults: {}
        },

        el: function () {
            return document.createElement('div');
        },

        created: function () {
            this.formatter = utils.createMetricFormatter(this.config.metrics);
        },

        filters: {
            format: function (value) {

                if (this.formatter) {
                    return this.formatter.formatValue(value);
                }

                return value;
            }
        }
    };

</script>