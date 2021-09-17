<?php

namespace Magenest\DeliveryTime\Model\Totals;

use Magento\Framework\Phrase;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;

class DeliveryTimeFee extends AbstractTotal
{
    const DELIVERY_TIME_FEE = 5;

    /**
     * Custom constructor.
     */
    public function __construct()
    {
        $this->setCode('delivery_time_fee');
    }

    /**
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return $this
     */
    public function collect(
        Quote                       $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total                       $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);

        $deliveryFee = $this->usingDelivery($quote->getDeliveryDate());
        $total->addTotalAmount($this->getCode(), $deliveryFee);
        $total->addBaseTotalAmount($this->getCode(), $deliveryFee);
        $quote->setDeliveryTimeFee($deliveryFee);
        $total->setBaseDeliveryTimeFee($deliveryFee);
        return $this;
    }

    private function usingDelivery($deliveryDate)
    {
        if ($deliveryDate) {
            return self::DELIVERY_TIME_FEE;
        }
        return 0;
    }

    /**
     * @param Quote $quote
     * @param Total $total
     * @return array
     */
    public function fetch(
        Quote $quote,
        Total $total
    )
    {
        return [
            'code' => $this->getCode(),
            'title' => $this->getLabel(),
            'value' => $this->usingDelivery($quote->getDeliveryDate())
        ];
    }

    /**
     * @return Phrase
     */
    public function getLabel()
    {
        return __('Delivery Time Fee');
    }
}
