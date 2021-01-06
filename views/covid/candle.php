<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Weekly cases - ' . ($city) ? "{$city} ({$state})" : $state ;

$json_datav = json_encode($data_values);
$json_dataw = json_encode($data_week);

$js = <<<JS

var _json_datav = {$json_datav};
var _json_dataw = {$json_dataw};

var deathsC = echarts.init(document.getElementById('cases'));

function getDataCases() {
    var data = [];
    
    for(var k in _json_datav) {
        data.push([
            _json_datav[k].first_cases,
            _json_datav[k].last_cases,
            _json_datav[k].min_cases,
            _json_datav[k].max_cases,
            _json_datav[k].sdate,
            _json_datav[k].edate,
            _json_datav[k].avg_cases,
            _json_datav[k].sum_cases,
        ]);
    }

    return data;
}

function getDataVolumes() {
    var data = [];
    
    for(var k in _json_datav) {
        data.push(
            _json_datav[k].avg_cases,
        );
    }
    
    return data;
}

function getDataWeek() {
    var data = [];
    
    for(var k in _json_dataw) {
        data.push(
            _json_dataw[k]
        );
    }
    
    return data;
}

var colorList = ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
var data = getDataCases();
var volumes = getDataVolumes();
var weeks = getDataWeek();

option = {
    animation: true,
    color: colorList,
    legend: {
        top: 30,
        data: ['Cases per Week', 'Moving AVG']
    },
    tooltip: {
        transitionDuration: 0,
        confine: true,
        bordeRadius: 4,
        borderWidth: 1,
        borderColor: '#333',
        backgroundColor: 'rgba(255,255,255,0.9)',
        textStyle: {
            fontSize: 12,
            color: '#333'
        },
    },
    axisPointer: {
        link: [{
            xAxisIndex: [0, 1]
        }]
    },
    xAxis: [{
        name: 'Week',
        type: 'category',
        data: weeks,
        boundaryGap : false,
        axisLine: { lineStyle: { color: '#777' } },
        axisLabel: {
            formatter: '{value}º'
        },
        axisPointer: {
            show: true
        }
    }],
    yAxis: [{
        name: 'Cases',
        scale: true,
        axisLine: { lineStyle: { color: '#777' } },
        splitLine: { show: true },
        axisTick: { show: false },
        axisLabel: {
            inside: true,
        }
    }],
    grid: [{
        left: 50,
        right: 50,
        top: 80,
        height: 400
    }],
    series: [{
        type: 'candlestick',
        name: 'Cases per Week',
        data: data,
        tooltip: {
            trigger: 'item',
            formatter: function (params)
            {
                var _open = params.data[1];
                var _close = params.data[2];
                var _lowest = params.data[3];
                var _highest = params.data[4];
                var _dates = params.data[5];
                var _datee = params.data[6];
                var _avg = params.data[7];
                var _sum = params.data[8];

                return _dates + ' : ' + _datee + '<br>' + 'First day: ' + _open + ' cases<br>' + 'Last day: ' + _close +
                ' cases<br>' + 'Lowest: ' + _lowest + ' cases<br>' + 'Highest: ' + _highest + ' cases<br>' + 
                'Moving avg (14 days): ' + _avg + ' cases<br>' + 'Weekly total: ' + _sum + ' cases';
            }
        },
        itemStyle: {
            color: '#14b143',
            color0: '#ef232a',
            borderColor: '#14b143',
            borderColor0: '#ef232a'
        },
    },{
        name: 'Moving AVG',
        type: 'line',
        data: volumes,
        smooth: true,
        tooltip: {
            show: false,
        },
        showSymbol: true,
        symbolSize: 8,
        lineStyle: {
            width: 2,
            color: 'black',
        }
    }]
};

deathsC.setOption(option);

$('#estado').on('change', function(){
   window.location = '/covid/candle?state=' + $(this).val();
});

$('#city').on('change', function(){
    var state = $('#estado').val();
   window.location = '/covid/candle?state=' + state + '&city=' + $(this).val();
});

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

