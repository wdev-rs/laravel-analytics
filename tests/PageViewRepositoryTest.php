<?php

namespace WdevRs\LaravelAnalytics\Tests;

use Illuminate\Support\Carbon;
use WdevRs\LaravelAnalytics\Models\PageView;
use WdevRs\LaravelAnalytics\Repositories\PageViewRepository;

class PageViewRepositoryTest extends TestCase
{
    public function testItCanGetPageViewDataByDate()
    {
        $pageViewRepository =  app(PageViewRepository::class);

        $this->assertNotNull($pageViewRepository);

        PageView::factory()->count(10)->create(
            [
                'created_at' => Carbon::today()->subWeeks(3)
            ]
        );

        PageView::factory()->count(10)->create(
            [
                'created_at' => Carbon::today()->subWeeks(5)
            ]
        );

        $analyticsData = $pageViewRepository->getByDate(Carbon::today()->subWeeks(4));

        $this->assertCount(10, $analyticsData);
    }

    public function testItCanGetPageViewDataByDateGrouppedByPath()
    {
        $pageViewRepository =  app(PageViewRepository::class);

        $this->assertNotNull($pageViewRepository);

        PageView::factory()->count(10)->create(
            [
                'path' => 'test/1',
                'created_at' => Carbon::today()->subWeeks(3)
            ]
        );

        PageView::factory()->count(5)->create(
            [
                'path' => 'test/2',
                'created_at' => Carbon::today()->subWeeks(3)
            ]
        );

        $analyticsData = $pageViewRepository->getByDateGroupedByPath(Carbon::today()->subWeeks(4));
        $this->assertCount(2, $analyticsData);
        $this->assertEquals(10, $analyticsData['test/1']);
        $this->assertEquals(5, $analyticsData['test/2']);
    }

    public function testItCanGetPageViewDataByDateGrouppedByDays()
    {
        $pageViewRepository =  app(PageViewRepository::class);

        $this->assertNotNull($pageViewRepository);

        PageView::factory()->count(10)->create(
            [
                'path' => 'test/1',
                'created_at' => Carbon::today()->subDays(1)
            ]
        );

        PageView::factory()->count(5)->create(
            [
                'path' => 'test/1',
                'created_at' => Carbon::today()->subDays(2)
            ]
        );

        $analyticsData = $pageViewRepository->getByDateGroupedByDays(Carbon::today()->subWeeks(4));

        $this->assertCount(2, $analyticsData);
        $this->assertEquals(10, $analyticsData[Carbon::today()->subDays(1)->toDateString()]);
        $this->assertEquals(5, $analyticsData[Carbon::today()->subDays(2)->toDateString()]);
    }

    public function testItCanGetVisitorsByDateGrouppedByDays()
    {
        /** @var PageViewRepository $pageViewRepository */
        $pageViewRepository =  app(PageViewRepository::class);

        $this->assertNotNull($pageViewRepository);

        PageView::factory()->count(10)->create(
            [
                'session_id' => 'session1',
                'path' => 'test/1',
                'created_at' => Carbon::today()->subDays(1)
            ]
        );

        PageView::factory()->count(5)->create(
            [
                'session_id' => 'session2',
                'path' => 'test/1',
                'created_at' => Carbon::today()->subDays(2)
            ]
        );

        PageView::factory()->count(5)->create(
            [
                'session_id' => 'session3',
                'path' => 'test/4',
                'created_at' => Carbon::today()->subDays(2)
            ]
        );

        $analyticsData = $pageViewRepository->getVisitorsByDateGroupedByDays(Carbon::today()->subWeeks(4));
        $this->assertCount(2, $analyticsData);
        $this->assertEquals(1, $analyticsData[Carbon::today()->subDays(1)->toDateString()]);
        $this->assertEquals(2, $analyticsData[Carbon::today()->subDays(2)->toDateString()]);
    }
}
