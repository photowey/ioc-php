<?php

namespace Pioc\IocPhp\ioc;
include_once __DIR__ . DIRECTORY_SEPARATOR . '../common/strings.php';

use Closure;
use Exception;
use ReflectionClass;

/**
 * {@code ClasspathApplicationContext} 实现 {@link ApplicationContext}
 * 是 {@code IOC} 容器的具体实现
 *
 * @author photowey
 * @date 2022/04/02
 * @since 1.0.0
 */
class ClasspathApplicationContext implements ApplicationContext
{
    private $ioc = array();

    /**
     * 初始-化上下文
     * 例如:
     * 1.文件读取
     * 2.环境准便
     * 3.配置服务
     *
     * @return void
     * @throws Exception
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * 初始化-上下文
     * @throws Exception
     */
    public function init(): void
    {
        // 1....
        // n.刷新上下文
        $this->refresh();
    }

    /**
     * 刷新-上下文
     * 1.注册-容器内置: {@code bean}
     * 2...
     *
     * @throws Exception
     */
    public function refresh(): void
    {
        // 1.注册 {@code DefaultBeanNameGenerator}
        $this->register_bean_name_generator();
        // 2....
    }

    // ----------------------------------------------------------------

    /**
     * 通过 {@code class} 类进行 {@code ClasspathApplicationContext} 注册
     * @param object | callable | string $clazz 类名 或者 闭包函数
     * @param bool $allowDuplicate 是否允许重复注册
     * @return void
     * @throws Exception
     */
    public function registerz($clazz, bool $allowDuplicate = false)
    {
        $beanNameGenerator = $this->beanNameGenerator();
        $bean = $beanNameGenerator->generatez($clazz);
        if (isset($this->ioc[$bean]) && !$allowDuplicate) {
            throw new Exception(sprintf('class:%s does not support duplicate register', $clazz));
        }

        $instance = $this->getObject($clazz);

        if (pisClosure($clazz)) {
            $bean = $beanNameGenerator->generatez(get_class($instance));
        }

        $this->inner_register($bean, $instance, $allowDuplicate);
    }

    /**
     * 通过 {@code bean} 名称和实例 {@code instance} 进行 {@code ClasspathApplicationContext} 注册
     * @param string $bean {@code bean} 名称
     * @param object | callable | string $instance 类实例 {@code instance} 或者 闭包函数
     * @param bool $allowDuplicate 是否允许重复注册
     * @return void
     * @throws Exception
     */
    public function register(string $bean, $instance, bool $allowDuplicate = false)
    {
        $this->inner_register($bean, $instance, $allowDuplicate, true);
    }

    /**
     * {@code IOC} 内部注册通道
     * 通过 {@code bean} 名称和实例 {@code instance} 进行 {@code ClasspathApplicationContext} 注册
     * @param string $bean {@code bean} 名称
     * @param string | callable | object $instance 类实例 {@code instance} 或者 闭包函数
     * @param bool $allowDuplicate 是否允许重复注册
     * @return void
     * @throws Exception
     */
    private function inner_register(string $bean, $instance, bool $allowDuplicate = false, bool $handleSuffix = false)
    {
        $beanNameGenerator = $this->beanNameGenerator();
        $suffix = clazz_bean_name_suffix();
        if (pends_with($bean, $suffix) && $handleSuffix) {
            throw new Exception(sprintf('custom bean:%s can\'t be end with:%s', $bean, $suffix));
        }
        if (isset($this->ioc[$bean]) && !$allowDuplicate) {
            throw new Exception(sprintf('bean:%s does not support duplicate register', $bean));
        }
        $this->ioc[$bean] = pisClosure($instance) ? $instance() : $instance;
    }

    /**
     * {@code IOC} 容器 内部 {@code bean} 注册
     * @param string $bean {@code bean} 名称
     * @param $instance {@code bean} 实例 或者 闭包回调函数
     * @return void
     */
    private function inner_ioc_bean_register(string $bean, $instance)
    {
        if ($instance instanceof Closure) {
            $this->ioc[$bean] = $instance();

            return;
        }
        $this->ioc[$bean] = $instance;
    }

    /**
     * 注册 {@code DefaultBeanNameGenerator}
     * @return void
     */
    public function register_bean_name_generator(): void
    {
        $bean_name_generator_bean_name = populate_inner_clazz_bean_name(DefaultBeanNameGenerator::class);
        $this->inner_ioc_bean_register($bean_name_generator_bean_name, function () {
            return new DefaultBeanNameGenerator();
        });
    }

