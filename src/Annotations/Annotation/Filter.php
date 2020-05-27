<?php

namespace Ryvon\PluginAnnotatedHandler\Annotations\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Filter
{
    /**
     * @Required
     * @var string
     */
    public $tag;

    /**
     * @var int
     */
    public $priority = 10;

    /**
     * @var bool
     */
    public $onlyAdmin = false;

    /**
     * @var bool
     */
    public $onlyFrontend = false;
}
