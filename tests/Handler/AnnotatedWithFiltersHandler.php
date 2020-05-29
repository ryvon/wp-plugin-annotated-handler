<?php

namespace Ryvon\PluginAnnotatedHandler;

use Ryvon\PluginAnnotatedHandler\Annotations\Annotation\Action;
use Ryvon\PluginAnnotatedHandler\Annotations\Annotation\Filter;
use Ryvon\PluginAnnotatedHandler\Handler\AnnotatedHandler;

class AnnotatedWithFiltersHandler extends AnnotatedHandler
{
    /**
     * @Filter("body_class")
     *
     * @param array $classes
     * @return array
     */
    public function onlyTag($classes): array
    {
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
        return $info;
    }

    /**
     * @Filter("body_class")
     *
     * @param array $classes
     * @return array
     */
    protected function ignoredProtectedFunction($classes): array
    {
        return $classes;
    }

    /**
     * @Filter("body_class")
     *
     * @param array $classes
     * @return array
     */
    private function ignoredPrivateFunction($classes): array
    {
        return $classes;
    }
}
