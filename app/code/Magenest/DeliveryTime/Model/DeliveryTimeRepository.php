<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\DeliveryTime\Model;

use Exception;
use Magenest\DeliveryTime\Api\Data;
use Magenest\DeliveryTime\Api\Data\DeliveryTimeInterface;
use Magenest\DeliveryTime\Api\Data\DeliveryTimeInterfaceFactory;
use Magenest\DeliveryTime\Api\Data\DeliveryTimeSearchResultsInterface;
use Magenest\DeliveryTime\Api\DeliveryTimeRepositoryInterface;
use Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime as ResourceDeliveryTime;
use Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime\Collection;
use Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime\CollectionFactory as DeliveryTimeCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Default Delivery Time repo impl.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class DeliveryTimeRepository implements DeliveryTimeRepositoryInterface
{
    /**
     * @var ResourceDeliveryTime
     */
    protected $resource;

    /**
     * @var DeliveryTimeFactory
     */
    protected $deliveryTimeFactory;

    /**
     * @var DeliveryTimeCollectionFactory
     */
    protected $deliveryTimeCollectionFactory;

    /**
     * @var Data\DeliveryTimeSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var DeliveryTimeInterfaceFactory
     */
    protected $dataDeliveryTimeFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceDeliveryTime $resource
     * @param DeliveryTimeFactory $deliveryTimeFactory
     * @param DeliveryTimeInterfaceFactory $dataDeliveryTimeFactory
     * @param DeliveryTimeCollectionFactory $deliveryTimeCollectionFactory
     * @param Data\DeliveryTimeSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        ResourceDeliveryTime                           $resource,
        DeliveryTimeFactory                            $deliveryTimeFactory,
        DeliveryTimeInterfaceFactory                   $dataDeliveryTimeFactory,
        DeliveryTimeCollectionFactory                  $deliveryTimeCollectionFactory,
        Data\DeliveryTimeSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper                               $dataObjectHelper,
        DataObjectProcessor                            $dataObjectProcessor,
        StoreManagerInterface                          $storeManager,
        CollectionProcessorInterface                   $collectionProcessor
    )
    {
        $this->resource = $resource;
        $this->deliveryTimeFactory = $deliveryTimeFactory;
        $this->deliveryTimeCollectionFactory = $deliveryTimeCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataDeliveryTimeFactory = $dataDeliveryTimeFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save DeliveryTime data
     *
     * @param DeliveryTimeInterface $deliveryTime
     * @return DeliveryTime
     * @throws CouldNotSaveException
     */
    public function save(DeliveryTimeInterface $deliveryTime)
    {
        try {
            $this->resource->save($deliveryTime);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $deliveryTime;
    }

    /**
     * Load DeliveryTime data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $searchCriteria
     * @return DeliveryTimeSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Collection $collection */
        $collection = $this->deliveryTimeCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var DeliveryTimeSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete DeliveryTime by given DeliveryTime Identity
     *
     * @param string $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    /**
     * Delete DeliveryTime
     *
     * @param DeliveryTimeInterface $deliveryTime
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(DeliveryTimeInterface $deliveryTime)
    {
        try {
            $a = $this->resource->delete($deliveryTime);
//            var_dump($a);die;
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Load DeliveryTime data by given DeliveryTime Identity
     *
     * @param string $id
     * @return DeliveryTime
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $deliveryTime = $this->deliveryTimeFactory->create();
        $this->resource->load($deliveryTime, $id);
//        var_dump($deliveryTime->getWorkingTime());die;
        if (!$deliveryTime->getEntityId()) {
            throw new NoSuchEntityException(__('The DeliveryTime with the "%1" ID doesn\'t exist.', $id));
        }
        return $deliveryTime;
    }
}
