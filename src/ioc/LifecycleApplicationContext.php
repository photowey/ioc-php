<?php

namespace Pioc\IocPhp\ioc;

use Exception;
use ReflectionClass;
use ReflectionException;

/**
 * {@code LifecycleApplicationContext}
 * 具备生命周期管理的-{@code IOC} 容器上下文
 *
 * @author photowey
 * @date 2022/04/03
 * @since 1.0.0
 */
class LifecycleApplicationContext extends StandardApplicationContext implements RefreshablePropertyBean, DisposableBean
{

    public function __construct()
    {
        parent::__construct();
    }

    // ---------------------------------------------------------------

    /**
     * 刷新属性
     * @param string $bean {@code bean} 名称
     * @param mixed $property 属性名
     * @param mixed $propertyValues 属性值列表
     * @return bool
     * @throws Exception
     */
    public function refreshProperties(string $bean, $property, $propertyValues): bool
    {
        $beanNameGenerator = parent::beanNameGenerator();
        $bean_name = $beanNameGenerator->generate($bean);

        return $this->inner_refresh_properties($bean_name, $property, $propertyValues);
    }

    /**
     * 刷新属性
     * @param string $clazz {@code bean} 类名称
     * @param mixed $property 属性名
     * @param mixed $propertyValues 属性值列表
     * @return bool
     * @throws Exception
     */
    public function refreshPropertiesz(string $clazz, $property, $propertyValues): bool
    {
        $beanNameGenerator = parent::beanNameGenerator();
        $bean_name = $beanNameGenerator->generatez($clazz);

        return $this->inner_refresh_properties($bean_name, $property, $propertyValues);
    }

    // ---------------------------------------------------------------

    /**
     * {@code bean} 的销毁
     * @param string $bean {@code bean} 名称
     * @return void
     * @throws Exception
     */
    public function destroy(string $bean): bool
    {
        $bean_name = $bean;
        // 判断-该 {@code bean} name 是否为手动注册的 {@code bean} 的名称
        // 如果 - 不是-则通过 {@code beanNameGenerator} 再尝试构造一次 {@code bean} name
        // 然后尝试 -> 从 {@code IOC} 容器中获取 {@code bean} {@code instance}
        if (!isset($handle_register_bean_name[$bean])) {
            $beanNameGenerator = parent::beanNameGenerator();
            $bean_name = $beanNameGenerator->generate($bean);
        }

        return $this->inner_destroy($bean_name);
    }

    /**
     * {@code bean} 的销毁
     * @param string $clazz {@code bean} 类名称
     * @return void
     * @throws Exception
     */
    public function destroyz(string $clazz): bool
    {
        $beanNameGenerator = parent::beanNameGenerator();
        $bean_name = $beanNameGenerator->generatez($clazz);

        return $this->inner_destroy($bean_name);
    }

    // ---------------------------------------------------------------

    /**
     * 内部-函数-刷新属性
     * @param string $bean {@code bean} 名称
     * @param mixed $property 属性名
     * @param mixed $propertyValues 属性值列表
     * @return bool
     * @throws ReflectionException
     * @throws Exception
     */
    private function inner_refresh_properties(string $bean, $property, $propertyValues): bool
    {
        $instance = $this->getBean($bean);

        if (is_null($instance)) {
            return false;
        }

        $clazz = get_class($instance);
        $reflector = new ReflectionClass($clazz);
        $prop = $reflector->getProperty($property);
        if (is_null($prop)) {
            return false;
        }
        // 操作可见性 - 强制设值
        $prop->setAccessible(true);
        $prop->setValue($instance, $propertyValues);

        return true;
    }

    /**
     * 销毁 {@code bean}
     * @param string $bean {@code bean} 名称
     * @return bool
     * @throws Exception
     */
    public function inner_destroy(string $bean): bool
    {
        $instance = $this->getBean($bean);
        if (is_null($instance)) {
            return false;
        }

        unset($this->ioc[$bean]);

        return true;
    }

    // ---------------------------------------------------------------

    /**
     * 不允许外部 {@code clone}
     * @return void
     */
    private function __clone()
    {
    }
}