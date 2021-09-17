<?php

namespace Magenest\DeliveryTime\Model\DeliveryTime;

use Magenest\DeliveryTime\Model\DeliveryTimeFactory;
use Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime\CollectionFactory as DeliveryTimeCollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider for form delivety time
 */
class DataProvider extends AbstractDataProvider
{
    protected $_loadedData;

    /**
     * @var DeliveryTimeCollectionFactory
     */
    protected $collection;

    /**
     * Constructor Class DataProvider
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param DeliveryTimeCollectionFactory $collection
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        DeliveryTimeCollectionFactory $collection,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collection->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
//        var_dump($items);
        foreach ($items as $item) {
//            var_dump($item->getData());
//            die;
            $this->_loadedData[$item->getEntityId()] = [
                'entity_id' => $item->getEntityId(),
                'group_id' => $item->getGroupId(),
                'store_id' => $item->getStoreId()
            ];
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $serializer = $objectManager->create(\Magento\Framework\Serialize\SerializerInterface::class);
            foreach ($serializer->unserialize($item->getWorkingTime()) as $value) {
                $this->_loadedData[$item->getEntityId()]['dynamic_rows'][] = $value;
            }
        }
//        die;
//        var_dump($this->_loadedData);die;
        return $this->_loadedData;
    }
}
