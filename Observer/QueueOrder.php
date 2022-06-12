<?php

declare(strict_types=1);

namespace Dzoganik\Erp\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class QueueOrder
 * @package Dzoganik\Erp\Observer
 */
class QueueOrder implements ObserverInterface
{
    /**
     * @var PublisherInterface
     */
    protected $publisher;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param PublisherInterface $publisher
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(
        PublisherInterface $publisher,
        SerializerInterface $serializer,
        LoggerInterface $logger
    ) {
        $this->publisher = $publisher;
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

        $publishData = [
            'order_id' => $order->getIncrementId(),
            'customer_email' => $order->getCustomerEmail(),
            'items_amount' => $order->getTotalItemCount(),
        ];

        $this->publisher->publish('dzoganik.erp.topic', $this->serializer->serialize($publishData));
        $this->logger->info('Order sent to ERP.', $publishData);
    }
}
