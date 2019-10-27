<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Block\Adminhtml\Email;

use Magento\Framework\Registry;
use Magento\Backend\Block\Widget;
use Magento\Backend\Block\Widget\Container;
use Magento\Backend\Block\Widget\Context;
use Eriocnemis\Email\Model\Config\Source\Status as StatusSource;
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
     * Initialize block
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param StatusSource $statusSource
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        StatusSource $statusSource,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->statusSource = $statusSource;

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
     * Retrieve from
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->getEmail()->getFrom();
    }

    /**
     * Retrieve recipient email
     *
     * @return string
     */
    public function getTo()
    {
        return $this->getEmail()->getTo();
    }

    /**
     * Retrieve subject
     *
     * @return string|null
     */
    public function getSubject()
    {
        return $this->getEmail()->getSubject();
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
            \IntlDateFormatter::FULL
        );
    }

    /**
     * Retrieve status
     *
     * @return string
     */
    public function getStatus()
    {
        $options = $this->statusSource->toOptionArray();
        foreach ($options as $option) {
            if ($option['value'] == $this->getEmail()->getStatus()) {
                return $option['label'];
            }
        }
        return __('Unknown');
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
