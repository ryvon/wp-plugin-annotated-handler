<?php

namespace Ryvon\PluginAnnotatedHandler\Annotations;

class HookAnnotation
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var string
     */
    private $methodName;

    /**
     * @var int
     */
    private $priority;

    /**
     * @var int
     */
    private $argumentCount;

    /**
     * @var bool
     */
    private $onlyAdmin;

    /**
     * @var bool
     */
    private $onlyFrontend;

    /**
     * @param string $type
     * @param string $tag
     * @param string $methodName
     * @param int $priority
     * @param int $argumentCount
     * @param bool $onlyAdmin
     * @param bool $onlyFrontend
     */
    public function __construct(
        string $type,
        string $tag,
        string $methodName,
        int $priority,
        int $argumentCount,
        bool $onlyAdmin,
        bool $onlyFrontend
    ) {
        $this->type = $type;
        $this->tag = $tag;
        $this->methodName = $methodName;
        $this->priority = $priority;
        $this->argumentCount = $argumentCount;
        $this->onlyAdmin = $onlyAdmin;
        $this->onlyFrontend = $onlyFrontend;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return int
     */
    public function getArgumentCount(): int
    {
        return $this->argumentCount;
    }

    /**
     * @return bool
     */
    public function isOnlyAdmin(): bool
    {
        return $this->onlyAdmin;
    }

    /**
     * @return bool
     */
    public function isOnlyFrontend(): bool
    {
        return $this->onlyFrontend;
    }
}
