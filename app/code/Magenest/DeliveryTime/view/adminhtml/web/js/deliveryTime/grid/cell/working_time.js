/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'Magento_Ui/js/grid/columns/column'
], function (Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'Magenest_DeliveryTime/deliveryTime/grid/cell/working-time-items.html',
            itemsToDisplay: 7
        },

        /**
         * Get working time data (source name and qty)
         *
         * @param {Object} record - Record object
         * @returns {Array} Result array
         */
        getWorkingTimeItemsData: function (record) {
            return record[this.index] ? record[this.index] : [];
        },

        /**
         * @param {Object} record - Record object
         * @returns {Array} Result array
         */
        getWorkingTimeItemsDataCut: function (record) {
            return this.getWorkingTimeItemsData(record).slice(0, this.itemsToDisplay);
        }
    });
});
