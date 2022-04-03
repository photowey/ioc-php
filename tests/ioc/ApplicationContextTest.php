<?php

namespace ioc;

use Exception;
use PHPUnit\Framework\TestCase;
use Pioc\IocPhp\ioc\StandardApplicationContext;

/**
 * {@code ApplicationContextTest} 测试类
 *
 * @author photowey
 * @date 2022/04/02
 * @since 1.0.0
 */
class ApplicationContextTest extends TestCase
{
    /**
     * 测试 {@code IOC} 容器 {@code bean} 注册
     * @throws Exception
     */
    public function testIoc()
    {
        $applicationContext = new StandardApplicationContext();

        // 通过 bean name 和 bean instance 向 {@code IOC} 容器 手动注册
        $student = new Student();
        $applicationContext->register('student', $student);

        // 通过 类名 手动向 {@code IOC} 容器 注册
        $applicationContext->registerz(Grade::class);

        // 通过 自定义的 {@code bean} name 获取 {@code IOC} 已注册的实例
        // 可 通过 {@code $allowNull} 参数决定-是否允许返回 {@code NULL} 空
        $st = $applicationContext->getBean('student');

        assert(!is_null($st), 'the bean retrieve from ioc can\'t be null');
        assert('Adam' === $st->name);

        // 通过 类名 获取 {@code IOC} 已注册的实例
        // 可 通过 {@code $allowNull} 参数决定-是否允许返回 {@code NULL} 空
        $gd = $applicationContext->getBeanz(Grade::class);
        assert(!is_null($gd), sprintf('the bean:%s retrieve from ioc can\'t be null', Grade::class));

        $this->assertEquals('Grade1', $gd->name);
    }

    /**
     * 测试-IOC 容器 依赖注入
     * @throws Exception
     */
    public function testIocDI()
    {
        $applicationContext = new StandardApplicationContext();
        // 通过 类名 获取 {@code IOC} 已注册的实例
        // 通过构造函数的 类名 - 自动向 {@code IOC} 容器 获取对应的依赖-并注入到对应的属性中
        $applicationContext->registerz(Department::class);

        $department = $applicationContext->getBeanz(Department::class);
        $department->doSomething();

        $group = $applicationContext->getBeanz(Group::class);
        $group->doSomething();
        $this->assertEquals(1, 1);
    }
}

class Group
{
    public function doSomething()
    {
        echo __CLASS__ . ":" . 'sayHello' . "\n";
    }
}

class Department
{
    private $group;

    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    public function doSomething()
    {
        $this->group->doSomething();
        echo __CLASS__ . ":" . 'sayHello' . "\n";
    }
}

class Company
{
    private $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    public function doSomething()
    {
        $this->department->doSomething();
        echo __CLASS__ . ":" . 'sayHello' . "\n";
    }
}

/**
 * @Component(bean="student_bean_name")
 */
class Student
{
    public $name = 'Adam';
    public $age = 18;
}

/**
 * @Component
 */
class Grade
{
    public $name = 'Grade1';
    public $level = 2;
}
