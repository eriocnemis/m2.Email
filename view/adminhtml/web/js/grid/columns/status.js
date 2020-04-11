/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'Magento_Ui/js/grid/columns/select',
    'underscore'
], function (Select, _) {
    'use strict';

    return Select.extend({
        defaults: {
            bodyTmpl: 'Eriocnemis_Email/grid/cells/status',
            fieldClass: {
                'status-failed': false,
                'status-process': false,
                'status-success': false,
                'status-undefined': false,
                'mode-dummy': false
            },
            statusMap: {
                failed: 'failed',
                process: 'process',
                success: 'success',
                undefined: 'undefined'
            }
        },

        /**
         * Returns list of classes that should be applied to a field
         *
         * @returns {Object}
         */
        getFieldClass: function ($row) {
            var status = this.statusMap[$row.status] || 'undefined',
                result = {};

            result['status-' + status] = true;
            result['mode-dummy'] = $row.dummy == 1 ? true : false;
            result = _.extend({}, this.fieldClass, result);

            return result;
        }
    });
});
