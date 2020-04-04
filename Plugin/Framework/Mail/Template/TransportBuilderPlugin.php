<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Plugin\Framework\Mail\Template;

use Magento\Framework\Mail\Template\TransportBuilder as Subject;
use Eriocnemis\Email\Model\Transport\Identity;

/**
 * Email transport builder plugin
 */
class TransportBuilderPlugin
{
    /**
     * Email template identity
     *
     * @var Identity
     */
    private $identity;

    /**
     * Initialize builder
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
     * @param string|array $from
     * @param string|int $scopeId
     * @return null
     */
    public function beforeSetFromByScope(Subject $subject, $from, $scopeId = null)
    {
        if (is_string($from)) {
            $this->identity->setEmailIdentity($from)
                ->setStoreId($scopeId);
        }
        return null;
    }

    /**
     * Set template identifier
     *
     * @param Subject $subject
     * @param string $templateIdentifier
     * @return null
     */
    public function beforeSetTemplateIdentifier(Subject $subject, $templateIdentifier)
    {
        $this->identity->setTemplateId($templateIdentifier);
        return null;
    }
}
