<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magenest\DeliveryTime\Model;


use Magenest\DeliveryTime\Api\Data\DeliveryTimeSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with DeliveryTime search results.
 */
class DeliveryTimeSearchResults extends SearchResults implements DeliveryTimeSearchResultsInterface
{
}
