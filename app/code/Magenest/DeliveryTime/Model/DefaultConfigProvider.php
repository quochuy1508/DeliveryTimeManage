<?php

namespace Magenest\DeliveryTime\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magenest\DeliveryTime\Helper\Data as MpDtHelper;

/**
 * Class DefaultConfigProvider
 */
class DefaultConfigProvider implements ConfigProviderInterface
{
    /**
     * @var MpDtHelper
     */
    protected $mpDtHelper;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * DefaultConfigProvider constructor.
     *
     * @param MpDtHelper $mpDtHelper
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        MpDtHelper $mpDtHelper,
        StoreManagerInterface $storeManager
    ) {
        $this->mpDtHelper   = $mpDtHelper;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return ['mpDtConfig' => $this->getMpDtConfig()];
    }

    /**
     * @return array
     */
    private function getMpDtConfig()
    {
        return [
            'isEnabled'      => $this->mpDtHelper->isEnabled(),
            'isEnabledDeliveryComment'   => $this->mpDtHelper->isEnabledDeliveryComment(),
            'deliveryDateFormat'         => $this->mpDtHelper->getDateFormat(),
            'deliveryDayMax'            => $this->mpDtHelper->getDayMax(),
            'deliveryDayMin'            => $this->mpDtHelper->getDayMin(),
            'deliveryDayNotShip'            => $this->mpDtHelper->getDayNotShip(),
//            'deliveryDateOff'            => $this->mpDtHelper->getDateOff(),
//            'deliveryTime'               => $this->mpDtHelper->getDeliveryTIme()
        ];
    }
}
