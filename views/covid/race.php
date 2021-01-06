<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Daily run - TOP 12 Countries';

$json_data = json_encode($data);
$json_days = json_encode($data_day);
$json_countries = json_encode($countries);
$json_iso = json_encode($isocode);

$richData = '';

foreach($isocode as $ct)
{
    $img = 'https://www.countryflags.io/' . $ct . '/flat/64.png';

    $richData .= "'{$ct}': {
                    height: 40,
                    align: 'center',
                    backgroundColor: {
                        image: '{$img}'
                    }
                },";
}

$js = <<<JS

var _json_data = {$json_data};
var _json_day = {$json_days};
var _json_countries = {$json_countries};
var _json_iso = {$json_iso};

console.log(_json_iso)

var myChart = echarts.init(document.getElementById('cases'));
var option;
var data = [];

for (let i = 0; i < _json_countries.length; ++i) {
    var val = 0;
    
    if (_json_data !== undefined && _json_data[0] !== undefined && _json_data[0][_json_countries[i]] !== undefined) {
        val = parseInt(_json_data[0][_json_countries[i]].cases);
    }
    
    data.push(val);
}

option = {
    title: {
        text: _json_day[0],
        left: 'center',
    },
    xAxis: {
        max: 'dataMax',
    },
    yAxis: {
        type: 'category',
        data: _json_iso,
        inverse: true,
        animationDuration: 300,
        animationDurationUpdate: 300,
        max: 9, // only the largest 3 bars will be displayed,
        axisLabel: {
            formatter: function (value) {
                return '{' + value + '| }\\n{value|' + value + '}';
            },
            margin: 20,
            rich: {
                value: {
                    lineHeight: 30,
                    align: 'center'
                },
                {$richData}
            }
        }
    },
    series: [{
        realtimeSort: true,
        name: 'X',
        type: 'bar',
        data: data,
        label: {
            show: true,
            position: 'right',
            valueAnimation: true
        }
    }],
    animationDuration: 0,
    animationDurationUpdate: 800,
    animationEasing: 'linear',
    animationEasingUpdate: 'linear'
};

var idx = 1;

function run () {
    
    var data = option.series[0].data;
    
    for (let i = 0; i < _json_countries.length; ++i) {
        var val = 0;
        
        if (_json_data !== undefined && _json_data[idx] !== undefined && _json_data[idx][_json_countries[i]] !== undefined) {
            val = parseInt(_json_data[idx][_json_countries[i]].cases);
        }
        
        data[i] = val;
    }
    
    option.title.text = _json_day[idx];
    
    myChart.setOption(option);
    idx++;
}

setTimeout(function() {
    run();
}, 0);
setInterval(function () {
    run();
}, 800);

option && myChart.setOption(option);

JS;

$this->registerJs($js);

$css = <<<CSS
    .row-head
    {
        /*background-color: #cc625f;*/
        margin: 10px;
        padding: 20px;
        /*color: #FFF;*/
    }
CSS;

$this->registerCss($css);

?>

<hr>

<div id="cases" style="width: 100%;height:800px;"></div>