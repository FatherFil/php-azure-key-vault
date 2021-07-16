<?php

require_once '../../vendor/autoload.php';

use Vault\Azure\Authorization\Token as azureAuthorisation;
use Vault\Azure\Keyvault\Secret as keyVaultSecret;

$keyVault = new keyVaultSecret(
    [
        'accessToken'  => azureAuthorisation::getKeyVaultToken(
            [
                'appTenantDomainName' => 'contoso.onmicrosoft.com',
                'clientId'            => '00000000-0000-0000-0000-000000000000',
                'clientSecret'        => '5Ki1PHwjbCuDqPQ2f/AAydhjdfhdsdndks7887jhjhs='
            ]
        ),
        'keyVaultName' => 'keyVaultName'
    ]
);

// get the latest value for the secret
var_dump($keyVault->getKeyVaultSecretVersion('T1', 'https://keyVaultName.vault.Azure.net/secrets/T1/2c9f9ed2bdbc463b828e9c19ef558148'));

var_dump($keyVault->getKeyVaultSecretVersion('T1', '2c9f9ed2bdbc463b828e9c19ef558148'));
