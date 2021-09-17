<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\DeliveryTime\Model;


use Magenest\DeliveryTime\Api\Data\DeliveryTimeInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Customer data model
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class DeliveryTime extends AbstractModel implements DeliveryTimeInterface
{
    const ENTITY_ID = 'entity_id';

    const CACHE_TAG = 'delivery_time';

    protected $_cacheTag = 'delivery_time';

    protected $_eventPrefix = 'delivery_time';

    /**
     * Construct Delivery Time
     */
    public function _construct()
    {
        $this->_init(ResourceModel\DeliveryTime::class);
    }

    /**
     * Get delivery  time id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set delivery  time id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get group id
     *
     * @return int|null
     */
    public function getGroupId()
    {
        return $this->getData(self::GROUP_ID);
    }

    /**
     * Set group id
     *
     * @param int $groupId
     * @return $this
     */
    public function setGroupId($groupId)
    {
        return $this->setData(self::GROUP_ID, $groupId);
    }

    /**
     * Get store id
     *
     * @return int|null
     */
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * Set store id
     *
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * Get working of delivery time
     *
     * @return int|null
     */
    public function getWorkingTime()
    {
        return $this->getData(self::WORKING_TIME);
    }

    /**
     * Set working of delivery time
     *
     * @param string $workingTime
     * @return $this
     */
    public function setWorkingTime($workingTime)
    {
        return $this->setData(self::WORKING_TIME, $workingTime);
    }
}
