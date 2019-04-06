<?php

namespace Tests;

use PHPUnit\Framework\Assert;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse as TestResponse;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp() : void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        TestResponse::macro('data', function ($key) {
            return $this->original->getData()[$key];
        });

        EloquentCollection::macro('assertEquals', function ($items) {
            Assert::assertCount($items->count(), $this);

            $this->zip($items)->each(function ($itemPair) {
                Assert::assertTrue($itemPair[0]->is($itemPair[1]));
            });
        });
    }
}
