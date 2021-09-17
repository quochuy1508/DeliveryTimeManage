<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\DeliveryTime\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for delivery search results.
 * @api
 * @since 100.0.2
 */
interface DeliveryTimeSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get delivery list.
     *
     * @return \Magenest\DeliveryTime\Api\Data\DeliveryTimeInterface[]
     */
    public function getItems();

    /**
     * Set delivery list.
     *
     * @param \Magenest\DeliveryTime\Api\Data\DeliveryTimeInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
