<?php

namespace Vault\Azure\Keyvault;

class Key extends Vault
{
    public function __construct(array $keyVaultDetails)
    {
        parent::__construct($keyVaultDetails);
    }

    /*
    * Encrypts a string using a key from an Azure Key Vault
    */

    public function encrypt(string $keyName, string $version, string $value)
    {

        $apiCall = "keys/$keyName/$version/encrypt?api-version=2016-10-01";

        $options = [
            'alg'   => 'RSA-OAEP',
            'value' => $value
        ];

        return $this->requestApi('POST', $apiCall, $options);
    }

    /*
    * Decrypt's a string using a key from an Azure Key Vault
    */

    public function decrypt(string $keyName, string $version, string $value)
    {
        $apiCall = "keys/$keyName/$version/decrypt?api-version=2016-10-01";

        $options = [
            'alg'   => 'RSA-OAEP',
            'value' => $value
        ];

        return $this->requestApi('POST', $apiCall, $options);
    }
}
