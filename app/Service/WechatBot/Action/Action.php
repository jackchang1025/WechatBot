<?php

namespace App\Service\OneBotWechatBot\Action;

use Illuminate\Support\Collection;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

trait Action
{
    /**
     * @var Collection|null 存储动作实例的集合，懒加载初始化。
     */
    protected ?Collection $actions = null;

    protected ?ContainerInterface $container = null;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function getContainer(): ?ContainerInterface
    {
        return $this->container;
    }

    /**
     * 添加一个新的动作到集合中。如果动作已存在，则不重复添加。
     *
     * @param string $actionName 动作的名称。
     * @param string|ActionInterface $action 动作实例或类名。
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function addAction(string $actionName, ActionInterface|string $action): void
    {
        if (!$this->hasAction($actionName)) {
            if (is_string($action) && class_exists($action)) {

                $action = $this->container ? $this->container->get($action) : new $action();

                if (!$action instanceof ActionInterface) {
                    throw new \InvalidArgumentException("Class {$action} must be an instance of ActionInterface.");
                }
            }

            $this->getActions()->put($actionName, $action);
        }
    }

    /**
     * 获取指定的动作实例。
     *
     * @param string $actionName 动作的名称。
     * @return ActionInterface|null 返回动作实例或者如果不存在则为 null。
     */
    public function getAction(string $actionName): ?ActionInterface
    {
        return $this->getActions()->get($actionName);
    }

    /**
     * 初始化动作集合。
     *
     * @return Collection
     */
    public function getActions(): Collection
    {
        return $this->actions ??= new Collection();
    }

    /**
     * 执行指定的动作。
     *
     * @param string $actionName 动作的名称。
     */
    public function action(string $actionName,...$arguments): void
    {
        if ($this->hasAction($actionName)) {
            $this->getAction($actionName)->execute($this,...$arguments);
        }
    }

    /**
     * 检查是否存在指定的动作。
     *
     * @param string $actionName 动作的名称。
     * @return bool 返回 true 如果动作存在，否则 false。
     */
    public function hasAction(string $actionName): bool
    {
        return $this->getActions()->has($actionName);
    }
}
