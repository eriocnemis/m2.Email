<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Config\Source;

/**
 * Auth source
 */
class Auth extends AbstractSource
{
    /**
     * Retrieve options in key-value format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            '' => __('Authentication Not Required'),
            'plain' => __('Plain'),
            'login' => __('Login'),
            'crammd5' => __('CRAM-MD5')
        ];
    }
}
