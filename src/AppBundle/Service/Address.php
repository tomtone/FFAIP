<?php
namespace AppBundle\Service;

use AppBundle\Entity\Address as AddressEntity;

class Address extends AbstractAdminRequest
{
    public function saveAddress($address)
    {
        $address = $this->requestFactory->prepareSaveAddressRequest($address);
        $this->session->set('cart_request', $address);
    }

    public function addShippingMethod($shippingMethod)
    {
        $request = $this->requestFactory->getShippingMethodsRequest();
        $methods = $this->request($request);
        $selectedMethod = [];
        foreach ($methods as $method){
            if($method['carrier_code'] == $shippingMethod['carrier']){
                $selectedMethod = $method;
                break;
            }
        }

        $addressData = $this->session->get('cart_request');
        $addressData['addressInformation']['shipping_method_code'] = $selectedMethod['method_code'];
        $addressData['addressInformation']['shipping_carrier_code'] = $selectedMethod['carrier_code'];
        $this->session->set('cart_request', $addressData);
    }

    public function addBillingAddressMethod($address)
    {
        $addressData = $this->session->get('cart_request');
        $addressData['addressInformation']['billing_address'] = $billingAddress = (new AddressEntity($address, AddressEntity::ADDRESS_TYPE_BILLING))->toArray();
        $this->session->set('cart_request', $addressData);
    }

    public function addPayment($payment)
    {
        $request = $this->requestFactory->addPaymentMethodRequest($payment);
        $response = $this->request($request);
    }

    public function placeOrder()
    {
        $request = $this->requestFactory->placeOrderRequest();
        $response = $this->request($request);
        dump($response);
    }
}