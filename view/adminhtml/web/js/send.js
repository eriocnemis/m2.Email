/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'domReady!'
],
function ($) {
    'use strict';

    $.widget('eriocnemis.emailSend', {

        /**
         * Widget Config Option
         * @var {Object}
         */
        options: {
            url: null
        },

        /**
         * Initialize Widget
         * @returns {void}
         */
        _create: function() {
            $(this.element).on(
                'click',
                $.proxy(this.prepareButton, this)
            );
        },

        /**
         * Initialize Button
         * @returns {void}
         */
        prepareButton: function() {
            this.makeRequest(
                $(this.element).closest('fieldset').serializeArray(),
                this.options.url
            );
        },

        /**
        * Makes ajax request
        *
        * @param {Object} data
        * @param {String} url
        * @returns {*}
        */
        makeRequest: function(data, url) {
            $('body').trigger('processStart');
            $.ajax({
                url: url,
                data: data,
                dataType: 'json',
                context: this,
                success: this.onSuccess,
                complete: this.onComplete
            });
        },

        /**
        * Success callback
        *
        * @param {Object} response
        * @returns {Boolean}
        */
        onSuccess: function(response) {
            if (response.ajaxExpired) {
                window.location.href = response.ajaxRedirect;
            }
            var id = '#' + $(this.element).attr('id') + '_result';
            if (!response.error) {
                $(id).removeClass('send-error').addClass('send-success');
            } else {
                $(id).removeClass('send-success').addClass('send-error');
            }
            $(id).text(response.message).removeClass('hidden');
        },

        /**
        * Complete callback
        *
        * @returns {void}
        */
        onComplete: function() {
            $('body').trigger('processStop');
        }
    });

    return $.eriocnemis.emailSend;
});
