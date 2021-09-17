define(
    [
        'ko',
        'uiComponent'
    ],
    function (ko, Component) {
        'use strict';

        return Component.extend({
            deliveryDate: ko.observable(),
            deliveryTime: ko.observable(),
            deliveryComment: ko.observable(),
            deliveryTimeOptions: ko.observableArray([])
        });
    }
);
