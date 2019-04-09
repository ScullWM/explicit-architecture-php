<?php

declare(strict_types=1);

namespace Acme\App\Infrastructure\Auth\Authentication\Oauth;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

final class OauthScopeRepository implements ScopeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getScopeEntityByIdentifier($identifier): ScopeEntityInterface
    {
        if (OauthScope::hasScope($identifier)) {
            return new OauthScope($identifier);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ): array {
        $filteredScopes = [];
        /** @var OauthScope $scope */
        foreach ($scopes as $scope) {
            $hasScope = OauthScope::hasScope($scope->getIdentifier());
            if ($hasScope) {
                $filteredScopes[] = $scope;
            }
        }

        return $filteredScopes;
    }
}
