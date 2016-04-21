<?php

namespace Basster\Silex\Provider\Swagger;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SwaggerService
 *
 * @package Basster\Silex\Provider\Swagger
 */
class SwaggerService
{
    /**
     * @var SwaggerConfig
     */
    private $config;

    /**
     * @var array
     */
    private $cacheConfig;

    /**
     * SwaggerService constructor.
     *
     * @param SwaggerConfig $config
     * @param array         $cacheConfig
     */
    public function __construct(SwaggerConfig $config, array $cacheConfig = [])
    {
        $this->config      = $config;
        $this->cacheConfig = $cacheConfig;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \InvalidArgumentException
     */
    public function getSwaggerResponse(Request $request)
    {
        $swagger = $this->getSwagger();

        $response = Response::create(
          $swagger,
          Response::HTTP_OK,
          ['Content-Type' => 'application/json']
        );
        $response->setCache($this->cacheConfig);
        $response->setEtag(md5($swagger));
        $response->isNotModified($request);

        return $response;
    }

    /**
     * @return \Swagger\Annotations\Swagger
     */
    public function getSwagger()
    {
        $swagger = \Swagger\scan(
          $this->config->getBasePath(),
          $this->config->getScanOptions()
        );

        return $swagger;
    }
}
