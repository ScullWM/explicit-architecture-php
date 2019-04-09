<?php

declare(strict_types=1);

namespace Acme\App\Infrastructure\Auth\Authentication\Oauth;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

final class OauthClientRepository implements ClientRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getClientEntity(
        $clientIdentifier,
        $grantType = null,
        $clientSecret = null,
        $mustValidateSecret = true
    ): ?ClientEntityInterface {
        $appClient = $this->appClientRepository->findActive($clientIdentifier);
        if ($appClient === null) {
            return null;
        }
        if ($mustValidateSecret && !hash_equals($appClient->getSecret(), (string) $clientSecret)) {
            return null;
        }
        $oauthClient = new OauthClient($clientIdentifier, $appClient->getName(), $appClient->getRedirect());

        return $oauthClient;
    }
}
