<?php

namespace Basster\Silex\Provider\Test\Swagger\Dummy;

use Basster\Silex\Provider\Swagger\SwaggerService as BaseService;

class SwaggerService extends BaseService
{
    private $swagger;

    /**
     * @param mixed $swagger
     */
    public function setSwagger($swagger)
    {
        $this->swagger = $swagger;
    }

    public function getSwagger()
    {
        return $this->swagger;
    }
}
