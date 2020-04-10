<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Block\Adminhtml\Email;

use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Container;
use Magento\Backend\Block\Widget\Context;
use Eriocnemis\Email\Model\Config\Source\Status as StatusSource;
use Eriocnemis\Email\Model\Config\Source\Transport as TransportSource;
use Eriocnemis\Email\Model\Constant;

/**
 * Email view
 *
 * @api
 */
class View extends Container
{
    /**
     * Registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Status source
     *
     * @var StatusSource
     */
    protected $statusSource;

    /**
     * Transport source
     *
     * @var TransportSource
     */
    protected $transportSource;

    /**
     * Initialize block
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param StatusSource $statusSource
     * @param TransportSource $transportSource
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        StatusSource $statusSource,
        TransportSource $transportSource,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->statusSource = $statusSource;
        $this->transportSource = $transportSource;

        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * Preparing global layout
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    {
        $this->addButton('back', [
            'label'   => __('Back'),
            'onclick' => "location.href='" . $this->getUrl('*/*/') . "'",
            'class'   => 'back'
        ]);

        $this->addButton('delete', [
            'label' => __('Delete'),
            'onclick' => 'deleteConfirm(' . json_encode(__('Are you sure you want to do this?'))
                . ','
                . json_encode($this->getUrl('*/*/delete', ['id' => $this->getEmail()->getId()]))
                . ')',
            'class' => 'scalable delete'
        ]);

        return parent::_prepareLayout();
    }

    /**
     * Retrieve email instance
     *
     * @return \Eriocnemis\Email\Model\Email
     */
    public function getEmail()
    {
        return $this->coreRegistry->registry(
            Constant::CURRENT_EMAIL
        );
    }

    /**
     * Retrieve message body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->getEmail()->getBody();
    }

    /**
     * Retrieve sender
     *
     * @return string
     */
    public function getSender()
    {
        return $this->getEmail()->getSender();
    }

    /**
     * Retrieve recipient email
     *
     * @return string
     */
    public function getRecipient()
    {
        return preg_replace_callback(
            '#\(([^()]*)\)#iDs',
            function ($matches) {
                if (filter_var($matches[1], FILTER_VALIDATE_EMAIL)) {
                    return sprintf('(<a href="mailto:%s" target="_blank">%s</a>)', $matches[1], $matches[1]);
                }
                return $matches[0];
            },
            $this->getEmail()->getRecipient()
        );
    }

    /**
     * Retrieve email cc
     *
     * @return string
     */
    public function getCc()
    {
        return $this->getEmail()->getCc();
    }

    /**
     * Retrieve email bcc
     *
     * @return string
     */
    public function getBcc()
    {
        return $this->getEmail()->getBcc();
    }

    /**
     * Retrieve subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->getEmail()->getSubject();
    }

    /**
     * Retrieve duration
     *
     * @return string
     */
    public function getDuration()
    {
        return sprintf('%0.5F', ($this->getEmail()->getDuration() * 1)) . ' s';
    }

    /**
     * Retrieve transport
     *
     * @return string
     */
    public function getTransport()
    {
        $options = $this->transportSource->toArray();
        $transport = $this->getEmail()->getTransport();

        return $options[$transport] ?? __('Unknown');
    }

    /**
     * Retrieve creation time
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->formatDate(
            $this->getEmail()->getCreatedAt(),
            \IntlDateFormatter::FULL,
            true
        );
    }

    /**
     * Retrieve status
     *
     * @return string
     */
    public function getStatus()
    {
        $options = $this->statusSource->toArray();
        $status = $this->getEmail()->getStatus();

        return $options[$status] ?? __('Unknown');
    }

    /**
     * Retrieve error message
     *
     * @return string
     */
    public function getError()
    {
        return $this->getEmail()->getError() ?: __('None');
    }
}
