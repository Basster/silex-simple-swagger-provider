<?php


namespace Basster\Silex\Provider\Test\Swagger;


use Basster\Silex\Provider\Swagger\SwaggerProvider;
use Basster\Silex\Provider\Swagger\SwaggerServiceKey;
use Silex\Application;
use Silex\ControllerCollection;

class SwaggerProviderTest extends \PHPUnit_Framework_TestCase implements SwaggerServiceKey
{
    /**
     * @test
     * @dataProvider provideDataForDefaultValue
     */
    public function defaultValue($key, $value = null)
    {
        $app = $this->getAppWithRegisteredProvider();

        self::assertArrayHasKey($key, $app);
        self::assertEquals($value, $app[$key]);
    }

    public function provideDataForDefaultValue()
    {
        return [
          self::SWAGGER_API_DOC_PATH => [
            self::SWAGGER_API_DOC_PATH,
            '/api/api-docs',
          ],
          self::SWAGGER_EXCLUDE_PATH => [self::SWAGGER_EXCLUDE_PATH],
          self::SWAGGER_CACHE        => [self::SWAGGER_CACHE, []],
          self::SWAGGER_SERVICE_PATH => [self::SWAGGER_SERVICE_PATH],
          self::SWAGGER_ANALYSER     => [self::SWAGGER_ANALYSER],
          self::SWAGGER_ANALYSIS     => [self::SWAGGER_ANALYSIS],
          self::SWAGGER_PROCESSORS   => [self::SWAGGER_PROCESSORS, []],
        ];
    }

    /**
     * @test
     */
    public function isSwaggerConfigRegistered()
    {
        $app = $this->getAppWithRegisteredProvider([self::SWAGGER_SERVICE_PATH => __DIR__]);

        self::assertArrayHasKey(self::SWAGGER_CONFIG, $app);
        self::assertInstanceOf('Basster\Silex\Provider\Swagger\SwaggerConfig',
          $app[self::SWAGGER_CONFIG]);

    }

    /**
     * @test
     */
    public function isSwaggerServiceRegistered()
    {
        $config = $this->prophesize('Basster\Silex\Provider\Swagger\SwaggerConfig');

        $app = $this->getAppWithRegisteredProvider([self::SWAGGER_CONFIG => $config->reveal()]);

        self::assertArrayHasKey(self::SWAGGER_SERVICE, $app);
        self::assertInstanceOf('Basster\Silex\Provider\Swagger\SwaggerService',
          $app[self::SWAGGER_SERVICE]);
    }

    /**
     * @test
     */
    public function isSwaggerRegistered()
    {
        $swagger = $this->prophesize('Swagger\Annotations\Swagger')->reveal();
        $service = $this->prophesize('Basster\Silex\Provider\Swagger\SwaggerService');
        $service->getSwagger()->shouldBeCalled()->willReturn($swagger);

        $app                        = $this->getAppWithRegisteredProvider();
        $app[self::SWAGGER_SERVICE] = $service->reveal();

        self::assertArrayHasKey(self::SWAGGER, $app);
        self::assertEquals($swagger, $app[self::SWAGGER]);
    }

    /**
     * @test
     */
    public function isApiRouteRegistered()
    {
        $app  = new Application();
        $path = '/docs/swagger.json';
        $app->register(new SwaggerProvider(),
          [self::SWAGGER_API_DOC_PATH => $path]);
        $app->boot();

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers'];
        $routes      = $controllers->flush()->all();


        self::assertArrayHasKey('GET_docs_swagger.json', $routes);
        $route = $routes['GET_docs_swagger.json'];
        self::assertEquals($path, $route->getPath());
    }

    /**
     * @param $values
     *
     * @return \Silex\Application
     */
    public function getAppWithRegisteredProvider(array $values = [])
    {
        $app = new Application($values);
        $app->register(new SwaggerProvider());
        return $app;
    }
}
