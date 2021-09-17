<?php

namespace Magenest\DeliveryTime\Controller\Adminhtml\Index;

use Magenest\DeliveryTime\Model\DeliveryTime;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

/**
 * Edit Delivery Time action.
 */
class Edit extends \Magenest\DeliveryTime\Controller\Adminhtml\DeliveryTime implements HttpGetActionInterface
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
     * Edit Delivery Time
     *
     * @return ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->_objectManager->create(DeliveryTime::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
//            var_dump($model->getData());die;
            if (!$model->getEntityId()) {
                $this->messageManager->addErrorMessage(__('This delivery time no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('delivery_time', $model);

        // 5. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Delivery Time') : __('New Delivery Time'),
            $id ? __('Edit Delivery Time') : __('New Delivery Time')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Delivery Time'));
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Delivery Time %id' ,['id' => $id]) : __('New Delivery Time'));
        return $resultPage;
    }
}
