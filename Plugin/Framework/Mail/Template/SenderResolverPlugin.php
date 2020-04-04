<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Plugin\Framework\Mail\Template;

use Magento\Framework\Mail\Template\SenderResolverInterface as Subject;
use Eriocnemis\Email\Model\Transport\Identity;

/**
 * Email sender resolver plugin
 */
class SenderResolverPlugin
{
    /**
     * Email template identity
     *
     * @var Identity
     */
    private $identity;

    /**
     * Initialize resolver
     *
     * @param Identity $identity
     */
    public function __construct(
        Identity $identity
    ) {
        $this->identity = $identity;
    }

    /**
     * Set mail from address by scopeId
     *
     * @param Subject $subject
     * @param string|array $sender
     * @param string|int $scopeId
     * @return null
     */
    public function beforeResolve(Subject $subject, $sender, $scopeId = null)
    {
        if (is_string($sender)) {
            $this->identity->setEmailIdentity($sender)
                ->setStoreId($scopeId);
        }
        return null;
    }
}
