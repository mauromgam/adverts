<?php

namespace Tests\Feature;

use App\Advert;
use App\Repositories\AdvertRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class AdvertRepositoryTest extends TestCase
{
    /** @var AdvertRepository $class */
    protected $class;

    /**
     * TestCase constructor.
     *
     * return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->class = $this->getMockBuilder(AdvertRepository::class)
            ->disableOriginalConstructor()
            ->setMethods()
            ->getMock();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_model()
    {
        $this->assertEquals(Advert::class, $this->class->model());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function test_getAllPaginated()
    {
        $this->initClassMethod(new \ReflectionClass(AdvertRepository::class), 'getAllPaginated');
        $model = new Advert();
        $request = new Request();
        $columns = ['*'];

        $obj = new AdvertRepository($model);
        $invoked = $this->method->invokeArgs($obj, [$request, $columns]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $invoked);
    }
}
