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

// Delete a Key Vault Secret
$keyVault->delete('T3');
