<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Feedback;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
            ->row(new Box('用户注册统计', $this->userChart()))
            ->row(new Box('留言统计', $this->feedbackChart()));
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
            name: '用户',
            data: {$userOption['series']},
            type: 'line',
            itemStyle:{ 
                normal:{ 
                    color: "#00a65a" 
                } //坐标圆点的颜色 
            }, 
            lineStyle:{ 
                normal:{ 
                    width:3, 
                    color: "#00a65a" 
                }//线条的颜色及宽度 
            }, 
            label: {//线条上的数字提示信息 
                normal: { 
                    show: true, 
                    position: 'top' 
                } 
            },
            smooth: true,
        }]
    };

    userChart.setOption(option);
EOT;

        Admin::script($script);

        return view('admin.dashboard.chart', compact('chartId'));
    }

    protected function feedbackChart()
    {
        $feedbackCount = Feedback::groupBy('date')
            ->get([DB::raw('DATE(created_at) as date'),DB::raw('COUNT(*) as value')])
            ->pluck('value', 'date')
            ->toArray();
        $feedbackData = [];
        $dates = $this->getLastMonthDates();
        foreach ($dates as $date) {
            $feedbackData[$date] = array_key_exists($date, $feedbackCount) ? $feedbackCount[$date] : 0;
        }

        $feedbackOption = [
            'xAxis' => $this->formatData($dates),
            'series' => $this->formatData($feedbackData),
        ];

        $chartId = 'feedback-chart';

        $script = <<<EOT
    var feedbackChart = echarts.init(document.getElementById('{$chartId}'));

    var option = {
        xAxis: {
            type: 'category',
            data: {$feedbackOption['xAxis']}
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            name: '用户',
            data: {$feedbackOption['series']},
            type: 'line',
            itemStyle:{ 
                normal:{ 
                    color: "#dd4b39" 
                } //坐标圆点的颜色 
            }, 
            lineStyle:{ 
                normal:{ 
                    width:3, 
                    color: "#dd4b39" 
                }//线条的颜色及宽度 
            }, 
            label: {//线条上的数字提示信息 
                normal: { 
                    show: true, 
                    position: 'top' 
                } 
            },
            smooth: true,
        }]
    };

    feedbackChart.setOption(option);
EOT;

        Admin::script($script);

        return view('admin.dashboard.chart', compact('chartId'));
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
