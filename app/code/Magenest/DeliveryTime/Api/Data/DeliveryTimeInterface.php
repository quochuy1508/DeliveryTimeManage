<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\DeliveryTime\Api\Data;

/**
 * Delivery time entity interface for API handling.
 *
 * @api
 * @since 100.0.2
 */
interface DeliveryTimeInterface
{
    /**#@+
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const GROUP_ID = 'group_id';
    const STORE_ID = 'store_id';
    const WORKING_TIME = 'working_time';
    /**#@-*/

    /**
     * Get delivery  time id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set delivery  time id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get group id
     *
     * @return int|null
     */
    public function getGroupId();

    /**
     * Set group id
     *
     * @param int $groupId
     * @return $this
     */
    public function setGroupId($groupId);

    /**
     * Get store id
     *
     * @return int|null
     */
    public function getStoreId();

    /**
     * Set store id
     *
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId);

    /**
     * Get from of delivery time
     *
     * @return string
     */
    public function getWorkingTime();

    /**
     * Set from of delivery time
     *
     * @param string $workingTime
     * @return $this
     */
    public function setWorkingTime($workingTime);
}
