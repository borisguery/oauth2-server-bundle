<?php

namespace Bgy\OAuth2ServerBundle\Security;

use Bgy\OAuth2\AccessToken;
use Bgy\OAuth2\Storage\AccessTokenNotFound;
use Bgy\OAuth2\Storage\AccessTokenStorage;
use Bgy\OAuth2ServerBundle\Security\Utils\BearerFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class OAuth2Authenticator extends AbstractGuardAuthenticator
{
    private $accessTokenStorage;

    public function __construct(AccessTokenStorage $accessTokenStorage)
    {
        $this->accessTokenStorage = $accessTokenStorage;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // TODO: Implement start() method.
    }

    public function getCredentials(Request $request)
    {
        if (null !== $rawAccessToken = BearerFetcher::fromRequest($request)) {

            try {

                $accessToken = $this->accessTokenStorage->findByToken($rawAccessToken);

                return $accessToken;

            } catch (AccessTokenNotFound $e) {
                // nothing to do
            }
        }

        return null;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var AccessToken $accessToken */
        $accessToken = $credentials;

        try {
            if ($userProvider->supportsClass($accessToken->getResourceOwner()->getResourceOwnerType())) {

                $userAccount = $userProvider->loadUserByUsername(
                    $accessToken->getResourceOwner()->getResourceOwnerId()
                );

                return $userAccount;
            }
        } catch (UsernameNotFoundException $e) {
            // nothing to do
        }

        return null;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        /** @var AccessToken $accessToken */
        $accessToken = $credentials;

        return !$accessToken->isExpired();
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // TODO: Implement onAuthenticationFailure() method.
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
