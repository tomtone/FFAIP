<?php
namespace AppBundle\Entity;


class Address
{
    const ADDRESS_TYPE_SHIPPING = 'shipping_address';
    const ADDRESS_TYPE_BILLING = 'billing_address';
    protected $type;
    private $customer_id;
    private $prefix;
    private $firstname;
    private $middlename;
    private $lastname;
    private $suffix;
    private $company;
    private $street = [];
    private $city;
    private $country_id;
    private $region;
    private $postcode;
    private $telephone;
    private $fax;
    private $vat_id;
    private $email;

    public function __construct(array $data, $type = self::ADDRESS_TYPE_SHIPPING)
    {
        $this->type = $type;
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $value != null) {
                $this->{$key} = $value;
            } elseif (preg_match("/(street)_[0-9]/", $key) && $value != null) {
                $this->street[] = $value;
            }
        }
    }

    public function toJson()
    {
        $formattedData = $this->getFormattedData();
        return \GuzzleHttp\json_encode($formattedData);
    }

    public function toArray()
    {
        $formattedData = $this->getFormattedData();
        return $formattedData;
    }

    private function getFormattedData()
    {
        $formattedData = [
            'customer_id' => $this->customer_id,
            'prefix' => $this->prefix,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'company' => $this->company,
            'street' => $this->street,
            'city' => $this->city,
            'country_id' => $this->country_id,
            'region' => $this->region,
            'postcode' => $this->postcode,
            'telephone' => $this->telephone,
            'fax' => $this->fax,
            'email' => $this->email,
            'vat_id' => $this->vat_id,
        ];
        return $formattedData;
    }
}