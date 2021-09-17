<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\DeliveryTime\Controller\Adminhtml\Index;

use Magenest\DeliveryTime\Controller\Adminhtml\DeliveryTime;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;

/**
 * Create delivery time action.
 */
class NewAction extends DeliveryTime implements HttpGetActionInterface
{
    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context        $context,
        Registry       $coreRegistry,
        ForwardFactory $resultForwardFactory
    )
    {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Create delivery time
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
