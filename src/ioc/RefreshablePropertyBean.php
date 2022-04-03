<?php

namespace Pioc\IocPhp\ioc;

/**
 * {@code RefreshablePropertyBean}
 * 标记: {@code bean} 实例是一个可刷其属性的 {@code bean}
 *
 * @author photowey
 * @date 2022/04/03
 * @since 1.0.0
 */
interface RefreshablePropertyBean extends RefreshableBean
{
    /**
     * 刷新属性
     * @param string $bean {@code bean} 名称
     * @param mixed $property 属性名
     * @param mixed $propertyValues 属性值列表
     * @return void
     */
    public function refreshProperties(string $bean, $property, $propertyValues): bool;

    /**
     * 刷新属性
     * @param string $clazz {@code bean} 类名称
     * @param mixed $property 属性名
     * @param mixed $propertyValues 属性值列表
     * @return void
     */
    public function refreshPropertiesz(string $clazz, $property, $propertyValues): bool;
}