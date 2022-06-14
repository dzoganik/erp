<?php

declare(strict_types=1);

namespace Dzoganik\Erp\Model;

use DateTime;
use Dzoganik\Erp\Api\Data\TransmissionInterface;
use Magento\Framework\Model\AbstractModel;

class Transmission extends AbstractModel implements TransmissionInterface
{
    const CACHE_TAG = 'dzoganik_erp_transmission';

    /**
     * @var string
     */
    protected $_cacheTag = 'dzoganik_erp_transmission';

    /**
     * @var string
     */
    protected $_eventPrefix = 'dzoganik_erp_transmission';

    /**
     * @var string
     */
    protected $_idFieldName = TransmissionInterface::TRANSMISSION_ID;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Transmission::class);
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return int
     */
    public function getTransmissionId(): int
    {
        return $this->getData(TransmissionInterface::TRANSMISSION_ID);
    }

    /**
     * @param int $transmissionId
     * @return Transmission
     */
    public function setTransmissionId(int $transmissionId)
    {
        $this->setData(TransmissionInterface::TRANSMISSION_ID, $transmissionId);
        return $this;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->getData(TransmissionInterface::ORDER_ID);
    }

    /**
     * @param int $orderId
     * @return $this|Transmission
     */
    public function setOrderId(int $orderId)
    {
        $this->setData(TransmissionInterface::ORDER_ID, $orderId);
        return $this;
    }

    /**
     * @return int
     */
    public function getReturnCode(): int
    {
        return $this->getData(TransmissionInterface::RETURN_CODE);
    }

    /**
     * @param int $returnCode
     * @return $this|Transmission
     */
    public function setReturnCode(int $returnCode)
    {
        $this->setData(TransmissionInterface::RETURN_CODE, $returnCode);
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->getData(TransmissionInterface::CREATED_AT);
    }

    /**
     * @param DateTime $createdAt
     * @return $this|Transmission
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->setData(TransmissionInterface::CREATED_AT, $createdAt);
        return $this;
    }
}
