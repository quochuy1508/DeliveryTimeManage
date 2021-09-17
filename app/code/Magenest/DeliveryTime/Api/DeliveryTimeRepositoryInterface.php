<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\DeliveryTime\Api;

/**
 * Delivery Time CRUD interface.
 * @api
 * @since 100.0.2
 */
interface DeliveryTimeRepositoryInterface
{
    /**
     * Save delivery time.
     *
     * @param \Magenest\DeliveryTime\Api\Data\DeliveryTimeInterface $deliveryTime
     * @return \Magenest\DeliveryTime\Api\Data\DeliveryTimeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\DeliveryTimeInterface $deliveryTime);

    /**
     * Retrieve delivery time.
     *
     * @param string $id
     * @return \Magenest\DeliveryTime\Api\Data\DeliveryTimeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve delivery time matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchSearchCriteria
     * @return \Magenest\DeliveryTime\Api\Data\DeliveryTimeSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchSearchCriteria);

    /**
     * Delete delivery time.
     *
     * @param \Magenest\DeliveryTime\Api\Data\DeliveryTimeInterface $deliveryTime
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\DeliveryTimeInterface $deliveryTime);

    /**
     * Delete delivery time by ID.
     *
     * @param string $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}
