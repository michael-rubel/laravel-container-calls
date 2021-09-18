<?php

namespace MichaelRubel\EnhancedContainer\Tests;

use MichaelRubel\EnhancedContainer\Tests\Boilerplate\BoilerplateInterface;
use MichaelRubel\EnhancedContainer\Tests\Boilerplate\BoilerplateService;

class MethodBindingTest extends TestCase
{
    /** @test */
    public function testCanOverrideMethodAsString()
    {
        bind(BoilerplateService::class)->method()->test(fn () => 'overridden');

        $call = call(BoilerplateService::class)->test('test', 1);

        $this->assertEquals('overridden', $call);
    }

    /** @test */
    public function testCanOverrideMethodAsObject()
    {
        bind(new BoilerplateService())->method()->test(fn () => collect('illuminate'));

        $call = call(BoilerplateService::class)->test('test', 1);

        $this->assertEquals(
            collect('illuminate'),
            $call
        );
    }

    /** @test */
    public function testCanOverrideMethodUsingService()
    {
        bind(new BoilerplateService())->method()->yourMethod(
            fn ($service, $app) => $service->yourMethod(100) + 1
        );

        $call = call(BoilerplateService::class)->yourMethod(100);

        $this->assertEquals(
            101,
            $call
        );
    }

    /** @test */
    public function testBindMethodReturnsItselfIfOnlyMethodPassed()
    {
        bind(BoilerplateService::class)->method();

        $call = call(BoilerplateService::class)->yourMethod(100);

        $this->assertEquals(100, $call);
    }

    /** @test */
    public function testBindMethodReturnsItselfIfOnlyMethodPassedWithString()
    {
        bind(BoilerplateService::class)->method('yourMethod');

        $call = call(BoilerplateService::class)->yourMethod(100);

        $this->assertEquals(100, $call);
    }

    /** @test */
    public function testCanOverrideMethodUsingAnotherSyntax()
    {
        bind(BoilerplateService::class)->method('yourMethod', function ($service, $app, $params) {
            return $service->yourMethod($params['count']) + 1;
        });

        $call = call(BoilerplateService::class)->yourMethod(100);

        $this->assertEquals(
            101,
            $call
        );
    }

    /** @test */
    public function testCanOverrideMethodWithParameters()
    {
        bind(BoilerplateService::class)->method()->yourMethod(
            fn ($service, $app, $params) => $service->yourMethod($params['count']) + 1
        );

        $call = call(BoilerplateService::class)->yourMethod(100);

        $this->assertEquals(
            101,
            $call
        );
    }

    /** @test */
    public function testCanBindAnAbstractToConcrete()
    {
        bind(BoilerplateInterface::class)->to(BoilerplateService::class);

        app()->bound(BoilerplateInterface::class);

        $instance = resolve(BoilerplateInterface::class);

        $this->assertInstanceOf(BoilerplateService::class, $instance);
    }

    /** @test */
    public function testCanBindAnAbstractToConcreteAsSingleton()
    {
        bind(BoilerplateInterface::class)->to(BoilerplateService::class, true);

        app()->bound(BoilerplateInterface::class);

        $instance = resolve(BoilerplateInterface::class);

        $this->assertInstanceOf(BoilerplateService::class, $instance);
    }

    /** @test */
    public function testCanBindAnAbstractToConcreteAsSingletonWithAnotherSyntax()
    {
        bind(BoilerplateInterface::class)->singleton(BoilerplateService::class);

        app()->bound(BoilerplateInterface::class);

        $instance = resolve(BoilerplateInterface::class);

        $this->assertInstanceOf(BoilerplateService::class, $instance);
    }

    /** @test */
    public function testCanBindAnAbstractToConcreteAsScopedInstance()
    {
        bind(BoilerplateInterface::class)->scoped(BoilerplateService::class);

        app()->bound(BoilerplateInterface::class);

        $instance = resolve(BoilerplateInterface::class);

        $this->assertInstanceOf(BoilerplateService::class, $instance);
    }
}
