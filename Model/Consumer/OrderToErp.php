<?php

declare(strict_types=1);

namespace Dzoganik\Erp\Model\Consumer;

use Dzoganik\Erp\Model\ResourceModel\Transmission as TransmissionResource;
use Dzoganik\Erp\Model\TransmissionFactory;
use Dzoganik\Erp\Service\SendOrderToErp;
use GuzzleHttp\Psr7\Response;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use Dzoganik\Erp\Service\SendOrderToErp as SendOrderToErpService;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;

/**
 * Class OrderToErp
 * @package Dzoganik\Erp\Model\Consumer
 */
class OrderToErp
{
    /**
     * @var SendOrderToErpService
     */
    protected $sendOrderToErp;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var TransmissionFactory
     */
    protected $transmissionFactory;

    /**
     * @var TransmissionResource
     */
    protected $transmissionResource;

    /**
     * @param SendOrderToErpService $sendOrderToErp
     * @param SerializerInterface $serializer
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param TransmissionFactory $transmissionFactory
     * @param TransmissionResource $transmissionResource
     */
    public function __construct(
        SendOrderToErpService $sendOrderToErp,
        SerializerInterface $serializer,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        TransmissionFactory $transmissionFactory,
        TransmissionResource $transmissionResource
    ) {
        $this->sendOrderToErp = $sendOrderToErp;
        $this->serializer = $serializer;
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->transmissionFactory = $transmissionFactory;
        $this->transmissionResource = $transmissionResource;
    }

    /**
     * @param string $data
     * @return void
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     */
    public function process(string $data): void
    {
        $data = $this->serializer->unserialize($data);
        $dataToErp = $this->filterDataForErp($data);

        $erpResponse = $this->sendOrderToErp->execute($dataToErp);

        $this->logTransmission($erpResponse, $data);

        if ($erpResponse->getStatusCode() === 200) {
            $order = $this->loadOrder($data['order_id']);
            $this->updateOrder($order);
        }
    }

    /**
     * @param OrderInterface $order
     * @return void
     */
    protected function updateOrder(OrderInterface $order): void
    {
        $order->setState(Order::STATE_PROCESSING);
        $this->orderRepository->save($order);
    }

    /**
     * @param string $incrementId
     * @return OrderInterface
     * @throws NoSuchEntityException
     */
    protected function loadOrder(string $incrementId): OrderInterface
    {
        $this->searchCriteriaBuilder->addFilter(OrderInterface::INCREMENT_ID, $incrementId);
        $orders = $this->orderRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        if (count($orders) === 0) {
            throw new NoSuchEntityException(__('Order %1 not fond.', $incrementId));
        }

        return reset($orders);
    }

    /**
     * @param Response $erpResponse
     * @param array $data
     * @return void
     * @throws AlreadyExistsException
     */
    protected function logTransmission(Response $erpResponse, array $data) {
        $transmission = $this->transmissionFactory->create();
        $transmission
            ->setOrderId((int)$data['entity_id'])
            ->setReturnCode($erpResponse->getStatusCode());

        $this->transmissionResource->save($transmission);
    }

    /**
     * @param array $data
     * @return array
     */
    private function filterDataForErp(array $data)
    {
        unset($data['entity_id']);
        return $data;
    }
}
