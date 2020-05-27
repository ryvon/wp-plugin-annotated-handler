<?php

namespace Ryvon\PluginAnnotatedHandler\Handler;

use Doctrine\Common\Cache\ApcuCache;
use Ryvon\Plugin\Handler\GenericHandlerInterface;
use Ryvon\PluginAnnotatedHandler\Annotations\HookAnnotationReader;

abstract class AnnotatedHookHandler implements GenericHandlerInterface
{
    /**
     * @var HookAnnotationReader
     */
    private $annotationReader;

    /**
     * @return HookAnnotationReader
     */
    public function getAnnotationReader(): HookAnnotationReader
    {
        if ($this->annotationReader === null) {
            $this->annotationReader = new HookAnnotationReader(
                function_exists('apcu_exists')
                    ? new ApcuCache()
                    : null
            );
        }

        return $this->annotationReader;
    }

    /**
     * @param HookAnnotationReader $annotationReader
     */
    public function setAnnotationReader(HookAnnotationReader $annotationReader): void
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param bool $isAdmin
     * @return false|void
     */
    public function setup(bool $isAdmin)
    {
        $hooks = $this->getAnnotationReader()->read($this);

        foreach ($hooks as $hook) {
            if ((!$isAdmin && $hook->isOnlyAdmin()) || ($isAdmin && $hook->isOnlyFrontend())) {
                continue;
            }

            switch ($hook->getType()) {
                case 'filter':
                    \add_filter(
                        $hook->getTag(),
                        [$this, $hook->getMethod()],
                        $hook->getPriority(),
                        $hook->getArguments()
                    );
                    break;

                case 'action':
                    \add_action(
                        $hook->getTag(),
                        [$this, $hook->getMethod()],
                        $hook->getPriority(),
                        $hook->getArguments()
                    );
                    break;
            }
        }
    }
}
