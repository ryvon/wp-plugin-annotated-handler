<?php

namespace Ryvon\PluginAnnotatedHandler\Annotations;

require_once __DIR__ . '/../Handler/AnnotatedWithActionsHandler.php';
require_once __DIR__ . '/../Handler/AnnotatedWithFiltersHandler.php';

use PHPUnit\Framework\TestCase;
use Ryvon\PluginAnnotatedHandler\AnnotatedWithActionsHandler;
use Ryvon\PluginAnnotatedHandler\AnnotatedWithFiltersHandler;

class HookAnnotationReaderTest extends TestCase
{
    public function testReadActions()
    {
        $reader = new HookAnnotationReader(null);

        $result = $reader->read(new AnnotatedWithActionsHandler());

        $expected = [
            new HookAnnotation('action', 'init', 'onlyTag', 10, 0, false, false),
            new HookAnnotation('action', 'wp_head', 'withOptionsAdmin', 100, 0, true, false),
            new HookAnnotation('action', 'wp_head', 'withOptionsFrontend', 105, 0, false, true),
            new HookAnnotation('action', 'load_textdomain', 'withArguments', 10, 2, false, false),
        ];

        $this->assertCount(count($expected), $result);

        foreach($expected as $index => $expectedItem) {
            $this->assertHookAnnotationEquals($expectedItem, $result[$index]);
        }
    }

    public function testReadFilters()
    {
        $reader = new HookAnnotationReader(null);

        $result = $reader->read(new AnnotatedWithFiltersHandler());

        $expected = [
            new HookAnnotation('filter', 'body_class', 'onlyTag', 10, 1, false, false),
            new HookAnnotation('filter', 'the_content', 'withOptionsFrontend', 100, 1, false, true),
            new HookAnnotation('filter', 'the_content', 'withOptionsAdmin', 105, 1, true, false),
            new HookAnnotation('filter', 'wp_new_user_notification_email', 'withArguments', 10, 3, false, false),
        ];

        $this->assertCount(count($expected), $result);

        foreach($expected as $index => $expectedItem) {
            $this->assertHookAnnotationEquals($expectedItem, $result[$index]);
        }
    }

    protected function assertHookAnnotationEquals(HookAnnotation $expected, HookAnnotation $result)
    {
        $this->assertEquals($expected->getType(), $result->getType());
        $this->assertEquals($expected->getTag(), $result->getTag());
        $this->assertEquals($expected->getMethod(), $result->getMethod());
        $this->assertEquals($expected->getPriority(), $result->getPriority());
        $this->assertEquals($expected->getArguments(), $result->getArguments());
        $this->assertEquals($expected->isOnlyAdmin(), $result->isOnlyAdmin());
        $this->assertEquals($expected->isOnlyFrontend(), $result->isOnlyFrontend());
    }

}
