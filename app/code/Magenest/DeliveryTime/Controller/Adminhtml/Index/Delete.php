<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\DeliveryTime\Controller\Adminhtml\Index;

use Magenest\DeliveryTime\Controller\Adminhtml\DeliveryTime;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magenest\DeliveryTime\Api\DeliveryTimeRepositoryInterface;
use Magento\Framework\Registry;

class Delete extends DeliveryTime implements HttpPostActionInterface
{
    /**
     * @var DeliveryTimeRepositoryInterface $deliveryTimeRepository
     */
    private $deliveryTimeRepository;


    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DeliveryTimeRepositoryInterface $deliveryTimeRepository
    ) {
        parent::__construct($context, $coreRegistry);
        $this->deliveryTimeRepository = $deliveryTimeRepository;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                $this->deliveryTimeRepository->deleteById($id);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the dlivery time.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a delivery time to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
