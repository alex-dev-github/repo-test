/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

/**
 * You should never mix Vue.js with jQuery!
 * Vue.js used for demonstration purposes only.
 */

define([
    'jquery',
    'mondayVue',
    'Magento_Ui/js/modal/confirm',
    'Magento_Ui/js/modal/alert'
    ], function($, Vue, confirmation, alert){
        'use strict';
        return function(config, element) {
            return new Vue({
                el: '#' + element.id,
                data: {
                    isCreated: false,
                    titleCreate: $.mage.__('Create'),
                    titleRecreate: $.mage.__('Recreate'),
                    confirmTitle: $.mage.__('Are you sure?'),
                    confirmContent: $.mage.__('Are you sure you want to recreate dashboards on monday.com?'),
                    ajaxUrl: config.ajaxUrl,
                    ajaxUrlGetList: config.ajaxUrlGetList,
                    dashboards: []
                },
                mounted: function() {
                    this.$_Dashboards_getDashboards();
                },
                methods: {
                    createDashboards() {
                        $.ajax({
                            url: this.ajaxUrl,
                            data: {
                                form_key: window.FORM_KEY
                            },
                            type: 'POST',
                            dataType: 'json',
                            showLoader: true,
                        }).done(function( data) {
                            if (data.success) {
                                if (data.dashboards.length) {
                                    this.dashboards = data.dashboards;
                                    this.isCreated = true;
                                }
                            } else {
                                alert({
                                    title: $.mage.__('Fail'),
                                    content: $.mage.__('Unable to create dashboards. Verify the token and try again.')
                                });
                            }
                        }.bind(this)).fail(function( jqXHR, textStatus, errorThrown ) {
                            console.log('Error happens. Try again.');
                            console.log(errorThrown);
                        });
                    },

                    recreateDashboards() {
                        const self = this;

                        confirmation({
                            title: this.confirmTitle,
                            content: this.confirmContent,
                            actions: {
                                confirm: function(){ self.createDashboards(); },
                                cancel: function(){},
                                always: function(){}
                            }
                        });
                    },

                    $_Dashboards_getDashboards: function () {
                        $.ajax({
                            url: this.ajaxUrlGetList,
                            data: {
                                form_key: window.FORM_KEY
                            },
                            type: 'POST',
                            dataType: 'json',
                            showLoader: true,
                        }).done(function( data) {
                            if (data.success) {
                                if (data.dashboards.length) {
                                    this.dashboards = data.dashboards;
                                    this.isCreated = true;
                                }
                            } else {
                                alert({
                                    title: $.mage.__('Fail'),
                                    content: $.mage.__('Unable to retrieve dashboards. Verify the token and try again.')
                                });
                            }
                        }.bind(this)).fail(function( jqXHR, textStatus, errorThrown ) {
                            console.log('Error happens. Try again.');
                            console.log(errorThrown);
                        });
                    }
                }
            });
        }
    }
)
