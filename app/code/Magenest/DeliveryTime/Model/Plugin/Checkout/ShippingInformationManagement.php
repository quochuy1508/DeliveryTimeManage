<?php

namespace Magenest\DeliveryTime\Model\Plugin\Checkout;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magenest\DeliveryTime\Helper\Data;

/**
 * Class ShippingInformationManagement
 */
class ShippingInformationManagement
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var Data
     */
    private $mpDtHelper;

    /**
     * @var TimezoneInterface
     */
    protected $timezone;

    /**
     * ShippingInformationManagement constructor.
     *
     * @param CartRepositoryInterface $cartRepository
     * @param Data $mpDtHelper
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        Data $mpDtHelper,
        TimezoneInterface $timezone
    ) {
        $this->cartRepository = $cartRepository;
        $this->mpDtHelper     = $mpDtHelper;
        $this->timezone = $timezone;
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param int $cartId
     * @param ShippingInformationInterface $addressInformation
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
                                                              $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        $extensionAttributes = $addressInformation->getShippingAddress()->getExtensionAttributes();

        if (!$extensionAttributes) {
            return [$cartId, $addressInformation];
        }
//
//        $deliveryInformation = [
//            'deliveryDate'      => $extensionAttributes->getMpDeliveryDate(),
//            'deliveryTime'      => $extensionAttributes->getMpDeliveryTime(),
//            'deliveryComment'   => $extensionAttributes->getMpDeliveryComment()
//        ];

        $quote = $this->cartRepository->get($cartId);
        $quote->setData('delivery_date', $this->timezone->date($extensionAttributes->getMpDeliveryDate()));
        $quote->setData('delivery_time', $extensionAttributes->getMpDeliveryTime());
        $quote->setData('delivery_comment', $extensionAttributes->getMpDeliveryComment());

        return [$cartId, $addressInformation];
    }
}
