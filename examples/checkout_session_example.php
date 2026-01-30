<?php
/**
 * Checkout Session Examples
 * 
 * This file demonstrates how to use the Checkout Session API
 * for both one-time payments and subscription payments.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use UseePay\UseePay;
use UseePay\UseePayClient;
use UseePay\Model\Authentication\Authentication;
use UseePay\Net\ApiEnvironment;
use UseePay\Model\Checkout\CheckoutSession;

// Initialize UseePay authentication
$authentication = new Authentication(
    '500000000014542',
    'www.paycc.com',
    'UseePay_SK_TEST_R44tyTYEJ41bdQzFatdEtED9fbqEBVP1uHaRb145glbGdgvHeWIMQDf26wuWfdc1H1UNHw1G6UrPULktzhk0tpHfsMN88xDjjL1x'
);

// Create client with sandbox environment
$client = UseePayClient::withEnvironment(
    ApiEnvironment::SANDBOX,
    $authentication
);

// Set timeouts
UseePay::setConnectTimeout(30);
UseePay::setReadTimeout(60);

/**
 * Example 1: Create a one-time payment checkout session
 */
function createPaymentSession($client)
{
    echo "=== Creating One-time Payment Checkout Session ===\n";
    
    $params = array(
        'mode' => CheckoutSession::MODE_PAYMENT,
        'ui_mode' => CheckoutSession::UI_MODE_CUSTOM,
        'amount' => 99.99,
        'currency' => 'USD',
        'merchant_order_id' => 'order_' . time() . '_' . rand(1000, 9999),
        'customer' => array(
            'email' => 'customer@example.com',
            'name' => 'John Doe',
            'phone' => '+1234567890',
            'merchant_customer_id' => 'cust_' . time()
        ),
        'line_items' => array(
            array(
                'quantity' => 1,
                'price_data' => array(
                    'product_data' => array(
                        'name' => 'Premium Product',
                        'desc' => 'High quality product with premium features'
                    ),
                    'unit_amount' => 99.99,
                    'currency' => 'USD'
                )
            )
        ),
        'billing' => array(
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'customer@example.com',
            'phone' => '+1234567890',
            'address' => array(
                'line1' => '123 Main Street',
                'city' => 'New York',
                'state' => 'NY',
                'postcode' => '10001',
                'country' => 'US'
            )
        ),
        'payment_method_types' => array(
            CheckoutSession::PAYMENT_METHOD_CARD,
            CheckoutSession::PAYMENT_METHOD_APPLE_PAY,
            CheckoutSession::PAYMENT_METHOD_GOOGLE_PAY
        ),
        'metadata' => array(
            'order_type' => 'online',
            'source' => 'web',
            'campaign' => 'summer_sale'
        )
    );
    
    try {
        $session = $client->checkoutSessions()->create($params);
        
        echo "Checkout Session created successfully!\n";
        echo "Session ID: " . $session['id'] . "\n";
        echo "Client Secret: " . $session['client_secret'] . "\n";
        echo "Status: " . $session['status'] . "\n";
        
        return $session;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        return null;
    }
}

/**
 * Example 2: Create a subscription checkout session (without discount)
 */
function createSubscriptionSession($client)
{
    echo "\n=== Creating Subscription Checkout Session ===\n";
    
    $params = array(
        'mode' => CheckoutSession::MODE_SUBSCRIPTION,
        'ui_mode' => CheckoutSession::UI_MODE_CUSTOM,
        'amount' => 99.99,
        'currency' => 'USD',
        'merchant_order_id' => 'sub_order_' . time() . '_' . rand(1000, 9999),
        'customer' => array(
            'email' => 'subscriber@example.com',
            'name' => 'Premium User',
            'phone' => '+1234567890',
            'merchant_customer_id' => 'cust_sub_' . time()
        ),
        'line_items' => array(
            array(
                'quantity' => 1,
                'price_data' => array(
                    'product_data' => array(
                        'name' => 'Premium Monthly Plan',
                        'desc' => 'Unlimited access to all premium features'
                    ),
                    'unit_amount' => 99.99,
                    'currency' => 'USD',
                    'recurring' => array(
                        'interval' => 'month',
                        'interval_count' => 1,
                        'total_billing_cycles' => 12
                    )
                )
            )
        ),
        'billing' => array(
            'first_name' => 'Premium',
            'last_name' => 'User',
            'email' => 'subscriber@example.com',
            'phone' => '+1234567890',
            'address' => array(
                'line1' => '456 Oak Avenue',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'postcode' => '90001',
                'country' => 'US'
            )
        ),
        'subscription_data' => new \stdClass(),
        'collection_method' => CheckoutSession::COLLECTION_METHOD_AUTO_CHARGE,
        'payment_method_types' => array(
            CheckoutSession::PAYMENT_METHOD_CARD
        ),
        'metadata' => array(
            'subscription_type' => 'premium',
            'billing_cycle' => 'monthly'
        )
    );
    
    try {
        $session = $client->checkoutSessions()->create($params);
        
        echo "Subscription Checkout Session created successfully!\n";
        echo "Session ID: " . $session['id'] . "\n";
        echo "Client Secret: " . $session['client_secret'] . "\n";
        echo "Status: " . $session['status'] . "\n";
        
        return $session;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        return null;
    }
}

