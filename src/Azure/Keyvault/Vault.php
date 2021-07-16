<?php

namespace Vault\Azure\Keyvault;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

abstract class Vault
{
    private $accessToken;
    private $keyVault;

    public function __construct(array $keyVaultDetails)
    {
        // set connection key vault name
        $this->setKeyVaultName($keyVaultDetails['keyVaultName']);

        // set access token
        $this->accessToken = $keyVaultDetails['accessToken'];
    }

    /*
    * Set the name of the key vault you want to interact with
    */
    private function setKeyVaultName($keyVaultName)
    {
        $this->keyVault = "https://$keyVaultName.vault.azure.net/";
    }

    /*
    * Create the API call to the Azure RM API
    */
    protected function requestApi($method, $apiCall, $json = null): array
    {
        $client = new Client(
            [
                'base_uri' => $this->keyVault,
                'timeout'  => 2.0
            ]
        );

        try {
            $result = $client->request(
                $method,
                $apiCall,
                [
                    'headers' => [
                        'User-Agent'    => 'browser/1.0',
                        'Accept'        => 'application/json',
                        'Content-Type'  => 'application/json',
                        'Authorization' => "Bearer " . $this->accessToken
                    ],
                    'json'    => $json
                ]
            );

            return $this->setOutput(
                $result->getStatusCode(),
                $result->getReasonPhrase(),
                json_decode($result->getBody()->getContents(), true)
            );
        } catch (ClientException $e) {
            $array = json_decode($e->getResponse()->getBody()->getContents(), true);
            return $this->setOutput(
                $e->getResponse()->getStatusCode(),
                array_shift($array)
            );
        } catch (RequestException $e) {
            return $this->setOutput(
                500,
                $e->getHandlerContext()['error']
            );
        } catch (GuzzleException $e) {
            return $this->setOutput(500, $e->getMessage());
        }
    }

    /*
    * Create an array to control output
    */
    private function setOutput($code, $message, $data = null): array
    {
        return [
            'responsecode'    => $code,
            'responseMessage' => $message,
            'data'            => $data
        ];
    }
}
