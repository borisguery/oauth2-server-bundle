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
        if (!$container->hasDefinition('bgy_oauth2_server.authorization_server')) {

            return;
        }

        $taggedServices = $container->findTaggedServiceIds('bgy_oauth2_server.grant_type_extension');

        $configurationDefinition = $container
            ->getDefinition('bgy_oauth2_server.authorization_server')
        ;

        $grantTypesServices = is_array($configurationDefinition->getArgument(4))
            ? $configurationDefinition->getArgument(4)
            : []
        ;

        foreach ($taggedServices as $id => $attributes) {
            $grantTypesServices[] = new Reference($id);
        }

        $configurationDefinition->replaceArgument(4, $grantTypesServices);
    }
}