/**
 * Example 3: Create a subscription checkout session with discount period
 */
function createSubscriptionWithDiscountSession($client)
{
    echo "\n=== Creating Subscription with Discount Checkout Session ===\n";
    
    $params = array(
        'mode' => CheckoutSession::MODE_SUBSCRIPTION,
        'ui_mode' => CheckoutSession::UI_MODE_CUSTOM,
        'amount' => 99.99,
        'currency' => 'USD',
        'merchant_order_id' => 'sub_discount_' . time() . '_' . rand(1000, 9999),
        'customer' => array(
            'email' => 'trial@example.com',
            'name' => 'Trial User',
            'phone' => '+1234567890',
            'merchant_customer_id' => 'cust_trial_' . time()
        ),
        'line_items' => array(
            array(
                'quantity' => 1,
                'price_data' => array(
                    'product_data' => array(
                        'name' => 'Premium Monthly Plan',
                        'desc' => 'Unlimited access with first month discount'
                    ),
                    'unit_amount' => 99.99,
                    'currency' => 'USD',
                    'recurring' => array(
                        'interval' => 'month',
                        'interval_count' => 1,
                        'total_billing_cycles' => 12
                    )
                )
            )
        ),
        'billing' => array(
            'first_name' => 'Trial',
            'last_name' => 'User',
            'email' => 'trial@example.com',
            'phone' => '+1234567890',
            'address' => array(
                'line1' => '789 Pine Street',
                'city' => 'Chicago',
                'state' => 'IL',
                'postcode' => '60601',
                'country' => 'US'
            )
        ),
        'subscription_data' => array(
            'discount_period_config' => array(
                'discount_period_count' => 1,
                'discount_period_amount' => 0.01
            )
        ),
        'collection_method' => CheckoutSession::COLLECTION_METHOD_AUTO_CHARGE,
        'payment_method_types' => array(
            CheckoutSession::PAYMENT_METHOD_CARD,
            CheckoutSession::PAYMENT_METHOD_APPLE_PAY,
            CheckoutSession::PAYMENT_METHOD_GOOGLE_PAY
        ),
        'metadata' => array(
            'subscription_type' => 'premium',
            'billing_cycle' => 'monthly',
            'trial_offer' => 'first_month_99_percent_off'
        )
    );
    
    try {
        $session = $client->checkoutSessions()->create($params);
        
        echo "Subscription with Discount Checkout Session created successfully!\n";
        echo "Session ID: " . $session['id'] . "\n";
        echo "Client Secret: " . $session['client_secret'] . "\n";
        echo "Status: " . $session['status'] . "\n";
        
        return $session;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        return null;
    }
}

/**
 * Example 4: Retrieve a checkout session
 */
function retrieveSession($client, $sessionId)
{
    echo "\n=== Retrieving Checkout Session ===\n";
    
    try {
        $session = $client->checkoutSessions()->retrieve($sessionId);
        
        echo "Session retrieved successfully!\n";
        echo "Session ID: " . $session['id'] . "\n";
        echo "Mode: " . $session['mode'] . "\n";
        echo "Status: " . $session['status'] . "\n";
        echo "Payment Status: " . (isset($session['payment_status']) ? $session['payment_status'] : 'N/A') . "\n";
        echo "Amount: " . $session['amount'] . " " . $session['currency'] . "\n";
        
        return $session;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        return null;
    }
}

// Run examples (uncomment to test)
 $paymentSession = createPaymentSession($client);
 $subscriptionSession = createSubscriptionSession($client);
 $discountSession = createSubscriptionWithDiscountSession($client);

 if ($paymentSession) {
     retrieveSession($client, $paymentSession['id']);
 }

echo "Checkout Session SDK Examples loaded.\n";
echo "Uncomment the example calls at the bottom of this file to test.\n";
