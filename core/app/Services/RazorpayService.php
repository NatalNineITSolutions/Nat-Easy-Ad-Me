<?php

namespace App\Services;

use Razorpay\Api\Api;
use Modules\PaymentGateways\app\Models\PaymentGateway;

class RazorpayService
{
    protected $apiKey;
    protected $apiSecret;
    protected $api;

    public function __construct()
    {
        $gateway = PaymentGateway::where('name', 'razorpay')->first();
        if (!$gateway) {
            throw new \Exception("Razorpay configuration not found.");
        }

        $credentials = json_decode($gateway->credentials, true);
        $this->apiKey = $credentials['api_key'] ?? null;
        $this->apiSecret = $credentials['api_secret'] ?? null;

        if (!$this->apiKey || !$this->apiSecret) {
            throw new \Exception("Incomplete Razorpay credentials.");
        }

        $this->api = new Api($this->apiKey, $this->apiSecret);
    }

    public function createOrder($amount, $receipt = null)
    {
        return $this->api->order->create([
            'receipt' => $receipt ?? 'mem_' . uniqid(),
            'amount' => $amount * 100, 
            'currency' => 'INR',
            'payment_capture' => 1,
        ]);
    }

    public function getKey()
    {
        return $this->apiKey;
    }
}
