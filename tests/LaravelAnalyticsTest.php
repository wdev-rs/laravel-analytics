<?php

namespace WdevRs\LaravelAnalytics\Tests;

use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use WdevRs\LaravelAnalytics\Http\Middleware\Analytics;
use WdevRs\LaravelAnalytics\LaravelAnalyticsServiceProvider;
use WdevRs\LaravelAnalytics\Models\PageView;

class LaravelAnalyticsTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [LaravelAnalyticsServiceProvider::class];
    }


    public function testPageViewTracing()
    {
        $request = Request::create('/test/path', 'GET');

        (new Analytics())->handle($request, function ($req) {
            $this->assertEquals('test/path', $req->path());
            $this->assertEquals('GET', $req->method());
        });

        $this->assertCount(1, PageView::all());
        $this->assertDatabaseHas(app(PageView::class)->getTable(), [
            'path' => 'test/path',
        ]);
    }

    public function testPageViewTracingWithModel()
    {
        Route::get('test/path/{pageView}', function(PageView $pageView){
            return 'Test path';
        })->middleware([SubstituteBindings::class, Analytics::class]);

        $pageView = PageView::factory()->create([
            'path' => 'tp'
        ]);

        $this->get('test/path/'.$pageView->getKey());

        $this->assertCount(2, PageView::all());
        $this->assertDatabaseHas(app(PageView::class)->getTable(), [
            'path' => 'test/path/1',
            'page_model_type' => PageView::class,
            'page_model_id' => $pageView->getKey()
        ]);
    }

    public function testPageViewTracingWithNonModelRouteParam()
    {
        Route::get('test/path/{any}', function(int $any){
            return 'Test path';
        })->middleware([SubstituteBindings::class, Analytics::class]);

        $this->get('test/path/1');

        $this->assertCount(1, PageView::all());
        $this->assertDatabaseHas(app(PageView::class)->getTable(), [
            'path' => 'test/path/1',
            'page_model_type' => null,
            'page_model_id' => null
        ]);
    }
}
