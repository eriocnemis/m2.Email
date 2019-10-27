<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\App\Action;

use Magento\Framework\Registry;
use Magento\Backend\App\Action\Context as ActionContext;
use Psr\Log\LoggerInterface;
use Eriocnemis\Email\Model\EmailFactory;

/**
 * Email context
 */
class Context
{
    /**
     * Action context
     *
     * @var ActionContext
     */
    protected $context;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Email factory
     *
     * @var EmailFactory
     */
    protected $emailFactory;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Initialize context
     *
     * @param ActionContext $context
     * @param Registry $coreRegistry
     * @param EmailFactory $emailFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        ActionContext $context,
        Registry $coreRegistry,
        EmailFactory $emailFactory,
        LoggerInterface $logger
    ) {
        $this->context = $context;
        $this->coreRegistry = $coreRegistry;
        $this->emailFactory = $emailFactory;
        $this->logger = $logger;
    }

    /**
     * Retrieve action context
     *
     * @return ActionContext
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Retrieve core registry
     *
     * @return Registry
     */
    public function getCoreRegistry()
    {
        return $this->coreRegistry;
    }

    /**
     * Retrieve email factory
     *
     * @return EmailFactory
     */
    public function getEmailFactory()
    {
        return $this->emailFactory;
    }

    /**
     * Retrieve logger
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }
}
