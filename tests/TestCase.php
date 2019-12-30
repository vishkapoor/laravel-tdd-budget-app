<?php

namespace Tests;

use Exception;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    protected function setUp() : void
    {
    	parent::setUp();
        $this->user = create('App\User');
    	$this->signIn($this->user)->disableExceptionHandling();
    }

    protected function disableExceptionHandling()
    {
    	$this->oldExceptionHandler = app()->make(ExceptionHandler::class);
    	app()->instance(ExceptionHandler::class, new PassThroughHandler);
    }

    protected function withExceptionHandling()
    {
    	app()->instance(ExceptionHandler::class, $this->oldExceptionHandler);
    	return $this;
    }

    protected function signIn($user)
    {
        $this->actingAs($user);
        return $this;
    }

    protected function signOut()
    {
        $this->post(route('logout'));
        return $this;
    }

    protected function make($class, $attributes = [], $times = null)
    {
        return make(
            $class, 
            array_merge(['user_id' => $this->user->id], $attributes),
            $times
        );
    }

    protected function create($class, $attributes = [], $times = null)
    {
        return create(
            $class, 
            array_merge(['user_id' => $this->user->id], $attributes),
            $times
        );
    }
}

Class PassThroughHandler extends Handler 
{
	public function __construct () {}

	public function report(Exception $e) {}

	public function render($request, Exception $e)
	{
		throw $e;
	}
}


