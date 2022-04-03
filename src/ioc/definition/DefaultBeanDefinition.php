<?php

namespace Pioc\IocPhp\ioc\definition;

/**
 * {@code DefaultBeanDefinition}
 * {@link BeanDefinition} 默认实现
 *
 * @author photowey
 * @date 2022/04/03
 * @since 1.0.0
 */
class DefaultBeanDefinition implements BeanDefinition
{
    /**
     * {@code bean} 名称
     * @var string
     */
    protected $name;
    /**
     * {@code bean} 类名称
     * @var string
     */
    protected $clazz;
    /**
     * {@code bean}命名空间
     * @var string
     */
    protected $namespace;
    /**
     * {@code bean} 作用域
     * @var string
     */
    protected $scope;
    /**
     * {@code bean} 接口父类列表
     * @var array
     */
    protected $interfaces = array();
    /**
     * {@code bean} 抽象父类列表
     * @var array
     */
    protected $parents = array();
    /**
     * {@code bean} 实例对象
     * @var object 实例对象
     */
    protected $instance;

    /**
     * {@code bean} 名称
     * @return string
     */
    public function bean(): string
    {
        return $this->name;
    }

    /**
     * {@code bean} 类名称
     * @return string
     */
    public function clazz(): string
    {
        return $this->clazz;
    }

    /**
     * {@code bean}命名空间
     * @return string
     */
    public function namespace(): string
    {
        return $this->namespace;
    }

    /**
     * {@code bean} 作用域
     * 默认: singleton
     * @return string
     */
    public function scope(): string
    {
        return is_null($this->scope) ? 'singleton' : $this->scope;
    }

    /**
     * {@code bean} 接口父类列表
     * @return array
     */
    public function interfaces(): array
    {
        return is_null($this->interfaces) ? [] : $this->interfaces;
    }

    /**
     * {@code bean} 抽象父类列表
     * @return array
     */
    public function parents(): array
    {
        return is_null($this->parents) ? [] : $this->parents;
    }

    /**
     * {@code bean} 实例
     * @return object
     */
    public function instance(): object
    {
        return $this->instance;
    }
}