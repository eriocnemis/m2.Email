<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model;

/**
 * Constants
 */
class Constant
{
    /**
     * Log failed status
     */
    const STATUS_FAILED = 'failed';

    /**
     * Log success status
     */
    const STATUS_SUCCESS = 'success';

    /**
     * Log process status
     */
    const STATUS_PROCESS = 'process';

    /**
     * Key for current email in registry
     */
    const CURRENT_EMAIL = 'current_email';

    /**
     * Key for current email id in registry
     */
    const CURRENT_EMAIL_ID = 'current_email_id';
}
