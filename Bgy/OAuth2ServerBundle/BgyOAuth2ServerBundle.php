<?php

namespace Bgy\OAuth2ServerBundle;

use Bgy\OAuth2ServerBundle\DependencyInjection\Compiler\GrantTypeExtensionsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BgyOAuth2ServerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new GrantTypeExtensionsCompilerPass());
    }
}
