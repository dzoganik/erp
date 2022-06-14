<?php

declare(strict_types=1);

namespace Dzoganik\Erp\Service;

use Dzoganik\Erp\Model\Config;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Rest\Request;

/**
 * Class SendOrderToErp
 * @package Dzoganik\Erp\Service
 */
class SendOrderToErp
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     * @param Config $config
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        Config $config
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->config = $config;
    }

    /**
     * @param array $data
     * @return void
     * @throws NoSuchEntityException
     */
    public function execute(array $data): Response
    {
        return $this->doRequest($this->config->getApiRequestEndpoint(), $data);
    }

    /**
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     * @return Response
     * @throws NoSuchEntityException
     */
    private function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_POST
    ): Response {
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => $this->config->getApiRequestUri(),
        ]]);

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            return $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }
}
