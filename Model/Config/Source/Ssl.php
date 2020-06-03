<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Config\Source;

/**
 * Ssl source
 */
class Ssl extends AbstractSource
{
    /**
     * Retrieve options in key-value format
     *
     * @return mixed[]
     */
    public function toArray()
    {
        return [
            '' => __('None'),
            'ssl' => __('SSL'),
            'tls' => __('TLS')
        ];
    }
}
