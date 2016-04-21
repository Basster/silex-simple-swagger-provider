<?php

namespace Basster\Silex\Provider\Swagger;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Swagger\Annotations as SWG;

class SwaggerProvider implements ServiceProviderInterface, SwaggerServiceKey
{
    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app[self::SWAGGER_API_DOC_PATH] = '/api/api-docs';
        $app[self::SWAGGER_EXCLUDE_PATH] = null;
        $app[self::SWAGGER_CACHE]        = [];
        $app[self::SWAGGER_SERVICE_PATH] = null;
        $app[self::SWAGGER_ANALYSER]     = null;
        $app[self::SWAGGER_ANALYSIS]     = null;
        $app[self::SWAGGER_PROCESSORS]   = [];

        $app[self::SWAGGER_CONFIG] = $app::share(function (Application $app) {
            return new SwaggerConfig(
              $app[self::SWAGGER_SERVICE_PATH],
              $app[self::SWAGGER_ANALYSER],
              $app[self::SWAGGER_ANALYSIS],
              $app[self::SWAGGER_PROCESSORS],
              $app[self::SWAGGER_EXCLUDE_PATH]
            );
        });

        $app[self::SWAGGER_SERVICE] = $app::share(function (Application $app) {
            return new SwaggerService(
              $app[self::SWAGGER_CONFIG],
              $app[self::SWAGGER_CACHE]
            );
        });

        $app[self::SWAGGER] = $app::share(function (Application $app) {
            /** @var SwaggerService $swagger */
            $swagger = $app[self::SWAGGER_SERVICE];
            return $swagger->getSwagger();
        });
    }

    /** {@inheritdoc} */
    public function boot(Application $app)
    {
        $app->get(
          $app[self::SWAGGER_API_DOC_PATH],
          [$app[self::SWAGGER_SERVICE], 'getSwaggerResponse']
        );
    }
}
