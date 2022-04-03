<?php

namespace Pioc\IocPhp\ioc;

use Exception;

/**
 * {@code BeanFactory} 扩展 {@link ObjectFactory}
 * -- 支持 通过  {@code $bean} 和 {@code $instance} 类实例注册 {@code bean}
 * -- 通过 {@code $bean} 名称 获取 {@code bean} 实例.
 *
 * @author photowey
 * @date 2022/04/02
 * @since 1.0.0
 */
interface BeanFactory extends ObjectFactory
{
    /**
     * 初始-化上下文
     * 例如:
     * 1.文件读取
     * 2.环境准便
     * 3.配置服务
     *
     * @return void
     */
    public function init(): void;

    /**
     * 刷新-上下文
     * 1.注册-容器内置: {@code bean}
     * 2...
     *
     * @return void
     */
    public function refresh(): void;

    /**
     * 通过 {@code bean} 名称和实例 {@code instance} 进行 {@code StandardApplicationContext} 注册
     * @param string $bean {@code bean} 名称
     * @param object | callable | string $instance 类实例 {@code instance} 或者 闭包函数
     * @param bool $allowDuplicate 是否允许重复注册
     * @return void
     * @throws Exception
     */
    public function register(string $bean, $instance, bool $allowDuplicate = false);

    /**
     * 根据 {@code bean} 名称从 {@code StandardApplicationContext} 中 获取实例
     * @param string $bean {@code bean} 名称
     * @param bool $allowNull 是否允许重复注册
     * @return mixed|null
     * @throws Exception
     */
    public function getBean(string $bean, bool $allowNull = true);
}
