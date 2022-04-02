<?php

namespace Pioc\IocPhp\ioc;

/**
 * {@code ObjectFactory} 对象工厂
 * 是 {@code IOC} 的 根接口
 *
 * @author photowey
 * @date 2022/04/02
 * @since 1.0.0
 */
interface ObjectFactory
{
    /**
     * 获取 对象
     * @param object | callable | string $clazz 类名 或者 闭包函数
     * @return mixed
     */
    public function getObject($clazz);
}
