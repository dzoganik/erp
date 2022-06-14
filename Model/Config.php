<?php

declare(strict_types=1);

namespace Dzoganik\Erp\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config
 * @package Dzoganik\Erp\Model
 */
class Config
{
    public const API_REQUEST_URI_PATH = 'dzoganik_erp/api_request/uri';
    public const API_REQUEST_ENDPOINT_PATH = 'dzoganik_erp/api_request/endpoint';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return string
     */
    public function getApiRequestUri(): string
    {
        return $this->scopeConfig->getValue(self::API_REQUEST_URI_PATH);
    }

    /**
     * @return string
     */
    public function getApiRequestEndpoint(): string
    {
        return $this->scopeConfig->getValue(self::API_REQUEST_ENDPOINT_PATH);
    }
}
