<?php

namespace Pioc\IocPhp\ioc;

/**
 * {@code BeanNameGenerator}
 *
 * @author photowey
 * @date 2022/04/02
 * @since 1.0.0`
 */
interface BeanNameGenerator extends Generator
{
    /**
     * 生成-{@code IOC} 容器 {@code bean} 注册时的名称
     * @param object | string $clazz 指定的 {@code bean} 的名称 或者 类名（e.g.: Company:class）
     * @return mixed
     */
    public function generate($clazz): string;

    /**
     * 生成-{@code IOC} 容器 {@code bean} 注册时的名称
     * @param string $clazz 指定的 {@code class} 的名称 或者 类名（e.g.: Company:class）
     * @return mixed
     */
    public function generatez(string $clazz): string;

}