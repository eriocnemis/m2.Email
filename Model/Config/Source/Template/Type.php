<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Config\Source\Template;

use Magento\Framework\App\TemplateTypesInterface;
use Magento\Framework\Option\ArrayInterface;

/**
 * Template type source
 */
class Type implements ArrayInterface
{
    /**
     * Retrieve options as array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => TemplateTypesInterface::TYPE_TEXT, 'label' => __('Plain Text')],
            ['value' => TemplateTypesInterface::TYPE_HTML, 'label' => __('HTML')]
        ];
    }

    /**
     * Retrieve options in key-value format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            TemplateTypesInterface::TYPE_TEXT => __('Plain Text'),
            TemplateTypesInterface::TYPE_HTML => __('HTML')
        ];
    }
}
