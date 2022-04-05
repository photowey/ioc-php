<?php

namespace ioc;

use Exception;
use PHPUnit\Framework\TestCase;
use Pioc\IocPhp\ioc\LifecycleApplicationContext;

class LifecycleApplicationContextTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function testDestroy()
    {
        $applicationContext = new LifecycleApplicationContext();
        $applicationContext->registerz(Person::class);
        $person = $applicationContext->getBeanz(Person::class);

        $this->assertNotNull($person);

        $destroyz = $applicationContext->destroyz(Person::class);
        $this->assertTrue($destroyz);
        $personNull = $applicationContext->getBeanz(Person::class, true);
        $this->assertNull($personNull);
    }

    /**
     * @throws Exception
     */
    public function testRefreshProperty()
    {
        $applicationContext = new LifecycleApplicationContext();
        $applicationContext->registerz(Person::class);
        $person = $applicationContext->getBeanz(Person::class);
        $this->assertNotNull($person);
        $this->assertEquals('Adam', $person->name);

        $refreshPropertiesz = $applicationContext->refreshPropertiesz(Person::class, 'name', 'Sharkchili');
        $this->assertTrue($refreshPropertiesz);

        $personRefreshed = $applicationContext->getBeanz(Person::class);
        $this->assertNotNull($personRefreshed);
        $this->assertEquals('Sharkchili', $personRefreshed->name);
    }

    /**
     * @throws Exception
     */
    public function testRefreshPropertyBeanNotInIoc()
    {
        $applicationContext = new LifecycleApplicationContext();
        $applicationContext->registerz(Person::class);
        $person = $applicationContext->getBeanz(Person::class);
        $this->assertNotNull($person);
        $this->assertEquals('Adam', $person->name);

        $refreshPropertiesz = $applicationContext->refreshPropertiesz(Man::class, 'name', 'Sharkchili');
        $this->assertFalse($refreshPropertiesz);
    }

    /**
     * @throws Exception
     */
    public function testRefreshPropertyPropertyNotInBean()
    {
        $applicationContext = new LifecycleApplicationContext();
        $applicationContext->registerz(Man::class);
        $refreshPropertiesz = $applicationContext->refreshPropertiesz(Man::class, 'province', 'Chongqing, Chain');
        $this->assertFalse($refreshPropertiesz);
    }

}

class Person
{
    public $name = 'Adam';
    public $age = 18;
}

class Man
{
    public $name = 'SuperMan';
    public $age = 18;
}
