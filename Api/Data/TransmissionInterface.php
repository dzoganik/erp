<?php

declare(strict_types=1);

namespace Dzoganik\Erp\Api\Data;

use DateTime;

interface TransmissionInterface
{
    public const TRANSMISSION_ID = 'transmission_id';
    public const ORDER_ID = 'order_id';
    public const RETURN_CODE = 'return_code';
    public const CREATED_AT = 'created_at';

    /**
     * @return int
     */
    public function getTransmissionId(): int;

    /**
     * @param int $transmissionId
     * @return static
     */
    public function setTransmissionId(int $transmissionId);

    /**
     * @return int
     */
    public function getOrderId(): int;

    /**
     * @param int $orderId
     * @return static
     */
    public function setOrderId(int $orderId);

    /**
     * @return int
     */
    public function getReturnCode(): int;

    /**
     * @param int $returnCode
     * @return static
     */
    public function setReturnCode(int $returnCode);

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime;

    /**
     * @param DateTime $createdAt
     * @return static
     */
    public function setCreatedAt(DateTime $createdAt);
}
