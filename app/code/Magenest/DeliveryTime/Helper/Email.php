<?php

namespace Magenest\DeliveryTime\Helper;

use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;

class Email extends AbstractHelper
{
    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        StateInterface $state
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $state;
        parent::__construct($context);
    }

    public function sendEmail()
    {
        // this is an example and you can change template id,fromEmail,toEmail,etc as per your need.
        $templateId = 'email_delivery_time'; // template id
        $fromEmail = 'owner@domain.com';  // sender Email id
        $fromName = 'Admin';             // sender Name
        $toEmail = 'customer@email.com'; // receiver email id

        try {
            $storeId = $this->storeManager->getStore()->getId();

            $from = ['email' => $fromEmail, 'name' => $fromName];
//            $this->inlineTranslation->suspend();
            try {
//                $transport = $this->transportBuilder
//                    ->setTemplateIdentifier($templateId)
//                    ->setTemplateVars([])
//                    ->setTemplateOptions(
//                        [
//                            'area' => Area::AREA_FRONTEND,
//                            'store' => $storeId
//                        ]
//                    )
//                    ->setFromByScope($from)
//                    ->addTo($toEmail)
//                    ->getTransport();
//
//                $transport->sendMessage();
                $templateVars = [];
                $transport = $this->transportBuilder->setTemplateIdentifier('59')
                    ->setTemplateOptions( [ 'area' => \Magento\Framework\App\Area::AREA_FRONTEND, $storeId => 1 ] )
                    ->setTemplateVars( $templateVars )
                    ->setFrom( [ "name" => "Magento ABC CHECK PAYMENT", "email" => "paul@gmail.com" ] )
                    ->addTo('paul@gmail.com')
                    ->setReplyTo('paul@gmail.com')
                    ->getTransport();
                $transport->sendMessage();
            } finally {
                $this->inlineTranslation->resume();
            }
        } catch (\Exception $e) {
            $this->_logger->info($e->getMessage());
        }
    }
}
