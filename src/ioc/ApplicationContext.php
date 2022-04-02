<?php

namespace Pioc\IocPhp\ioc;

use Exception;

/**
 * {@code ApplicationContext} 扩展 {@link BeanFactory}
 * -- 支持 通过 {@code class} 类名进行注册 {@code bean} 实例和获取 {@code bean} 实例
 *
 * @author photowey
 * @date 2022/04/02
 * @since 1.0.0
 */
interface ApplicationContext extends BeanFactory
{
    /**
     * 通过 {@code class} 类进行 {@code ClasspathApplicationContext} 注册
     * @param object | callable | string $clazz 类名 或者 闭包函数
     * @param bool $allowDuplicate 是否允许重复注册
     * @return void
     * @throws Exception
     */
    public function registerz($clazz, bool $allowDuplicate = false);

    /**
     * 根据 {@code clazz} 类称从 {@code ClasspathApplicationContext} 中 获取实例
     * @param string $clazz 类名
     * @param bool $allowNull 是否允许重复注册
     * @return mixed|null
     * @throws Exception
     */
    public function getBeanz(string $clazz, bool $allowNull = true);
}
