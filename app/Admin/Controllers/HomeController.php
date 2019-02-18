<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Feedback;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $count = [
            'user' => User::query()->count(),
            'product' => Product::query()->count(),
            'article' => Article::query()->count(),
            'feedback' => Feedback::query()->count(),
        ];

        return $content
            ->header('仪表盘')
            ->description('概览')
            ->row(view('admin.dashboard.small-box', compact('count')))
            ->row(new Box('用户注册概览', $this->userChart()));
    }

    protected function userChart()
    {
        $userCount = User::groupBy('date')
            ->get([DB::raw('DATE(created_at) as date'),DB::raw('COUNT(*) as value')])
            ->pluck('value', 'date')
            ->toArray();

        $dates = $this->getLastMonthDates();
        foreach ($dates as $date) {
            $userData[$date] = array_key_exists($date, $userCount) ? $userCount[$date] : 0;
        }

        $userOption = [
            'xAxis' => $this->formatData($dates),
            'series' => $this->formatData($userData),
        ];

        $chartId = 'user-chart';

        Admin::js('vendor/laravel-admin/echarts/echarts.simple.min.js');
        $script = <<<EOT
    var userChart = echarts.init(document.getElementById('{$chartId}'));

    var option = {
        xAxis: {
            type: 'category',
            data: {$userOption['xAxis']}
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: {$userOption['series']},
            type: 'line'
        }]
    };

    userChart.setOption(option);
EOT;

        Admin::script($script);

        return view('admin.dashboard.user-chart', compact('chartId'));
    }

    protected function getLastMonthDates()
    {
        $dates = [];
        $periods = CarbonPeriod::between(Carbon::now()->subMonth(), Carbon::now());
        foreach ($periods as $period) {
            $dates[] = $period->format('Y-m-d');
        }

        return $dates;
    }

    protected function formatData($data)
    {
        return json_encode(array_values($data));
    }
}
