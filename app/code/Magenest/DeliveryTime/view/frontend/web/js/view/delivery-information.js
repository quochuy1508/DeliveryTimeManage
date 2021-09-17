define([
        'jquery',
        'ko',
        'underscore',
        'uiComponent',
        'Magenest_DeliveryTime/js/model/mpdt-data',
        'Magenest_DeliveryTime/js/model/delivery-information',
        'jquery/ui',
        'jquery/jquery-ui-timepicker-addon'
    ],
    function ($, ko, _, Component, mpDtData, deliveryInformation) {
        'use strict';

        var cacheKeyDeliveryDate = 'deliveryDate',
            cacheKeyDeliveryTime = 'deliveryTime',
            cacheKeyDeliveryComment = 'deliveryComment',
            dateFormat = window.checkoutConfig.mpDtConfig.deliveryDateFormat,
            deliveryDayMax = window.checkoutConfig.mpDtConfig.deliveryDayMax,
            deliveryDayMin = window.checkoutConfig.mpDtConfig.deliveryDayMin,
            deliveryDayNotShip = window.checkoutConfig.mpDtConfig.deliveryDayNotShip,
            daysOff = /*window.checkoutConfig.mpDtConfig.deliveryDaysOff ||*/ [],
            deliveryTime = [
                {
                    'from': 0,
                    'to': 3
                },
                {
                    'from': 4,
                    'to': 7
                },
                {
                    'from': 8,
                    'to': 12
                },
                {
                    'from': 13,
                    'to': 16
                },
                {
                    'from': 17,
                    'to': 20
                }
            ],
            dateOff = [];

        function prepareSubscribeValue(object, cacheKey) {
            object(mpDtData.getData(cacheKey));
            object.subscribe(function (newValue) {
                mpDtData.setData(cacheKey, newValue);
            });
        }

        function formatDeliveryTime(time) {
            return time['from'] + 'h  - ' + time['to'] + 'h';
        }

        return Component.extend({
            defaults: {
                template: 'Magenest_DeliveryTime/delivery-information'
            },
            deliveryDate: deliveryInformation().deliveryDate,
            deliveryTime: deliveryInformation().deliveryTime,
            deliveryComment: deliveryInformation().deliveryComment,
            deliveryTimeOptions: deliveryInformation().deliveryTimeOptions,
            isVisible: ko.observable(mpDtData.getData(cacheKeyDeliveryDate)),

            initialize: function () {
                this._super();

                var self = this;

                dateOff = _.pluck(/*window.checkoutConfig.mpDtConfig.deliveryDateOff*/[], 'date_off');
                ko.bindingHandlers.mpdatepicker = {
                    init: function (element) {
                        var options = {
                            showButtonPanel: false,
                            dateFormat: dateFormat,
                            maxDate: deliveryDayMax,
                            minDate: deliveryDayMin,
                            showOn: 'both',
                            buttonText: 'Choose Time',
                            // beforeShowDay: function (date) {
                            //     var currentDay = date.getDay();
                            //     var currentDate = date.getDate();
                            //     var currentMonth = date.getMonth() + 1;
                            //     var currentYear = date.getFullYear();
                            //     var dateToCheck = ('0' + currentDate).slice(-2) + '/' + currentMonth + '/' + currentYear;
                            //
                            //     var isAvailableDay = daysOff.indexOf(currentDay) === -1;
                            //     var isAvailableDate = $.inArray(dateToCheck, dateOff) === -1;
                            //
                            //     return [isAvailableDay && isAvailableDate];
                            // }
                        };
                        $(element).datepicker(options);
                    }
                };

                $.each(deliveryTime, function (index, item) {
                    self.deliveryTimeOptions.push(formatDeliveryTime(item));
                });

                prepareSubscribeValue(this.deliveryDate, cacheKeyDeliveryDate);
                prepareSubscribeValue(this.deliveryTime, cacheKeyDeliveryTime);
                prepareSubscribeValue(this.deliveryComment, cacheKeyDeliveryComment);

                this.isVisible = ko.computed(function () {
                    return !!self.deliveryDate();
                });

                return this;
            },

            removeDeliveryInformation: function () {
                if (
                    (mpDtData.getData(cacheKeyDeliveryDate) && mpDtData.getData(cacheKeyDeliveryDate) != null) ||
                    (mpDtData.getData(cacheKeyDeliveryTime) && mpDtData.getData(cacheKeyDeliveryTime) != null) ||
                    (mpDtData.getData(cacheKeyDeliveryComment) && mpDtData.getData(cacheKeyDeliveryComment) != null)
                ) {
                    this.deliveryDate(null);
                    this.deliveryTime(null);
                    this.deliveryComment(null);
                }
            }
        });
    }
);
