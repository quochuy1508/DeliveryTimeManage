<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\DeliveryTime\Controller\Adminhtml;

abstract class DeliveryTime extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magenest_DeliveryTime::menu';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry)
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Magenest_DeliveryTime::manage')
            ->addBreadcrumb(__('Delivery Time'), __('Delivery Time'))
            ->addBreadcrumb(__('Delivery Time'), __('Delivery Time'));
        return $resultPage;
    }
}
