<?php

namespace Ryvon\PluginAnnotatedHandler\Annotations;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\Cache;
use Ryvon\PluginAnnotatedHandler\Annotations\Annotation\Action;
use Ryvon\PluginAnnotatedHandler\Annotations\Annotation\Filter;

class HookAnnotationReader
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param Cache|null $cache
     */
    public function __construct(?Cache $cache = null)
    {
        // Will be removed in 2.0 but currently needed
        /** @noinspection PhpDeprecationInspection */
        AnnotationRegistry::registerLoader('class_exists');

        if ($cache) {
            $this->reader = new CachedReader(
                new AnnotationReader(),
                $cache,
                defined('WP_DEBUG') && WP_DEBUG
            );
        } else {
            $this->reader = new AnnotationReader();
        }
    }

    /**
     * @param $object
     * @return HookAnnotation[]
     */
    public function read($object): array
    {
        try {
            $reflectionClass = new \ReflectionClass($object);
        } catch (\ReflectionException $e) {
            if (defined('WP_DEBUG') && WP_DEBUG) {
                /** @noinspection ForgottenDebugOutputInspection */
                error_log(sprintf('Failed to read annotations, %s', $e->getMessage()));
            }
            return [];
        }

        $annotations = [];

        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            if (!$reflectionMethod->isPublic()) {
                continue;
            }

            $methodAnnotations = $this->reader->getMethodAnnotations($reflectionMethod);

            foreach ($methodAnnotations as $methodAnnotation) {
                if ($methodAnnotation instanceof Action) {
                    $annotations[] = new HookAnnotation(
                        'action',
                        $methodAnnotation->tag,
                        $reflectionMethod->getName(),
                        $methodAnnotation->priority,
                        $reflectionMethod->getNumberOfParameters(),
                        $methodAnnotation->onlyAdmin,
                        $methodAnnotation->onlyFrontend
                    );
                } elseif ($methodAnnotation instanceof Filter) {
                    $annotations[] = new HookAnnotation(
                        'filter',
                        $methodAnnotation->tag,
                        $reflectionMethod->getName(),
                        $methodAnnotation->priority,
                        $reflectionMethod->getNumberOfParameters(),
                        $methodAnnotation->onlyAdmin,
                        $methodAnnotation->onlyFrontend
                    );
                }
            }
        }

        return $annotations;
    }
}
