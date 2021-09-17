<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\DeliveryTime\Model\Config\Source;

use \DateTimeInterface;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * @api
 * @since 100.0.2
 */
class DisplayOn implements OptionSourceInterface
{
    /**
     * @var TimezoneInterface $_date
     */
    protected $_date;

    /**
     * @param TimezoneInterface $date
     */
    public function __construct(TimezoneInterface $date)
    {
        $this->_date =  $date;
    }
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('Order View Page(Backend)')],
            ['value' => 1, 'label' => __('New/Edit/Reorder Order Page(Backend)')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [0 => __('Order View Page(Backend)'), 1 => __('New/Edit/Reorder Order Page(Backend)')];
    }
}
