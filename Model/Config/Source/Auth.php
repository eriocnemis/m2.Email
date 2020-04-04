<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Auth source
 */
class Auth implements ArrayInterface
{
    /**
     * Retrieve array of Options as Value-Label Pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('Authentication Not Required'), 'value' => ''],
            ['label' => __('Plain'), 'value' => 'plain'],
            ['label' => __('Login'), 'value' => 'login'],
            ['label' => __('CRAM-MD5'), 'value' => 'crammd5']
        ];
    }
}
