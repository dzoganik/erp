<?php

declare(strict_types=1);

namespace Dzoganik\Erp\Model\ResourceModel\Transmission;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(\Dzoganik\Erp\Model\Transmission::class, \Dzoganik\Erp\Model\ResourceModel\Transmission::class);
    }
}
