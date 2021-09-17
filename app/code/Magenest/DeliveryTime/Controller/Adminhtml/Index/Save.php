<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\DeliveryTime\Controller\Adminhtml\Index;

use Magenest\DeliveryTime\Controller\Adminhtml\DeliveryTime;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magenest\DeliveryTime\Api\DeliveryTimeRepositoryInterface;
use Magenest\DeliveryTime\Model\DeliveryTimeFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Save Delivery Time action.
 */
class Save extends DeliveryTime implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var DeliveryTimeFactory
     */
    private $deliveryTimeFactory;

    /**
     * @var DeliveryTimeRepositoryInterface
     */
    private $deliveryTimeRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param DeliveryTimeFactory|null $deliveryTimeFactory
     * @param DeliveryTimeRepositoryInterface|null $deliveryTimeRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        SerializerInterface $serializer,
        DeliveryTimeFactory $deliveryTimeFactory = null,
        DeliveryTimeRepositoryInterface $deliveryTimeRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->serializer = $serializer;
        $this->deliveryTimeFactory = $deliveryTimeFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(DeliveryTimeFactory::class);
        $this->deliveryTimeRepository = $deliveryTimeRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(DeliveryTimeRepositoryInterface::class);
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $workingTimePost = $data['dynamic_rows'];

        $workingTimeParses = $this->serializer->serialize($workingTimePost);

        $data['working_time'] = $workingTimeParses;

        if ($data) {
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            }

            /** @var \Magenest\DeliveryTime\Model\DeliveryTime $model */
            $model = $this->deliveryTimeFactory->create();

            $id = $this->getRequest()->getParam('entity_id');
            $checkValidate = $this->validateWorkingTime($workingTimePost, $resultRedirect);
            if (!$checkValidate) {
                if ($id) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
                } else {
                    return $resultRedirect->setPath('*/*/new');
                }

            }
            if ($id) {
                try {
                    $model = $this->deliveryTimeRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This delivery time no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->deliveryTimeRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the delivery time.'));
                $this->dataPersistor->clear('delivery_time');
                return $resultRedirect->setPath('*/*/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the delivery time.'));
            }

            $this->dataPersistor->set('delivery_time', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Validate Working Time
     *
     * @param array $workingTimes
     * @param Redirect $resultRedirect
     * @return bool
     */
    private function validateWorkingTime(array $workingTimes, Redirect $resultRedirect)
    {
        foreach ($workingTimes  as $workingTime) {
            if ($workingTime['closing_hour'] < 0 ||
                $workingTime['closing_hour'] > 24 ||
                $workingTime['opening_hour'] < 0 ||
                $workingTime['opening_hour'] > 24
            ) {
                $this->messageManager->addErrorMessage(__('Hour must be between 0 to 24'));
                return false;
            }
            if (($workingTime['closing_hour'] - $workingTime['opening_hour']) < 1) {
                $this->messageManager->addErrorMessage(__('Closing time must greater than opening time more than 1 hour'));
                return false;
            }
        }
        return true;
    }
}
