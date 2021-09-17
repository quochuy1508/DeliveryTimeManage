<?php

namespace Magenest\DeliveryTime\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Class QuoteSubmitBefore
 */
class QuoteSubmitBefore implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        /** @var OrderInterface $order */
        $order = $observer->getEvent()->getOrder();

        if ($deliveryDate = $quote->getData('delivery_date')) {
            $order->setData('delivery_date', $deliveryDate);
        }
        if ($deliveryTime = $quote->getData('delivery_time')) {
            $order->setData('delivery_time', $deliveryTime);
        }
        if ($deliveryComment = $quote->getData('delivery_comment')) {
            $order->setData('delivery_comment', $deliveryComment);
        }

        if ($deliveryTimeFee = $quote->getData('delivery_time_fee')) {
            $order->setData('delivery_time_fee', $deliveryTimeFee);
        }
    }
}
