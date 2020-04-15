<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Block\Adminhtml\System\Config;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Json\EncoderInterface;

/**
 * Button js template
 */
class Js extends Template
{
    /**
     * Json encoder
     *
     * @var EncoderInterface
     */
    private $jsonEncoder;

    /**
     * Initialize template
     *
     * @param Context $context
     * @param EncoderInterface $jsonEncoder
     * @param array $data
     */
    public function __construct(
        Context $context,
        EncoderInterface $jsonEncoder,
        array $data = []
    ) {
        $this->jsonEncoder = $jsonEncoder;

        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * Retrieve configuration of related JavaScript Component
     *
     * @return string
     */
    public function getJsConfig()
    {
        $jsConfig = [
            'url' => $this->_urlBuilder->getUrl(
                'eriocnemis_email/message/send',
                ['_current' => true]
            )
        ];
        return $this->jsonEncoder->encode($jsConfig);
    }
}
