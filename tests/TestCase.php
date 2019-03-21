<?php

namespace Tests;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /** @var \ReflectionMethod $method */
    protected $method;

    /** @var User $user */
    protected $user;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var array
     */
    protected $scopes = [];


    /**
     * TestCase constructor.
     *
     * return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param \ReflectionClass $class
     * @param string $method
     */
    protected function initClassMethod(\ReflectionClass $class, string $method): void
    {
        $this->method = $class->getMethod($method);
        $this->method->setAccessible(true);
    }

    /**
     * @param string $uri
     * @param array $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function getJsonAuth($uri, array $headers = [])
    {
        return parent::getJson($uri, array_merge($this->headers, $headers));
    }

    /**
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function postJsonAuth($uri, array $data = [], array $headers = [])
    {
        return parent::postJson($uri, $data, array_merge($this->headers, $headers));
    }

    /**
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function putJsonAuth($uri, array $data = [], array $headers = [])
    {
        return parent::putJson($uri, $data, array_merge($this->headers, $headers));
    }

    /**
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function deleteJsonAuth($uri, array $data = [], array $headers = [])
    {
        return parent::deleteJson($uri, $data, array_merge($this->headers, $headers));
    }

    /**
     * @param string $model
     * @param int $number
     * @param array $data
     * @return Collection
     */
    public function createModelsWithFactory(string $model, int $number = 1, array $data = [])
    {
        /** @var Collection $models */
        try {
            $models = factory($model, $number)->create($data);
        } catch (\Exception $e) {
            return $this->createModelsWithFactory($model, $number, $data);
        }

        return $models;
    }
}
