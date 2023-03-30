<?php

namespace WdevRs\LaravelAnalytics\Tests\Controllers;

use Mockery\Mock;
use Mockery\MockInterface;
use WdevRs\LaravelAnalytics\LaravelAnalytics;
use WdevRs\LaravelAnalytics\Repositories\PageViewRepository;
use WdevRs\LaravelAnalytics\Tests\TestCase;

class AnalyticsControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        LaravelAnalytics::routes();
    }

    public function testItCanGetPageViewsPerDay()
    {
        $this->mock(PageViewRepository::class, function (MockInterface $mock){
           $mock->shouldReceive('getByDateGroupedByDays')->andReturn(
               collect([
                   '2023-03-28' => 2,
                   '2023-03-29' => 5
                ])
           );
        });

        $response = $this->getJson('analytics/page-views-per-days')->assertOk();

        $this->assertEquals(2, $response->getData()->{'2023-03-28'});
        $this->assertEquals(5, $response->getData()->{'2023-03-29'});
    }

    public function testItCanGetPageViewsPerPaths()
    {
        $this->mock(PageViewRepository::class, function (MockInterface $mock){
            $mock->shouldReceive('getByDateGroupedByPath')->andReturn(
                collect([
                    'test/1' => 2,
                    'test/2' => 5
                ])
            );
        });

        $response = $this->getJson('analytics/page-views-per-path')->assertOk();

        $this->assertEquals(2, $response->getData()->{'test/1'});
        $this->assertEquals(5, $response->getData()->{'test/2'});
    }
}
