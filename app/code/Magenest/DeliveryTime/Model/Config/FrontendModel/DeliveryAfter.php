<?php

namespace Magenest\DeliveryTime\Model\Config\FrontendModel;

class DeliveryAfter extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Retrieve element HTML markup
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
//        $renderer = $this->getLayout()->createBlock(
//            \Magenest\DeliveryTime\Block\FieldHour::class
//        );
//        $renderer->setElement($element);
        $element->removeField('time-groups-date-delivery-fields-disabled-same-day-delivery-after-value-second');
        return $element->toHtml();
    }
}
