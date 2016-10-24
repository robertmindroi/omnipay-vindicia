<?php

namespace Omnipay\Vindicia;

/**
 * Vindicia Gateway
 *
 * This is the standard gateway class for credit card payments. See PayPalGateway for
 * PayPal payments and HOAGateway in order to use Hosted Order Automation to minimize
 * your PCI compliance burden.
 *
 * Note that if you are using test mode, you will need a different username and password.
 * Test mode uses the https://soap.prodtest.sj.vindicia.com endpoint automatically.
 *
 * Example:
 * <code>
 *   // set up the gateway
 *   $gateway = \Omnipay\Omnipay::create('Vindicia');
 *   $gateway->setUsername('your_username');
 *   $gateway->setPassword('y0ur_p4ssw0rd');
 *   $gateway->setTestMode(false);
 *
 *   // create a customer (unlike many gateways, Vindicia requires a customer exist
 *   // before a transaction can occur)
 *   $customerResponse = $gateway->createCustomer(array(
 *       'name' => 'Test Customer',
 *       'email' => 'customer@example.com',
 *       'customerId' => '123456789'
 *   ))->send();
 *
 *   if ($customerResponse->isSuccessful()) {
 *       echo "Customer id: " . $customerResponse->getCustomerId() . PHP_EOL;
 *       echo "Customer reference: " . $customerResponse->getCustomerReference() . PHP_EOL;
 *   } else {
 *       // error handling
 *   }
 *
 *   // purchase!
 *   $purchaseResponse = $gateway->purchase(array(
 *       'items' => array(
 *           array('name' => 'Item 1', 'sku' => '1', 'price' => '3.50', 'quantity' => 1),
 *           array('name' => 'Item 2', 'sku' => '2', 'price' => '9.99', 'quantity' => 2)
 *       ),
 *       'amount' => '23.48', // not necessary since items are provided
 *       'currency' => 'USD',
 *       'customerId' => $customerResponse->getCustomerId(), // you could also use customerReference
 *       'card' => array(
 *           'number' => '5555555555554444',
 *           'expiryMonth' => '01',
 *           'expiryYear' => '2020',
 *           'cvv' => '123',
 *           'postcode' => '12345'
 *       ),
 *       'paymentMethodId' => 'cc-123456', // this ID will be assigned to the card, which will
 *                                         // be attached to the customer's account
 *       'attributes' => array(
 *           'location' => 'FL'
 *       )
 *   ))->send();
 *
 *   if ($purchaseResponse->isSuccessful()) {
 *       // Note: Your transaction ID begins with a prefix you specified in your initial
 *       // Vindicia configuration. The ID is automatically assigned by Vindicia.
 *       echo "Transaction id: " . $purchaseResponse->getTransactionId() . PHP_EOL;
 *       echo "Transaction reference: " . $purchaseResponse->getTransactionReference() . PHP_EOL;
 *   } else {
 *       // error handling
 *   }
 *
 * </code>
 */
class Gateway extends AbstractVindiciaGateway
{
    /**
     * Get the gateway name.
     *
     * @return string
     */
    public function getName()
    {
        return 'Vindicia';
    }

    /**
     * Authorize a transaction. No money will be transfered until the transaction is captured.
     *
     * See Message\AuthorizeRequest for more details.
     *
     * @param array $parameters
     * @return \Omnipay\Vindicia\Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        /**
         * @var \Omnipay\Vindicia\Message\AuthorizeRequest
         */
        return $this->createRequest('\Omnipay\Vindicia\Message\AuthorizeRequest', $parameters);
    }

    /**
     * Purchase something! Money will be transferred. Calling purchase is the equivalent of
     * calling authorize and then calling capture.
     *
     * See Message\PurchaseRequest for more details.
     *
     * @param array $parameters
     * @return \Omnipay\Vindicia\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        /**
         * @var \Omnipay\Vindicia\Message\PurchaseRequest
         */
        return $this->createRequest('\Omnipay\Vindicia\Message\PurchaseRequest', $parameters);
    }

    /**
     * Capture a previously authorized transaction.
     *
     * See Message\CaptureRequest for more details.
     *
     * @param array $parameters
     * @return \Omnipay\Vindicia\Message\CaptureRequest
     */
    public function capture(array $parameters = array())
    {
        /**
         * @var \Omnipay\Vindicia\Message\CaptureRequest
         */
        return $this->createRequest('\Omnipay\Vindicia\Message\CaptureRequest', $parameters);
    }

    /**
     * Voids, or cancels, a previously authorized transaction. Will not work if the transaction
     * has already been captured, either by the capture function or purchase function.
     *
     * See Message\VoidRequest for more details.
     *
     * @param array $parameters
     * @return \Omnipay\Vindicia\Message\VoidRequest
     */
    public function void(array $parameters = array())
    {
        /**
         * @var \Omnipay\Vindicia\Message\VoidRequest
         */
        return $this->createRequest('\Omnipay\Vindicia\Message\VoidRequest', $parameters);
    }

    /**
     * Creates a subscription (recurring payment).
     *
     * See Message\CreateSubscriptionRequest for more details.
     *
     * @param array $parameters
     * @return \Omnipay\Vindicia\Message\CreateSubscriptionRequest
     */
    public function createSubscription(array $parameters = array())
    {
        /**
         * @var \Omnipay\Vindicia\Message\CreateSubscriptionRequest
         */
        return $this->createRequest('\Omnipay\Vindicia\Message\CreateSubscriptionRequest', $parameters);
    }

    /**
     * Update an existing subscription.
     *
     * See Message\CreateSubscriptionRequest for more details.
     *
     * @param array $parameters
     * @return \Omnipay\Vindicia\Message\CreateSubscriptionRequest
     */
    public function updateSubscription(array $parameters = array())
    {
        /**
         * @var \Omnipay\Vindicia\Message\CreateSubscriptionRequest
         */
        return $this->createRequest('\Omnipay\Vindicia\Message\CreateSubscriptionRequest', $parameters, true);
    }

    /**
     * Create a new payment method.
     *
     * See Message\CreatePaymentMethodRequest for more details.
     *
     * @param array $parameters
     * @return \Omnipay\Vindicia\Message\CreatePaymentMethodRequest
     */
    public function createPaymentMethod(array $parameters = array())
    {
        /**
         * @var \Omnipay\Vindicia\Message\CreatePaymentMethodRequest
         */
        return $this->createRequest('\Omnipay\Vindicia\Message\CreatePaymentMethodRequest', $parameters);
    }

    /**
     * Update a payment method.
     *
     * See Message\CreatePaymentMethodRequest for more details.
     *
     * @param array $parameters
     * @return \Omnipay\Vindicia\Message\CreatePaymentMethodRequest
     */
    public function updatePaymentMethod(array $parameters = array())
    {
        /**
         * @var \Omnipay\Vindicia\Message\CreatePaymentMethodRequest
         */
        return $this->createRequest('\Omnipay\Vindicia\Message\CreatePaymentMethodRequest', $parameters, true);
    }

    // see AbstractVindiciaGateway for more functions and documentation
}
