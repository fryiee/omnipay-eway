<?php
/**
 * eWAY Rapid Direct Query Card Request
 */

namespace Omnipay\Eway\Message;

/**
 * eWAY Rapid Direct Query Card Request
 *
 * Get the stored details from a payment token through the Rapid API.
 */
class RapidDirectQueryCardRequest extends RapidDirectAbstractRequest
{
    public function getData()
    {
        $data = $this->getBaseData();

        $this->validate('cardReference');

        $data['Payment'] = array();
        $data['Payment']['TotalAmount'] = 0;

        $data['Customer']['TokenCustomerID'] = $this->getCardReference();

        $data['Method'] = 'QueryTokenCustomer';

        return $data;
    }

    protected function getEndpoint()
    {
        return $this->getEndpointBase().'/DirectPayment.json';
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post($this->getEndpoint(), null, json_encode($data))
            ->setAuth($this->getApiKey(), $this->getPassword())
            ->send();

        return $this->response = new RapidResponse($this, $httpResponse->json());
    }
}
