<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\DeliveryTime\Model\DeliveryTime;

/**
 * Attribute day of week options
 * @api
 * @since 100.0.2
 */
class DayOfWeeks implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Quick search weights
     *
     * @var int[]
     * @since 100.1.0
     */
    protected $dayOfWeeks = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    /**
     * Retrieve search weights as options array
     *
     * @return array
     */
    public function getOptions()
    {
        $res = [];
        foreach ($this->getValues() as $key => $value) {
            $res[] = ['value' => $key, 'label' => $value];
        }
        return $res;
    }

    /**
     * Retrieve search weights array
     *
     * @return int[]
     */
    public function getValues()
    {
        return $this->dayOfWeeks;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     * @since 100.1.0
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
