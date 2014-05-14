<?php

namespace phpDocumentor\Configuration;

use Cilex\Application;
use Cilex\ServiceProviderInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use JMS\Serializer\Serializer;
use Zend\Config\Factory;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * Adds the Configuration object to the DIC.
     *
     * phpDocumentor first loads the template config file (/data/phpdoc.tpl.xml)
     * and then the phpdoc.dist.xml, or the phpdoc.xml if it exists but not both,
     * from the current working directory.
     *
     * The user config file (either phpdoc.dist.xml or phpdoc.xml) is merged
     * with the template file.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        if (!isset($app['serializer.annotations'])) {
            throw new \RuntimeException(
                'The configuration service provider depends on the JmsSerializer Service Provider but the '
                . '"serializer.annotations" key could not be found in the container.'
            );
        }

        // Add annotations to Jms Serializer
        $annotations = $app['serializer.annotations'];
        $annotations[] = array(
            'namespace' => 'phpDocumentor\Configuration\Merger\Annotation',
            'path' => __DIR__ . '/../../'
        );
        $app['serializer.annotations'] = $annotations;

        $app['config.merger'] = $app->share(
            function () {
                return new Merger(new AnnotationReader());
            }
        );

        $app['config2'] = $app->share(
            function ($app) {
                /** @var Serializer $serializer */
                $serializer = $app['serializer'];

                $template = $serializer->deserialize(
                    file_get_contents($app['config.path.template']),
                    'phpDocumentor\Configuration\Configuration',
                    'xml'
                );

                $userConfigFile = $serializer->deserialize(
                    file_get_contents($app['config.path.user']),
                    'phpDocumentor\Configuration\Configuration',
                    'xml'
                );

                /** @var Merger $merger */
                $merger = $app['config.merger'];

                return $merger->run($template, $userConfigFile);
            }
        );

        $app['config.path.template'] = __DIR__ . '/Resources/phpdoc.tpl.xml';
        $app['config.path.user'] = getcwd()
            . ((file_exists(getcwd() . '/phpdoc.xml')) ? '/phpdoc.xml' : '/phpdoc.dist.xml');

        $app['config'] = $app->share(
            function ($app) {
                $config_files = array($app['config.path.template']);
                if (is_readable($app['config.path.user'])) {
                    $config_files[] = $app['config.path.user'];
                }

                return Factory::fromFiles($config_files, true);
            }
        );
    }
} 