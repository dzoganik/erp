<?php

declare(strict_types=1);

namespace Dzoganik\Erp\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Transmission extends AbstractDb
{
    public const MAIN_TABLE = 'dzoganik_erp_transmission';

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(self::MAIN_TABLE, 'transmission_id');
    }
}
