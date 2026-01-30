<?php

namespace UseePay\Model\Checkout;

use UseePay\Model\BaseModel;

/**
 * Checkout Session object
 * Compatible with PHP 5.3+
 */
class CheckoutSession extends BaseModel
{
    /**
     * @var string Object type (checkout.session)
     */
    public $object;
    
    /**
     * @var string Payment mode: payment or subscription
     */
    public $mode;
    
    /**
     * @var string UI mode: custom
     */
    public $uiMode;
    
    /**
     * @var float Total amount
     */
    public $amount;
    
    /**
     * @var string Currency code (ISO 4217)
     */
    public $currency;
    
    /**
     * @var string Merchant order ID
     */
    public $merchantOrderId;
    
    /**
     * @var string Session status: open, complete, expired
     */
    public $status;
    
    /**
     * @var string Payment status: unpaid, paid, no_payment_required
     */
    public $paymentStatus;
    
    /**
     * @var string|null Customer ID
     */
    public $customerId;
    
    /**
     * @var array|null Customer information
     */
    public $customer;
    
    /**
     * @var array Line items
     */
    public $lineItems;
    
    /**
     * @var array|null Subscription data
     */
    public $subscriptionData;
    
    /**
     * @var string|null Collection method
     */
    public $collectionMethod;
    
    /**
     * @var array|null Payment method types
     */
    public $paymentMethodTypes;
    
    /**
     * @var array|null Metadata
     */
    public $metadata;
    
    /**
     * @var int|null Creation time (Unix timestamp)
     */
    public $created;
    
    /**
     * @var int|string|null Expiration time
     */
    public $expiresAt;
    
    /**
     * @var string|null Client secret for frontend
     */
    public $clientSecret;
    
    /**
     * @var string|null Subscription ID
     */
    public $subscriptionId;
    
    /**
     * @var string|null Payment intent ID
     */
    public $paymentIntentId;
    
    /**
     * @var array|null Billing information
     */
    public $billing;
    
    /**
     * @var array|null Shipping information
     */
    public $shipping;
    
    /**
     * @var array|null Presentment payment method
     */
    public $presentmentPaymentMethod;
    
    /**
     * @var string|null IP address
     */
    public $ipAddress;
    
    /**
     * @var string|null Country code
     */
    public $countryCode;
    
    // Mode constants
    const MODE_PAYMENT = 'payment';
    const MODE_SUBSCRIPTION = 'subscription';
    
    // UI Mode constants
    const UI_MODE_CUSTOM = 'custom';
    
    // Status constants
    const STATUS_OPEN = 'open';
    const STATUS_COMPLETE = 'complete';
    const STATUS_EXPIRED = 'expired';
    
    // Payment status constants
    const PAYMENT_STATUS_UNPAID = 'unpaid';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_NO_PAYMENT_REQUIRED = 'no_payment_required';
    
    // Collection method constants
    const COLLECTION_METHOD_AUTO_CHARGE = 'auto_charge';
    
    // Payment method type constants
    const PAYMENT_METHOD_CARD = 'card';
    const PAYMENT_METHOD_APPLE_PAY = 'apple_pay';
    const PAYMENT_METHOD_GOOGLE_PAY = 'google_pay';
    
    public function __construct($data = array())
    {
        parent::__construct($data);
        
        $this->object = isset($data['object']) ? $data['object'] : 'checkout.session';
        $this->mode = isset($data['mode']) ? $data['mode'] : null;
        $this->uiMode = isset($data['ui_mode']) ? $data['ui_mode'] : null;
        $this->amount = isset($data['amount']) ? $data['amount'] : null;
        $this->currency = isset($data['currency']) ? $data['currency'] : null;
        $this->merchantOrderId = isset($data['merchant_order_id']) ? $data['merchant_order_id'] : null;
        $this->status = isset($data['status']) ? $data['status'] : null;
        $this->paymentStatus = isset($data['payment_status']) ? $data['payment_status'] : null;
        $this->customerId = isset($data['customer_id']) ? $data['customer_id'] : null;
        $this->customer = isset($data['customer']) ? $data['customer'] : null;
        $this->lineItems = isset($data['line_items']) ? $data['line_items'] : null;
        $this->subscriptionData = isset($data['subscription_data']) ? $data['subscription_data'] : null;
        $this->collectionMethod = isset($data['collection_method']) ? $data['collection_method'] : null;
        $this->paymentMethodTypes = isset($data['payment_method_types']) ? $data['payment_method_types'] : null;
        $this->metadata = isset($data['metadata']) ? $data['metadata'] : null;
        $this->created = isset($data['created']) ? $data['created'] : null;
        $this->expiresAt = isset($data['expires_at']) ? $data['expires_at'] : null;
        $this->clientSecret = isset($data['client_secret']) ? $data['client_secret'] : null;
        $this->subscriptionId = isset($data['subscription_id']) ? $data['subscription_id'] : null;
        $this->paymentIntentId = isset($data['payment_intent_id']) ? $data['payment_intent_id'] : null;
        $this->billing = isset($data['billing']) ? $data['billing'] : null;
        $this->shipping = isset($data['shipping']) ? $data['shipping'] : null;
        $this->presentmentPaymentMethod = isset($data['presentment_payment_method']) ? $data['presentment_payment_method'] : null;
        $this->ipAddress = isset($data['ip_address']) ? $data['ip_address'] : null;
        $this->countryCode = isset($data['country_code']) ? $data['country_code'] : null;
    }
    
    /**
     * Check if session is open
     * 
     * @return bool
     */
    public function isOpen()
    {
        return $this->status === self::STATUS_OPEN;
    }
    
    /**
     * Check if session is complete
     * 
     * @return bool
     */
    public function isComplete()
    {
        return $this->status === self::STATUS_COMPLETE;
    }
    
    /**
     * Check if session is expired
     * 
     * @return bool
     */
    public function isExpired()
    {
        return $this->status === self::STATUS_EXPIRED;
    }
    
    /**
     * Check if payment is paid
     * 
     * @return bool
     */
    public function isPaid()
    {
        return $this->paymentStatus === self::PAYMENT_STATUS_PAID;
    }
    
    /**
     * Check if mode is subscription
     * 
     * @return bool
     */
    public function isSubscription()
    {
        return $this->mode === self::MODE_SUBSCRIPTION;
    }
    
    /**
     * Check if mode is one-time payment
     * 
     * @return bool
     */
    public function isPayment()
    {
        return $this->mode === self::MODE_PAYMENT;
    }
}
