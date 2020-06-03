<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Transport;

/**
 * Email zend memory transport
 */
class InMemory extends TransportAbstract
{
    /**
     * Email transport type
     */
    const TYPE = 'inmemory';

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
