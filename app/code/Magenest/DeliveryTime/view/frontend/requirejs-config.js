var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Magenest_DeliveryTime/js/action/set-shipping-information-mixin': true
            }
        }
    },
    map: {
        '*': {
            'Magento_Checkout/template/shipping-information/address-renderer/default.html':
                'Magenest_DeliveryTime/template/shipping-information/address-renderer/default.html'
        }
    }
};
