<?php

namespace Bgy\OAuth2ServerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bgy_o_auth2_server');

        $rootNode
            ->children()
                ->arrayNode('authorization_server')
                    ->children()
                        ->arrayNode('storage')
                            ->children()
                                ->scalarNode('access_token')
                                ->end()
                                ->scalarNode('refresh_token')
                                ->end()
                                ->scalarNode('client')
                                ->end()
                            ->end()
                        ->end()
                        ->scalarNode('token_generator')->end()
                        ->booleanNode('always_generate_a_refresh_token')
                            ->defaultTrue()
                        ->end()
                        ->booleanNode('always_require_a_client')
                            ->defaultTrue()
                        ->end()
                        ->integerNode('access_token_ttl')
                            ->defaultValue(3600)
                        ->end()
                        ->integerNode('refresh_token_ttl')
                            ->defaultValue(3600)
                        ->end()
                        ->arrayNode('grant_types')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;


        return $treeBuilder;
    }
}
