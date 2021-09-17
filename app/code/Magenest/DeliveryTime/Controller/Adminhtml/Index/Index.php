<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\DeliveryTime\Controller\Adminhtml\Index;

use Magenest\DeliveryTime\Controller\Adminhtml\DeliveryTime;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Index action.
 */
class Index extends DeliveryTime implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context     $context,
        Registry    $coreRegistry,
        PageFactory $resultPageFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Index action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('Delivery Time Manage Grid'));

        $dataPersistor = $this->_objectManager->get(DataPersistorInterface::class);
        $dataPersistor->clear('manage');

        return $resultPage;
    }
}
