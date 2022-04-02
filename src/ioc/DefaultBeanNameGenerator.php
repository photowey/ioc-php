<?php

namespace Pioc\IocPhp\ioc;

/**
 * {@code DefaultBeanNameGenerator}
 * {@code IOC} 容器 {@code bean} 名称-生成器
 *
 * @author photowey
 * @date 2022/04/02
 * @since 1.0.0
 */
class DefaultBeanNameGenerator implements BeanNameGenerator
{
    /**
     * 生成-{@code IOC} 容器 {@code bean} 注册时的名称
     * 默认: 首字母小写
     *
     * @param object | string $clazz 指定的 {@code bean} 的名称 或者 类名（e.g.: Company:class）
     * @return mixed
     */
    public function generate($clazz): string
    {
        return lcfirst($clazz);
    }

    /**
     * 生成-{@code IOC} 容器 {@code bean} 注册时的名称
     * @param string $clazz 指定的 {@code class} 的名称 或者 类名（e.g.: Company:class）
     * @return mixed
     */
    public function generatez(string $clazz): string
    {
        if (pisClosure($clazz)) {
            return "";
        }

        return populate_clazz_bean_name($clazz);
    }
}