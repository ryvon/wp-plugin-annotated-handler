<?php

namespace Ryvon\PluginAnnotatedHandler;

use Ryvon\PluginAnnotatedHandler\Annotations\Annotation\Action;
use Ryvon\PluginAnnotatedHandler\Handler\AnnotatedHandler;

class AnnotatedWithActionsHandler extends AnnotatedHandler
{
    /**
     * @Action("init")
     */
    public function onlyTag(): void
    {
        echo __METHOD__;
    }

    /**
     * @Action(tag="wp_head", priority=100, onlyAdmin=true)
     */
    public function withOptionsAdmin(): void
    {
        echo __METHOD__;
    }

    /**
     * @Action(tag="wp_head", priority=105, onlyFrontend=true)
     */
    public function withOptionsFrontend(): void
    {
        echo __METHOD__;
    }

    /**
     * @Action(tag="load_textdomain")
     *
     * @param string $domain Unique domain for translation.
     * @param string $mofile Path to the .mo file.
     * @return mixed
     */
    public function withArguments($domain, $mofile)
    {
        return [];
    }
}
