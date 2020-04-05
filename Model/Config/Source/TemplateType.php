<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Config\Source;

use Magento\Framework\App\TemplateTypesInterface;

/**
 * Template type source
 */
class TemplateType extends AbstractSource
{
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
