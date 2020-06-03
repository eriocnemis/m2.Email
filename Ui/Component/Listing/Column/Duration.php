<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Duration column
 */
class Duration extends Column
{
    /**
     * Prepare data source
     *
     * @param mixed[] $dataSource
     * @return mixed[]
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (!empty($item['duration'])) {
                    $item['duration'] = sprintf('%0.5F', ($item['duration'] * 1)) . ' s';
                }
            }
        }
        return $dataSource;
    }
}
