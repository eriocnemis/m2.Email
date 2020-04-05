<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Email abstract source
 */
abstract class AbstractSource implements ArrayInterface
{
    /**
     * Retrieve config options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->toArray() as $value => $label) {
            $options[] = ['value' => $value, 'label' => $label];
        }
        return $options;
    }

    /**
     * Retrieve options in key-value format
     *
     * @return array
     */
    abstract public function toArray();
}
