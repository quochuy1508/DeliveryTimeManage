<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\DeliveryTime\Block\Sales\Order;

use Magento\Framework\View\Element\Template;
use \Magento\Sales\Model\Order;

/**
 * Tax totals modification block. Can be used just as subblock of \Magento\Sales\Block\Order\Totals
 */
class DeliveryTimeFee extends Template
{
    /**
     * @var Order
     */
    protected $_order;

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->_order;
    }

    /**
     * Initialize all order totals relates with tax
     *
     * @return \Magento\Tax\Block\Sales\Order\Tax
     */
    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $this->_order = $parent->getOrder();
        $fee = new \Magento\Framework\DataObject(
            [
                'code' => 'delivery_time_fee',
                'strong' => false,
                'value' => $this->_order->getDeliveryTimeFee(),
                'label' => __('Delivery Time Fee'),
            ]
        );

        $parent->addTotal($fee, 'delivery_time_fee');

        return $this;
    }
}
