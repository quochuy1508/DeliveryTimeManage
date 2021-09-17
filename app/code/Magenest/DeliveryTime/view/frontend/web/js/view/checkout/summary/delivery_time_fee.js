define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals',
        'Magento_Catalog/js/price-utils'
    ],
    function ($, Component, quote, totals, priceUtils) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Magenest_DeliveryTime/checkout/summary/delivery_time_fee'
            },
            totals: quote.getTotals(),
            isDisplayedDeliveryTimeFeeTotal: function () {
                return true;
            },
            getDeliveryTimeFeeTotal: function () {
                var price = totals.getSegment('delivery_time_fee').value;
                return this.getFormattedPrice(price);
            }
        });
    }
);
