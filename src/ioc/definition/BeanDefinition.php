<?php

namespace Pioc\IocPhp\ioc\definition;

/**
 * {@code BeanDefinition}
 * the definition of the ioc candidate bean.
 *
 * @author photowey
 * @date 2022/04/03
 * @since 1.0.0
 */
interface BeanDefinition
{
    /**
     * {@code bean} 名称
     * @return string
     */
    public function bean(): string;

    /**
     * {@code bean} 类名称
     * @return string
     */
    public function clazz(): string;

    /**
     * {@code bean}命名空间
     * @return string
     */
    public function namespace(): string;

    /**
     * {@code bean} 作用域
     * @return string
     */
    public function scope(): string;

    /**
     * {@code bean} 接口父类列表
     * @return array
     */
    public function interfaces(): array;

    /**
     * {@code bean} 抽象父类列表
     * @return array
     */
    public function parents(): array;

    /**
     * {@code bean} 实例
     * @return object
     */
    public function instance(): object;
}