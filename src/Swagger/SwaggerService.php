<?php

namespace Basster\Silex\Provider\Swagger;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SwaggerService
 *
 * @package Basster\Silex\Provider\Swagger
 */
class SwaggerService
{
    /**
     * @var \Basster\Silex\Provider\Swagger\SwaggerConfig
     */
    private $config;

    /**
     * SwaggerService constructor.
     *
     * @param \Basster\Silex\Provider\Swagger\SwaggerConfig $config
     */
    public function __construct(SwaggerConfig $config)
    {
        $this->config = $config;
    }


    /**
     * @param array $cache
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \InvalidArgumentException
     */
    public function getSwaggerResponse($cache = [])
    {
        $swagger = $this->getSwagger();

        $response = new Response(
          $swagger,
          Response::HTTP_OK,
          ['Content-Type' => 'application/json']
        );
        $response->setCache($cache);
        $response->setEtag(md5($swagger));

        return $response;
    }

    /**
     * @return \Swagger\Annotations\Swagger
     */
    public function getSwagger()
    {
        $swagger = \Swagger\scan($this->config->getBasePath(),
          $this->config->getScanOptions());
        return $swagger;
    }
}
