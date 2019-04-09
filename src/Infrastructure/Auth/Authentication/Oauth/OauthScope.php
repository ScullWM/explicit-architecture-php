<?php

declare(strict_types=1);

namespace Acme\App\Infrastructure\Auth\Authentication\Oauth;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

final class OauthScope implements ScopeEntityInterface
{
    use EntityTrait;

    /**
     * @var array
     */
    public static $scopes = [];

    /**
     * Scope constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->setIdentifier($name);
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public static function hasScope($id): bool
    {
        return $id === '*' || array_key_exists($id, static::$scopes);
    }

    /**
     * Get the data that should be serialized to JSON.
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->getIdentifier();
    }
}
