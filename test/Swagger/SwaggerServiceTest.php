<?php


namespace Basster\Silex\Provider\Test\Swagger;


use Basster\Silex\Provider\Swagger\SwaggerConfig;
use Basster\Silex\Provider\Swagger\SwaggerService;
use Basster\Silex\Provider\Test\Swagger\Dummy\SwaggerService as SwaggerDummy;
use Symfony\Component\HttpFoundation\Response;

class SwaggerServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getSwaggerResponse()
    {
        $swagger = 'foobar';
        $maxAge  = 60;

        $config = $this->prophesize('Basster\Silex\Provider\Swagger\SwaggerConfig');

        $service = new SwaggerDummy($config->reveal());
        $service->setSwagger($swagger);
        $cache = ['max_age' => $maxAge];

        $response = $service->getSwaggerResponse($cache);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals('application/json',
          $response->headers->get('Content-Type'));
        self::assertEquals('"' . md5($swagger) . '"',
          $response->headers->get('ETag'));
        self::assertSame($response->getMaxAge(), $maxAge);
    }

    /**
     * @test
     */
    public function getSwagger()
    {
        $service = new SwaggerService(new SwaggerConfig(__DIR__ . '/Swag'));
        $swagger = $service->getSwagger();

        self::assertInstanceOf('\Swagger\Annotations\Swagger', $swagger);
        self::assertContains('"title": "My First API"', (string)$swagger);
        self::assertContains('"version": "0.1"', (string)$swagger);
    }
}
