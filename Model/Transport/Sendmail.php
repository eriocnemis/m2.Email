<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Transport;

/**
 * Email zend sendmail transport
 */
class Sendmail extends TransportAbstract
{
    /**
     * Email transport type
     */
    const TYPE = 'sendmail';

    /**
     * Retrieve transport config
     *
     * @return mixed[]
     */
    protected function getConfig()
    {
        return ['type' => self::TYPE];
    }
}
