<?php


namespace Basster\Silex\Provider\Swagger;


interface SwaggerServiceKey
{

    const SWAGGER_SERVICE      = 'service.swagger';
    const SWAGGER_PROCESSORS   = 'swagger.processors';
    const SWAGGER_SERVICE_PATH = 'swagger.servicePath';
    const SWAGGER_EXCLUDE_PATH = 'swagger.excludePath';
    const SWAGGER_API_DOC_PATH = 'swagger.apiDocPath';
    const SWAGGER_ANALYSER     = 'swagger.analyser';
    const SWAGGER              = 'swagger';
    const SWAGGER_ANALYSIS     = 'swagger.analysis';
    const SWAGGER_CONFIG       = 'swagger.config';
    const SWAGGER_CACHE        = 'swagger.cache';
}
