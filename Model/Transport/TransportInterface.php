<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Transport;

/**
 * Email transport interface
 *
 * @api
 */
interface TransportInterface
{
    /**
     * Send a mail message
     *
     * @param string $message
     * @return void
     */
    public function send(string $message);
}
