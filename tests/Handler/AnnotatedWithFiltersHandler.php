<?php

namespace Ryvon\PluginAnnotatedHandler;

use Ryvon\PluginAnnotatedHandler\Annotations\Annotation\Action;
use Ryvon\PluginAnnotatedHandler\Annotations\Annotation\Filter;
use Ryvon\PluginAnnotatedHandler\Handler\AnnotatedHookHandler;

class AnnotatedWithFiltersHandler extends AnnotatedHookHandler
{
    /**
     * @Filter("body_class")
     *
     * @param array $classes
     * @return array
     */
    public function onlyTag($classes): array
    {
        $classes[] = __METHOD__;

        return $classes;
    }

    /**
     * @Filter(tag="the_content", priority=100, onlyFrontend=true)
     *
     * @param string $content
     * @return string
     */
    public function withOptionsFrontend($content): string
    {
        $content .= __METHOD__;
        return $content;
    }

    /**
     * @Filter(tag="the_content", priority=105, onlyAdmin=true)
     *
     * @param string $content
     * @return string
     */
    public function withOptionsAdmin($content): string
    {
        $content .= __METHOD__;
        return $content;
    }

    /**
     * @Filter("wp_new_user_notification_email")
     *
     * @param array $info
     * @param object $user
     * @param string $blogName
     * @return mixed
     */
    public function withArguments($info, $user, $blogName)
    {
        if (!is_array($info)) {
            return $info;
        }

        echo __METHOD__;

        return $info;
    }
}
