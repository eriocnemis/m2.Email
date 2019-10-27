<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Eriocnemis\Email\Model\Constant;

/**
 * Status source
 */
class Status implements ArrayInterface
{
    /**
     * Retrieve options as array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => Constant::STATUS_FAILED, 'label' => __('Failed')],
            ['value' => Constant::STATUS_SUCCESS, 'label' => __('Success')],
            ['value' => Constant::STATUS_PROCESS, 'label' => __('Process')]
        ];
    }

    /**
     * Retrieve options in key-value format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            Constant::STATUS_FAILED => __('Failed'),
            Constant::STATUS_SUCCESS => __('Success'),
            Constant::STATUS_PROCESS => __('Process')
        ];
    }
}
