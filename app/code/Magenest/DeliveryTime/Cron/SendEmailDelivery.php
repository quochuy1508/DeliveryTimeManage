<?php

namespace Magenest\DeliveryTime\Cron;

use Magenest\DeliveryTime\Helper\Email;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\InventoryInStorePickupApi\Api\Data\PickupLocationInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class SendEmailDelivery
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var Email
     */
    private $sendEmail;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Email $sendEmail
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Email $sendEmail
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sendEmail = $sendEmail;
    }

    public function execute()
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(OrderInterface::STATUS, 'pending')
            ->create();

        $orderCanShips = $this->orderRepository->getList($searchCriteria)->getItems();
        foreach ($orderCanShips as $orderCanShip) {
            $log = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Psr\Log\LoggerInterface::class);
            $log->debug('==============================');
            $log->debug($orderCanShip->getCustomerEmail());
            $log->debug('==============================');
            try {
                $this->sendEmail->sendEmail();
            } catch (\Exception $exception) {
                $log->debug('===============Exception===============');
                $log->debug($exception->getMessage());
                $log->debug('===============Exception===============');
            }
        }
    }
}