<script src="/js/echarts50.min.js"></script>

<div class="row row-head">
    <div class="ml-auto mr-auto">
        <div class="form-group">
            <label for="estado">State:</label>
            <select id="estado" class="form-control" style="width: 200px;" name="estado">
                <option  <?= ($state == 'AC') ? 'selected="select"' : '' ?>value="AC">Acre</option>
                <option  <?= ($state == 'AL') ? 'selected="select"' : '' ?>value="AL">Alagoas</option>
                <option  <?= ($state == 'AP') ? 'selected="select"' : '' ?>value="AP">Amapá</option>
                <option  <?= ($state == 'AM') ? 'selected="select"' : '' ?>value="AM">Amazonas</option>
                <option  <?= ($state == 'BA') ? 'selected="select"' : '' ?>value="BA">Bahia</option>
                <option  <?= ($state == 'CE') ? 'selected="select"' : '' ?>value="CE">Ceará</option>
                <option  <?= ($state == 'DF') ? 'selected="select"' : '' ?>value="DF">Distrito Federal</option>
                <option  <?= ($state == 'ES') ? 'selected="select"' : '' ?>value="ES">Espírito Santo</option>
                <option  <?= ($state == 'GO') ? 'selected="select"' : '' ?>value="GO">Goiás</option>
                <option  <?= ($state == 'MA') ? 'selected="select"' : '' ?>value="MA">Maranhão</option>
                <option  <?= ($state == 'MT') ? 'selected="select"' : '' ?>value="MT">Mato Grosso</option>
                <option  <?= ($state == 'MS') ? 'selected="select"' : '' ?>value="MS">Mato Grosso do Sul</option>
                <option  <?= ($state == 'MG') ? 'selected="select"' : '' ?>value="MG">Minas Gerais</option>
                <option  <?= ($state == 'PA') ? 'selected="select"' : '' ?>value="PA">Pará</option>
                <option  <?= ($state == 'PB') ? 'selected="select"' : '' ?>value="PB">Paraíba</option>
                <option  <?= ($state == 'PR') ? 'selected="select"' : '' ?>value="PR">Paraná</option>
                <option  <?= ($state == 'PE') ? 'selected="select"' : '' ?>value="PE">Pernambuco</option>
                <option  <?= ($state == 'PI') ? 'selected="select"' : '' ?>value="PI">Piauí</option>
                <option  <?= ($state == 'RJ') ? 'selected="select"' : '' ?>value="RJ">Rio de Janeiro</option>
                <option  <?= ($state == 'RN') ? 'selected="select"' : '' ?>value="RN">Rio Grande do Norte</option>
                <option  <?= ($state == 'RS') ? 'selected="select"' : '' ?>value="RS">Rio Grande do Sul</option>
                <option  <?= ($state == 'RO') ? 'selected="select"' : '' ?>value="RO">Rondônia</option>
                <option  <?= ($state == 'RR') ? 'selected="select"' : '' ?>value="RR">Roraima</option>
                <option  <?= ($state == 'SC') ? 'selected="select"' : '' ?>value="SC">Santa Catarina</option>
                <option  <?= ($state == 'SP') ? 'selected="select"' : '' ?>value="SP">São Paulo</option>
                <option  <?= ($state == 'SE') ? 'selected="select"' : '' ?>value="SE">Sergipe</option>
                <option  <?= ($state == 'TO') ? 'selected="select"' : '' ?>value="TO">Tocantins</option>
            </select>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <select id="city" class="form-control" style="width: 200px;" name="city">
                <option value="">Select all</option>
                <?php foreach($cities as $ct): ?>
                    <option  <?= ($city == $ct['city']) ? 'selected="select"' : '' ?>value="<?= $ct['city'] ?>"><?= $ct['city'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<hr>

<h5 class="text-center">Weekly cases and moving average (14 days) - <?= ($city) ? "{$city} ({$state})" : $state ?></h5>

<div id="cases" style="width: 100%;height:600px;"></div>