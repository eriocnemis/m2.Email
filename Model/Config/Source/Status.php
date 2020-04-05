<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Config\Source;

use Eriocnemis\Email\Model\Constant;

/**
 * Status source
 */
class Status extends AbstractSource
{
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
