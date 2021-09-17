define(
    [
        'Magenest_DeliveryTime/js/view/checkout/summary/delivery_time_fee'
    ],
    function (Component) {
        'use strict';

        return Component.extend({

            /**
             * @override
             */
            isDisplayed: function () {
                return this.getPureValue() !== 0;
            }
        });
    }
);
