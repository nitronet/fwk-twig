<?php
namespace Nitronet\Fwk\Twig;

use Fwk\Core\Application;
use Fwk\Core\Components\ResultType\ResultTypeServiceLoadedEvent;
use Fwk\Di\ClassDefinition;
use Fwk\Di\Container;
use Fwk\Core\Plugin;

class TwigPlugin implements Plugin
{
    protected $config = array();

    public function __construct(array $config = array())
    {
        $this->config = array_merge(array(
            'directory'     => null,
            'debug'         => false,
            'twig'          => array(),
            'typeName'      => 'twig',
            'serviceName'   => 'twig'
        ), $config);
    }

    public function loadServices(Container $container)
    {
        // twig loader
        $defLoader = new ClassDefinition('\Twig_Loader_Filesystem', array(
            $this->cfg('directory', null)
        ));
        $container->set('twig.Loader', $defLoader);

        // twig
        $defTwig = new ClassDefinition('\Twig_Environment', array(
            '@twig.Loader',
            $this->cfg('twig', array())
        ));
        $container->set($this->cfg('serviceName', 'twig'), $defTwig, true);

        // debug
        if ($this->cfg('debug', false) == true) {
            $defDebugExt = new ClassDefinition('\Twig_Extension_Debug');
            $container->set('twig.DebugExtension', $defDebugExt);
            $defTwig->addMethodCall('addExtension', array('@twig.DebugExtension'));
        }
    }

    public function onResultTypeServiceLoaded(ResultTypeServiceLoadedEvent $event)
    {
        $event->getResultTypeService()->addType($this->cfg('typeName', 'twig'), new TwigResultType(array(
            'twigService' => $this->cfg('serviceName', 'twig')
        )));
    }

    public function load(Application $app)
    {
        // nothing to do here
    }

    protected function cfg($key, $default = false)
    {
        return (array_key_exists($key, $this->config) ? $this->config[$key] : $default);
    }
}