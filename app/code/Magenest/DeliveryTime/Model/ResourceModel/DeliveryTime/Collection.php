<?php

namespace Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime;


use Magenest\DeliveryTime\Model\DeliveryTime;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Collection class of delivery time
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'delivery_time_collection';
    protected $_eventObject = 'delivery_time_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(DeliveryTime::class, \Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime::class);
    }
}
