<?php

namespace Bgy\OAuth2ServerBundle\DependencyInjection;

use Bgy\OAuth2\AuthorizationServerConfiguration;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BgyOAuth2ServerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $authorizationServerConfig = $config['authorization_server'];

        $container->setAlias(
            'bgy_oauth2_server.authorization_server.storage.access_token',
            new Alias($authorizationServerConfig['storage']['access_token'], true)
        );
        $container->setAlias(
            'bgy_oauth2_server.authorization_server.storage.client',
            new Alias($authorizationServerConfig['storage']['client'], true)
        );
        $container->setAlias(
            'bgy_oauth2_server.authorization_server.storage.refresh_token',
            new Alias($authorizationServerConfig['storage']['refresh_token'], true)
        );

        $container->setAlias(
            'bgy_oauth2_server.authorization_server.token_generator',
            new Alias($authorizationServerConfig['token_generator'] ?: 'bgy_oauth2_server.authorization_server.token_generator.php7_csprng', true)
        );

        $authorizationServerConfigurationDefinition = $container->getDefinition('bgy_oauth2_server.authorization_server.configuration');

        $grantTypesServices = [];

        foreach ($authorizationServerConfig['grant_types'] as $serviceId) {
            $grantTypesServices[] = new Reference($serviceId);
        }

        $authorizationServerConfigurationDefinition->replaceArgument(3, $grantTypesServices);
        $authorizationServerConfigurationDefinition->replaceArgument(5, [
            'always_require_a_client'         => $authorizationServerConfig['always_require_a_client'],
            'always_generate_a_refresh_token' => $authorizationServerConfig['always_generate_a_refresh_token'],
            'access_token_ttl'                => $authorizationServerConfig['access_token_ttl'],
            'refresh_token_ttl'               => $authorizationServerConfig['refresh_token_ttl'],
        ]);
    }
}
