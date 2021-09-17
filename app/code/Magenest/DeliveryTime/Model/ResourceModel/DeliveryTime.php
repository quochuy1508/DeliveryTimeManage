<?php

namespace Magenest\DeliveryTime\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class DeliveryTime extends AbstractDb
{
    public function _construct()
    {
        $this->_init("delivery_time", "entity_id");
    }
}
