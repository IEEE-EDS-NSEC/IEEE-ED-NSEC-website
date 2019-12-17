<template>

    <div class="uk-modal" v-el:modal>
        <div class="uk-modal-dialog uk-form uk-form-horizontal">

            <div class="uk-modal-header">
                <h2>{{ 'Google API' | trans }}</h2>
            </div>

            <div class="uk-form-row" v-show="!globals.connected">
                <label for="form-auth-code" class="uk-form-label">{{ 'Authorization' | trans }}</label>

                <div class="uk-form-controls">
                    <input id="form-auth-code" class="uk-form-width-large" type="text" placeholder="{{ 'Auth code' | trans }}" v-model="code" :disabled="disableInput">
                    <p>
                        <a class="uk-button" @click="openAuthWindow">{{ 'Request code' | trans }}</a>
                        <v-loader v-show="loading"></v-loader>
                    </p>
                </div>
            </div>

            <div class="uk-form-row" v-show="!globals.connected">
                <span class="uk-form-label">{{ 'Quota Limit' | trans }}</span>

                <div class="uk-form-controls uk-form-controls-text">
                    <label><input type="checkbox" v-model="ownCredentials"> Use own credentials</label>
                    <p class="uk-form-help-block">{{ 'The Google Analytics API is limited by 50,000 requests per day. Use your own credentials to obtain your own full quota.' | trans}}</p>
                </div>
            </div>

            <div class="uk-form-row" v-show="!globals.connected && ownCredentials">
                <label for="form-client-id" class="uk-form-label">{{ 'Client ID' | trans }}</label>
                <div class="uk-form-controls">
                    <input id="form-client-id" class="uk-form-width-large" type="text" v-model="client_id">
                </div>
            </div>

            <div class="uk-form-row" v-show="!globals.connected && ownCredentials">
                <label for="form-client-secret" class="uk-form-label">{{ 'Client secret' | trans }}</label>
                <div class="uk-form-controls">
                    <input id="form-client-secret" class="uk-form-width-large" type="text" v-model="client_secret">
                </div>
            </div>

            <div class="uk-alert uk-alert-danger" v-show="globals.connected && error">
                <p>{{ error }}</p>
            </div>

            <div class="uk-form-row" v-show="globals.connected && !error">
                <label for="form-profile" class="uk-form-label">{{ 'Profile' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-profile" class="uk-form-width-large" options="profileOptions" v-model="profileId" :disabled="profileList.length == 0" :selected="globals.profile">
                        <option value="0">{{ 'Select profile...' | trans }}</option>
                        <option v-for="profile in profileList" :value="profile.id">{{ profile.webPropertyId + ' - ' + profile.websiteUrl }}</option>
                    </select>
                </div>
            </div>

            <div class="uk-form-row" v-show="globals.connected && (name || id)">
                <span class="uk-form-label">{{ 'Account' | trans }}</span>

                <div class="uk-form-controls uk-form-controls-text" v-show="name && id">
                    <p class="uk-form-controls-condensed">{{ name }}</p>
                    <p class="uk-form-controls-condensed">{{ id }}</p>
                </div>
            </div>

            <div class="uk-form-row" v-show="globals.connected">
                <span for="form-auth-code" class="uk-form-label">{{ 'Authorization' | trans }}</span>

                <div class="uk-form-controls">
                    <a class="uk-button" @click="disconnect">{{ 'Disconnect' | trans }}</a>

                    <p class="uk-form-help-block">{{ 'Disconnecting from Google will affect all Analytics widgets.' | trans }}</p>
                </div>
            </div>

        </div>
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
                init: false,
                loading: false,
                error: '',
                code: '',
                id: '',
                name: '',
                disableInput: true,
                profileId: 0,
                profileList: [],
                globals: window.$analytics
            }
        },

        created: function () {
            if (window.$analytics.root) {
                this.$options.url = {
                    root: this.$url.options.root + '/' + window.$analytics.root
                };
            }
        },

        compiled: function () {
            this.modal = UIkit.modal(this.$els.modal);
        },

        methods: {

            show: function () {
                if (!this.init) {
                    if (this.globals.profile && this.globals.profile.profileId) {
                        this.profileId = this.globals.profile.profileId;
                    }

                    if (this.globals.connected) {
                        this.loadProfiles();
                        this.loadUser();
                    }

                    this.$watch('code', Vue.util.debounce(this.checkCode, 300));
                    this.$watch('profileId', Vue.util.debounce(this.saveProfile, 300));
                    this.$watch('globals.connected', function () {
                        this.loadProfiles();
                        this.loadUser();
                    });

                    this.init = true;
                }

                this.modal.show();
            },

            openAuthWindow: function () {
                var url = 'admin/analytics/auth';

                if (this.$url.route) {
                    url = this.$url.route(url);
                }

                this.popup = window.open(url, '', 'width=800,height=500');
                this.disableInput = false;
            },

            checkCode: function (code) {
                if (!code) {
                    return;
                }

                this.loading = true;

                var request = this.$http.post('analytics/code', {code: code});

                request.then(function () {
                    this.popup.close();
                    delete this.popup; // avoid security exception

                    this.disableInput = true;

                    this.loading = false;
                    this.globals.connected = true;
                    this.code = '';
                }, function () {});

            },

            loadUser: function () {
                if (!this.globals.connected) {
                    return;
                }

                var request = this.$http.get('analytics/user');
                this.loading = true;

                request.then(function (res) {
                    res = res.data;

                    this.loading = false;
                    this.id = res.id;
                    this.name = res.name;
                }, function (err) {
                    this.loading = false;
                    this.error = err.data.message || this.$trans('Request failed.');
                });
            },

            loadProfiles: function () {
                if (!this.globals.connected) {
                    return;
                }

                var request = this.$http.get('analytics/profile');
                this.loading = true;

                request.then(function (res) {
                    res = res.data;

                    this.loading = false;
                    this.profileList = res.items;
                }, function (err) {

                    console.log(err)

                    this.loading = false;
                    this.error = err.data.message || this.$trans('Request failed.');
                });
            },

            saveProfile: function () {
                var profile = _.find(this.profileList, {id: this.profileId});

                if (profile) {
                    profile = {
                        accountId: profile.accountId,
                        propertyId: profile.internalWebPropertyId,
                        profileId: profile.id
                    };
                } else {
                    profile = {
                        accountId: 0
                    };
                }

                var request = this.$http.post('analytics/profile', profile);
                this.loading = true;

                request.then(function (res) {
                    res = res.data;

                    this.loading = false;
                    this.globals.profile = res.profile;
                }, function (err) {
                    this.loading = false;
                    this.error = err.data.message || this.$trans('Request failed.');
                });

            },

            disconnect: function () {
                var request = this.$http.delete('analytics/disconnect');

                request.then(function () {
                    this.globals.connected = false;
                    this.globals.profile = false;
                    this.profile = {};
                    this.profileId = 0;
                    this.id = '';
                    this.name = '';
                }, function () {});
            }
        }
    };

</script>