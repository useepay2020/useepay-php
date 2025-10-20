<?php

namespace UseePay\Service\Payment;

use UseePay\Net\ApiService;
use UseePay\Net\ApiResource;
use UseePay\Model\ApiRequest;
use UseePay\Exception\UseePayException;

/**
 * Payment Intent Service
 * Compatible with PHP 5.3+
 */
class PaymentIntentService extends ApiService
{
    /**
     * Creates a new payment intent
     * 
     * @param array $params
     * @return mixed
     * @throws UseePayException
     */
    public function create($params)
    {
        $path = '/api/v1/payment_intents/create';
        $request = new ApiRequest($path, $params);
        return $this->post($request);
    }
    
    /**
     * Retrieves a payment intent
     * 
     * @param string $id Payment intent ID
     * @return mixed
     * @throws UseePayException
     */
    public function retrieve($id)
    {
        $path = sprintf('/api/v1/payment_intents/%s', ApiResource::urlEncodeId($id));
        $request = new ApiRequest($path, null);
        return $this->get($request);
    }
    
    /**
     * Confirms a payment intent
     * 
     * @param string $id Payment intent ID
     * @param array $params
     * @return mixed
     * @throws UseePayException
     */
    public function confirm($id, $params = array())
    {
        $path = sprintf('/api/v1/payment_intents/%s/confirm', ApiResource::urlEncodeId($id));
        $request = new ApiRequest($path, $params);
        return $this->post($request);
    }
    
    /**
     * Cancels a payment intent
     * 
     * @param string $id Payment intent ID
     * @return mixed
     * @throws UseePayException
     */
    public function cancel($id)
    {
        $path = sprintf('/api/v1/payment_intents/%s/cancel', ApiResource::urlEncodeId($id));
        $request = new ApiRequest($path, null);
        return $this->post($request);
    }
}
