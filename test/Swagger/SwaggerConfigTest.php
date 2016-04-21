<?php


namespace Basster\Silex\Provider\Test\Swagger;


use Basster\Silex\Provider\Swagger\SwaggerConfig;
use Swagger\Analysis;

class SwaggerConfigTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @dataProvider provideDataForGetScanOptions
     */
    public function getScanOptions($keyAndMethod, $value)
    {
        $config = new SwaggerConfig(__DIR__);
        $method = 'set' . ucfirst($keyAndMethod);
        $config->$method($value);

        self::assertEquals([$keyAndMethod => $value],
          $config->getScanOptions());
    }

    public function provideDataForGetScanOptions()
    {
        return [
          'exclude'    => ['exclude', __DIR__],
          'analyser'   => [
            'analyser',
            $this->prophesize('Swagger\StaticAnalyser')->reveal(),
          ],
          'analysis'   => [
            'analysis',
            $this->prophesize('Swagger\Analysis')->reveal(),
          ],
          'processors' => [
            'processors',
            Analysis::processors(),
          ],
        ];
    }
}
