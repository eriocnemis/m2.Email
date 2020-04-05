<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Plugin\Framework\Mail\Template;

use Magento\Framework\Mail\Template\SenderResolverInterface as Subject;
use Eriocnemis\Email\Model\Transport\Storage;

/**
 * Email sender resolver plugin
 */
class SenderResolverPlugin
{
    /**
     * Storage data
     *
     * @var Storage
     */
    private $storage;

    /**
     * Initialize resolver
     *
     * @param Storage $storage
     */
    public function __construct(
        Storage $storage
    ) {
        $this->storage = $storage;
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
            $this->storage->setEmailIdentity($sender)
                ->setStoreId($scopeId);
        }
        return null;
    }

    /**
     * Set mail from address by scopeId
     *
     * @param Subject $subject
     * @param array $result
     * @return string[]
     */
    public function afterResolve(Subject $subject, $result)
    {
        $this->storage->setFrom($result['email'], $result['name']);

        return $result;
    }
}
