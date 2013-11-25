<?php

namespace Pimx\DoctrineBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Pimx\DoctrineBundle\DependencyInjection\CompilerPass\ConnectionCompilerPass;

class PimxDoctrineBundle extends Bundle {

    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new ConnectionCompilerPass());
    }

}
