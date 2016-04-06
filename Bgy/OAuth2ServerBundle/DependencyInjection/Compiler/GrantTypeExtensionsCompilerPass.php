<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2ServerBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class GrantTypeExtensionsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('bgy_oauth2_server.authorization_server.configuration')) {

            return;
        }

        $taggedServices = $container->findTaggedServiceIds('bgy_oauth2_server.grant_type_extension');

        $configurationDefinition = $container
            ->getDefinition('bgy_oauth2_server.authorization_server.configuration')
        ;

        $grantTypesServices = is_array($configurationDefinition->getArgument(3))
            ? $configurationDefinition->getArgument(3)
            : []
        ;

        foreach ($taggedServices as $id => $attributes) {
            $grantTypesServices[] = new Reference($id);
        }

        $configurationDefinition->replaceArgument(3, $grantTypesServices);
    }
}