    /**
     * @throws Exception
     */
    private function inner_ioc_bean_registerz(string $bean, $clazz)
    {
        $beanz = $this->getBeanz(DefaultBeanNameGenerator::class);
        if (is_null($beanz())) {
            $this->register_bean_name_generator();
        }

        $this->ioc[$bean] = $this->getObject($clazz);
    }

    // ----------------------------------------------------------------

    /**
     * 根据 {@code bean} 名称从 {@code ClasspathApplicationContext} 中 获取实例
     * @param string $bean {@code bean} 名称
     * @param bool $allowNull 是否允许重复注册
     * @return mixed|null
     * @throws Exception
     */
    public function getBean(string $bean, bool $allowNull = true)
    {
        if (isset($this->ioc[$bean])) {
            return $this->ioc[$bean];
        }
        if (!$allowNull) {
            throw new Exception(sprintf('can\' retrieve the target bean:%s', $bean));
        }

        return NULL;
    }

    /**
     * 根据 {@code clazz} 类称从 {@code ClasspathApplicationContext} 中 获取实例
     * @param string $clazz 类名
     * @param bool $allowNull 是否允许重复注册
     * @return mixed|null
     * @throws Exception
     */
    public function getBeanz(string $clazz, bool $allowNull = true)
    {
        $beanNameGenerator = $this->beanNameGenerator();
        $bean = $beanNameGenerator->generatez($clazz);
        if (isset($this->ioc[$bean])) {
            return $this->ioc[$bean];
        }
        if (!$allowNull) {
            throw new Exception(sprintf('can\' retrieve the target bean:%s', $bean));
        }

        return NULL;
    }

    // ----------------------------------------------------------------

    /**
     * 获取 对象
     * @param object | callable | string $clazz 类名 或者 闭包函数
     * @return mixed
     * @throws Exception
     */
    public function getObject($clazz)
    {
        if ($clazz instanceof Closure) {
            return $clazz();
        }

        $beanNameGenerator = $this->beanNameGenerator();
        // 首字母小写的 bean 名称
        $bean_name = $beanNameGenerator->generate($clazz);
        // 根据 {@code class name} 构造 {@code bean name}
        $clazz_bean_name = $beanNameGenerator->generatez($clazz);
        $instance = $this->getBean($bean_name, true);
        if (is_null($instance)) {
            $instance = $this->getBean($clazz_bean_name, true);
        }

        if (!is_null($instance)) {
            return $instance;
        }

        $reflector = new ReflectionClass($clazz);

        if (!$reflector->isInstantiable()) {
            throw new Exception(sprintf("can't instantiate this class:%s.", $clazz));
        }

        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return new $clazz;
        }
        $constructor->setAccessible(true);
        $parameters = $constructor->getParameters();
        // 声明无参构造函数
        if (count($parameters) == 0) {
            return new $clazz;
        }
        $dependencies = $this->parseDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    // ----------------------------------------------------------------

    /**
     * 获取-构造函数-依赖
     * @param array $parameters 参数列表
     * @return array
     * @throws Exception
     */
    private function parseDependencies(array $parameters): array
    {
        $dependencies = [];
        $beanNameGenerator = $this->beanNameGenerator();
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();
            if (is_null($dependency)) {
                $dependencies[] = $this->resolveDefaultValue($parameter);
            } else {
                // 是否需要 ? 将 依赖的对象也直接注入到容器里面 ?
                $dependency_instance = $this->getObject($dependency->name);
                $dependencies[] = $dependency_instance;

                // 默认还是支持内部注册
                $bean_name = $beanNameGenerator->generatez($dependency->name);
                $this->inner_register($bean_name, $dependency_instance);
            }
        }
        return $dependencies;
    }

    /**
     * 构造函数-参数
     * @param $parameter
     * @return mixed
     * @throws Exception
     */
    private function resolveDefaultValue($parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new Exception(sprintf('the parameter:%s miss default value', $parameter->name));
    }

    // ----------------------------------------------------------------

    /**
     * @throws Exception
     */
    private function beanNameGenerator(): DefaultBeanNameGenerator
    {
        // 内置 {@bean} 直接从 {@code ioc} 获取
        $bean_name_generator_clazz_bean_name = populate_inner_clazz_bean_name(DefaultBeanNameGenerator::class);
        return $this->ioc[$bean_name_generator_clazz_bean_name];
    }

    // ----------------------------------------------------------------

    /**
     * 销毁 {@code ioc} 实例 -> 释放资源
     */
    public function __destruct()
    {
        unset($this->ioc);
    }

    /**
     * 不允许外部 {@code clone}
     * @return void
     */
    private function __clone()
    {
    }

}
