<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Config\Source;

use \Magento\Framework\Option\ArrayInterface;

/**
 * Ssl source
 */
class Ssl implements ArrayInterface
{
    /**
     * Retrieve array of Options as Value-Label Pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('None'), 'value' => ''],
            ['label' => __('SSL'), 'value' => 'ssl'],
            ['label' => __('TLS'), 'value' => 'tls'],
        ];
    }
}
