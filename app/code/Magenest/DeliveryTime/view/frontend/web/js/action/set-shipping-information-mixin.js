define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote',
    'Magenest_DeliveryTime/js/model/delivery-information'
], function ($, wrapper, quote, deliveryInformation) {
    'use strict';

    return function (setShippingInformationAction) {
        if (!window.checkoutConfig || !window.checkoutConfig.mpDtConfig) {
            return setShippingInformationAction;
        }

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();

            if (!shippingAddress.hasOwnProperty('extension_attributes')) {
                shippingAddress.extension_attributes = {};
            }

            var deliveryData = {
                mp_delivery_date: deliveryInformation().deliveryDate(),
                mp_delivery_time: deliveryInformation().deliveryTime(),
                mp_delivery_comment: deliveryInformation().deliveryComment()
            };

            shippingAddress.extension_attributes = $.extend(
                shippingAddress.extension_attributes,
                deliveryData
            );

            return originalAction();
        });
    };
});
