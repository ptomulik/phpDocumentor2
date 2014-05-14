<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @copyright 2010-2014 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Configuration;

use JMS\Serializer\Annotation as Serializer;
use phpDocumentor\Configuration\Merger\Annotation as Merger;

/**
 * The definition for the configuration of phpDocumentor.
 */
class Configuration
{
    /**
     * @var string
     * @Serializer\Type("string")
     */
    protected $title;

    /**
     * @var Parser $parser
     * @Serializer\Type("phpDocumentor\Configuration\Parser")
     */
    protected $parser;

    /**
     * @var Logging $logging
     * @Serializer\Type("phpDocumentor\Configuration\Logging")
     */
    protected $logging;

    /**
     * @var Transformer $transformer
     * @Serializer\Type("phpDocumentor\Configuration\Transformer")
     */
    protected $transformer;

    /**
     * @var Files files
     * @Serializer\Type("phpDocumentor\Configuration\Files")
     */
    protected $files;

    /**
     * @var Plugin[] $plugins
     * @Serializer\Type("array<phpDocumentor\Configuration\Plugin>")
     * @Serializer\XmlList(entry = "plugin")
     * @Merger\Replace
     */
    protected $plugins;

    /**
     * @var (Transformation)[]
     * @Serializer\Type("phpDocumentor\Configuration\Transformations")
     */
    protected $transformations;

    /**
     * @var Translator
     * @Serializer\Type("phpDocumentor\Configuration\Translator")
     */
    protected $translator;

    /**
     * @var Partial[]
     * @Serializer\Type("array<phpDocumentor\Configuration\Partial>")
     */
    protected $partials = array();

    /**
     * @return Files
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return Logging
     */
    public function getLogging()
    {
        return $this->logging;
    }

    /**
     * @return Parser
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * @return \string[]
     */
    public function getPartials()
    {
        return $this->partials;
    }

    /**
     * @return Plugin[]
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * @return mixed
     */
    public function getTransformations()
    {
        return $this->transformations;
    }

    /**
     * @return Transformer
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * @return Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
