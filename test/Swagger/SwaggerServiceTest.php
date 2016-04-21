<?php


namespace Basster\Silex\Provider\Test\Swagger;


use Basster\Silex\Provider\Swagger\SwaggerConfig;
use Basster\Silex\Provider\Swagger\SwaggerService;
use Basster\Silex\Provider\Swagger\SwaggerServiceKey;
use Basster\Silex\Provider\Test\Swagger\Dummy\SwaggerService as SwaggerDummy;
use Symfony\Component\HttpFoundation\Request;
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
        $cache  = ['max_age' => $maxAge];

        $service = new SwaggerDummy($config->reveal(), $cache);
        $service->setSwagger($swagger);

        $request  = Request::create(SwaggerServiceKey::SWAGGER_API_DOC_PATH);
        $response = $service->getSwaggerResponse($request);

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
