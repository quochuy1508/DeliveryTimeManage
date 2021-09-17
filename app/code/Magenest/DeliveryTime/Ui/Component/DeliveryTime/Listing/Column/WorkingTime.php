<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\DeliveryTime\Ui\Component\DeliveryTime\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class WorkingTime
 *
 * @api
 * @since 100.0.2
 */
class WorkingTime extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        SerializerInterface $serializer,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->serializer = $serializer;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$this->getData('name')])) {
                    $workingTimes = $this->serializer->unserialize($item[$this->getData('name')]);
                    $item[$this->getData('name')] = $workingTimes;
                }
            }
        }
//        die;
        return $dataSource;
    }
}
