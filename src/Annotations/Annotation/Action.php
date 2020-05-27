<?php

namespace Ryvon\PluginAnnotatedHandler\Annotations\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Action
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
