<?php

namespace Basster\Silex\Provider\Swagger;

class SwaggerConfig
{
    /** @var  mixed */
    private $analyser;

    /** @var  mixed */
    private $analysis;

    /** @var array */
    private $processors = [];

    /** @var  mixed */
    private $exclude;

    /** @var  string */
    private $basePath;

    /**
     * SwaggerConfig constructor.
     *
     * @param string $basePath
     * @param mixed  $analyser
     * @param mixed  $analysis
     * @param array  $processors
     * @param mixed  $exclude
     */
    public function __construct(
      $basePath,
      $analyser = null,
      $analysis = null,
      array $processors = [],
      $exclude = null
    ) {
        $this->analyser   = $analyser;
        $this->analysis   = $analysis;
        $this->processors = $processors;
        $this->exclude    = $exclude;
        $this->basePath   = $basePath;
    }

    /**
     * @param mixed $analyser
     *
     * @return $this
     */
    public function setAnalyser($analyser)
    {
        $this->analyser = $analyser;

        return $this;
    }

    /**
     * @param mixed $analysis
     *
     * @return $this
     */
    public function setAnalysis($analysis)
    {
        $this->analysis = $analysis;
        return $this;
    }

    /**
     * @param array $processors
     *
     * @return $this
     */
    public function setProcessors($processors)
    {
        $this->processors = $processors;
        return $this;
    }

    /**
     * @param mixed $exclude
     *
     * @return $this
     */
    public function setExclude($exclude)
    {
        $this->exclude = $exclude;
        return $this;
    }

    public function getScanOptions()
    {
        $scanOptions = [];
        $properties  = ['exclude', 'analyser', 'analysis', 'processors'];

        foreach ($properties as $property) {
            if ($this->$property) {
                $scanOptions[$property] = $this->$property;
            }
        }

        return $scanOptions;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }
}
