<template>

    <label class="uk-form-label" for="form-analytics-region">{{ 'Region' | trans }}</label>
    <div class="uk-form-controls">
        <select id="form-analytics-region" class="uk-width-1-1" v-model="$parent.widget.config.region" options="regionOptions">
            <option value="0">{{ geoData.world }}</option>
            <optgroup :label="'Continents' | trans">
                <option v-for="(code, continent) in geoData.continents" :value="code">{{ continent }}</option>
            </optgroup>
            <optgroup :label="'Subcontinents' | trans">
                <option v-for="(code, subcontinents) in geoData.subcontinents" :value="code">{{ subcontinents }}</option>
            </optgroup>
            <optgroup :label="'Countries' | trans">
                <option v-for="(code, countries) in geoData.countries" :value="code">{{ countries }}</option>
            </optgroup>
        </select>
    </div>

</template>

<script>

    var _ = require('lodash');

    module.exports = {

        el: function () {
            return document.createElement('div');
        },

        data: function () {
            return {
                geoData: _.extend({}, window.$analytics.geo)
            };
        },

        compiled: function () {
            if (!this.$parent.widget.config.region) {
                // Add 'World' as default
                this.$parent.widget.config.region = 0;
            } else {
                this.$parent.widget.config.region = this.$parent.widget.config.region;
            }
        },

        beforeDestroy: function () {
            if (this.$parent.widget.config.charts !== 'geo') {
                Vue.delete(this.$parent.widget.config, 'region');
            }
        }

    };

</script>