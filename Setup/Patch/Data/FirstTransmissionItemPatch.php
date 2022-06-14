<?php

declare(strict_types=1);

namespace Dzoganik\Erp\Setup\Patch\Data;

use Dzoganik\Erp\Api\Data\TransmissionInterface;
use Dzoganik\Erp\Api\Data\TransmissionInterfaceFactory;
use Dzoganik\Erp\Model\ResourceModel\Transmission as TransmissionResource;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class FirstTransmissionItemPatch implements DataPatchInterface
{
    /**
     * @var TransmissionInterfaceFactory
     */
    protected $transmissionFactory;

    /**
     * @var TransmissionResource
     */
    protected $transmissionResource;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param TransmissionInterfaceFactory $transmissionFactory
     * @param TransmissionResource $transmissionResource
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        TransmissionInterfaceFactory $transmissionFactory,
        TransmissionResource $transmissionResource
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->transmissionFactory = $transmissionFactory;
        $this->transmissionResource = $transmissionResource;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var TransmissionInterface $item */
        $item = $this->transmissionFactory->create();
        $item->setOrderId(0);
        $item->setReturnCode(999);

        $this->transmissionResource->save($item);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}
