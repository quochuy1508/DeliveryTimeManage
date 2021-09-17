<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\DeliveryTime\Helper;

use Magenest\DeliveryTime\Api\Data\DeliveryTimeInterface;
use Magenest\DeliveryTime\Api\DeliveryTimeRepositoryInterface;
use Magento\Directory\Model\Currency;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Quote\Model\Quote\Item\AbstractItem;
use Magento\Store\Model\Store;
use Magento\Store\Model\ScopeInterface;
use Magento\Sales\Api\PaymentFailuresInterface;

/**
 * Checkout default helper
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public const XML_PATH_ENABLE_COMMENT_FIELD = 'delivery_time/date_delivery/enable_comments_field';
    public const XML_PATH_ENABLE_MODULE_FIELD = 'delivery_time/date_delivery/enabled';
    public const XML_PATH_DATE_FORMAT_FIELD = 'delivery_time/date_delivery/date_format';
    public const XML_PATH_DAY_MIN_FIELD = 'delivery_time/date_delivery/lead_time';
    public const XML_PATH_DAY_MAX_FIELD = 'delivery_time/date_delivery/maximal_delivery_interval';
    public const XML_PATH_DAY_NOT_SHIP_FIELD = 'delivery_time/date_delivery/day_of_weeks_not_ship';
    public const DEFAULT_SORT_DIRECTION = 'asc';
    const VIEW_MODE_GRID = 'grid';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @var DeliveryTimeRepositoryInterface
     */
    private $deliveryTimeRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param DeliveryTimeRepositoryInterface $coreRegistry
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SerializerInterface $serializer
     * @param Registry $coreRegistry
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        DeliveryTimeRepositoryInterface $deliveryTimeRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SerializerInterface $serializer,
        Registry $coreRegistry = null
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->deliveryTimeRepository = $deliveryTimeRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->serializer = $serializer;
        $this->coreRegistry = $coreRegistry ?? ObjectManager::getInstance()->get(Registry::class);
    }


    /**
     * Encode the mixed $valueToEncode into the JSON format
     *
     * @param mixed $valueToEncode
     *
     * @return string
     */
    public function jsonEncode($valueToEncode)
    {
        try {
            $encodeValue = $this->serializer->serialize($valueToEncode);
        } catch (\Exception $e) {
            $encodeValue = '{}';
        }

        return $encodeValue;
    }

    /**
     * Return, whether non-required state should be shown
     *
     * @return int
     */
    public function isEnabledDeliveryComment()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLE_COMMENT_FIELD,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return, whether non-required state should be shown
     *
     * @return int
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLE_MODULE_FIELD,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Date Format
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_DATE_FORMAT_FIELD,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Date Format
     *
     * @return string
     */
    public function getDayMax()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_DAY_MAX_FIELD,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Date Format
     *
     * @return string
     */
    public function getDayMin()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_DAY_MIN_FIELD,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Date Format
     *
     * @return string
     */
    public function getDayNotShip()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_DAY_NOT_SHIP_FIELD,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Delivery Time
     *
     * @param null $storeId
     *
     * @return mixed
     */
    public function getDeliveryTIme($storeId = null)
    {
        if (!$storeId) {
            $storeId = 1;
        }
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(DeliveryTimeInterface::STORE_ID, $storeId)->create();
        $items = $this->deliveryTimeRepository->getList($searchCriteria)->getItems();
        $result = [];
        foreach ($items as $item) {
            $result[] = $item->getWorkingTime();
//            $workingTimes = $this->serializer->unserialize($item->getWorkingTime());
//            foreach ($workingTimes as $workingTime) {
//                $result[] = [
//                    'opening_hour' => $workingTime['opening_hour'],
//                    'closing_hour' => $workingTime['closing_hour'],
//                ];
//            }
        }
//        var_dump($result);die;
        return [];
    }
}
