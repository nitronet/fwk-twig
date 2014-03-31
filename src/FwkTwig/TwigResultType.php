<?php
namespace FwkTwig;

use Fwk\Core\Components\ResultType\ResultType;
use Symfony\Component\HttpFoundation\Response;
use Fwk\Core\ServicesAware;
use Fwk\Di\Container;

/**
 * Adds Twig templates support to Fwk/Core
 * @see Fwk\Core\Components\ResultType\ResultType
 * 
 * @category ResultTypes
 * @author   Julien Ballestracci
 */
class TwigResultType implements ResultType, ServicesAware
{
    protected $services;
    protected $params = array();
    
    /**
     * Constructor
     * 
     * @param array $params Twig configuration options
     * 
     * @return void
     */
    public function __construct(array $params = array())
    {
        $this->params = array_merge(
            array(
                'twigService' => "twig"
            ),
            $params
        );
    }
    
    /**
     * Renders a twig template and returns a Response
     * 
     * @param array $actionData Data from the Action Controller
     * @param array $params     Parameters defined in the <result /> block of the 
     * action
     * 
     * @return Response 
     */
    public function getResponse(array $actionData = array(), 
        array $params = array()
    ) {
        if (!isset($params['file']) || empty($params['file'])) {
            throw new Exception(
                sprintf('Missing template "file" parameter')
            );
        } 
        
        $file = $params['file'];
        if (strpos($file, ':', 0) !== false) {
            $paramName = substr($file, 1);
            if (isset($actionData[$paramName])) {
                $file = $actionData[$paramName];
            }
        }
        
        $twig = $this->getServices()->get($this->params['twigService']);
        
        return new Response($twig->render($file, $actionData));
    }
    
    public function getServices()
    {
        return $this->services;
    }
    
    public function setServices(Container $container) 
    {
        $this->services = $container;
    }
}