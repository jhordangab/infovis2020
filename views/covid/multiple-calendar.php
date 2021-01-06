<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Cases x Deaths - ' ;

$json_cases = json_encode($data_cases);
$json_deaths = json_encode($data_deaths);
$json_states = json_encode($states);

$fmax_deaths = (fmod($max_deaths, 10) - 10) * - 1;
$fmax_cases = (fmod($max_cases, 100) - 100) * - 1;
$max_deaths += $fmax_deaths + 1;
$max_cases += $fmax_cases + 1;

$js = <<<JS

var _json_cases = {$json_cases};
var _json_deaths = {$json_deaths};

var casesC = echarts.init(document.getElementById('cases'));

var deathD = echarts.init(document.getElementById('deaths'));

var weeks = ['1', '2', '3', '4', '5', '6', '7', '8', '9',
       '10', '11', '12', '13', '14', '15', '16', '17', '18', '19',
       '20', '21', '22', '23', '24', '25', '26', '27', '28', '29',
       '30', '31', '32', '33', '34', '35', '36', '37', '38', '39',
       '40', '41', '42', '43', '44', '45', '46', '47', '48', '49',
       '50', '51', '52', '53'];

var states = {$json_states};
var _data_cases = [];
var _data_deaths = [];

for(var state in states) 
{
    for(i = 0; i < 53; i++)
    {
        var _cvalue = 0;

        if (_json_cases !== undefined && _json_cases[states[state]] !== undefined && _json_cases[states[state]][i + 1] !== undefined) {
            _cvalue = _json_cases[states[state]][i + 1];
        }
        
        _data_cases.push([
            i,
            parseInt(state),
            _cvalue
        ]);
        
        var _dvalue = 0;

        if (_json_deaths !== undefined && _json_deaths[states[state]] !== undefined && _json_deaths[states[state]][i + 1] !== undefined) {
            _dvalue = _json_deaths[states[state]][i + 1];
        }
        
        _data_deaths.push([
            i,
            parseInt(state),
            _dvalue
        ]);
    }
}

_data_cases = _data_cases.map(function (item) {
    return [item[0], item[1], item[2] || '-'];
});

_data_deaths = _data_deaths.map(function (item) {
    return [item[0], item[1], item[2] || '-'];
});

optionc = {
    tooltip: {
       position: 'top',
       formatter: function (p) {
           var st = states[p.data[1]];
           return st + ': ' + p.data[2] + ' cases (' + (p.data[0] + 1) + 'º week)';
       }
   },
    animation: false,
    xAxis: {
        name: 'Week',        
        type: 'category',
        data: weeks,
        axisLabel: {
            formatter: '{value}º'
        }
    },
    yAxis: {
        name: 'State',
        type: 'category',
        data: states,
        axisLabel: {
            interval: 0,
        }
    },
    visualMap: {
        show: true,
        min: 1,
        max: {$max_cases},
        calculable: true,
        orient: 'horizontal',
        left: 'center',
        top: 0,
    },
    series: [{
        name: 'Cases',
        type: 'heatmap',
        data: _data_cases
    }]
};

optiond = {
    tooltip: {
       position: 'top',
       formatter: function (p) {
           var st = states[p.data[1]];
           return st + ': ' + p.data[2] + ' deaths (' + (p.data[0] + 1) + 'º week)';
       }
   },
    animation: false,
    xAxis: {
        name: 'Week',        
        type: 'category',
        data: weeks,
        axisLabel: {
            formatter: '{value}º'
        }
    },
    yAxis: {
        name: 'State',        
        type: 'category',
        data: states,
        axisLabel: {
            interval: 0,
        }
    },
    visualMap: {
        show: true,
        min: 1,
        max: {$max_deaths},
        calculable: true,
        orient: 'horizontal',
        left: 'center',
        top: 0,
    },
    series: [{
        name: 'Deaths',
        type: 'heatmap',
        data: _data_deaths
    }]
};

casesC.setOption(optionc);

deathD.setOption(optiond);

$('#search-btn').on('click', function(){
    var states = $('#estado').val();
   window.location = '/covid/multiple-calendar?states=' + states;
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
            <select id="estado" multiple="multiple" class="form-control" style="width: 200px;" name="estado">
                <option  <?= (in_array('AC', $states)) ? 'selected="select"' : '' ?>value="AC">Acre</option>
                <option  <?= (in_array('AL', $states)) ? 'selected="select"' : '' ?>value="AL">Alagoas</option>
                <option  <?= (in_array('AP', $states)) ? 'selected="select"' : '' ?>value="AP">Amapá</option>
                <option  <?= (in_array('AM', $states)) ? 'selected="select"' : '' ?>value="AM">Amazonas</option>
                <option  <?= (in_array('BA', $states)) ? 'selected="select"' : '' ?>value="BA">Bahia</option>
                <option  <?= (in_array('CE', $states)) ? 'selected="select"' : '' ?>value="CE">Ceará</option>
                <option  <?= (in_array('DF', $states)) ? 'selected="select"' : '' ?>value="DF">Distrito Federal</option>
                <option  <?= (in_array('ES', $states)) ? 'selected="select"' : '' ?>value="ES">Espírito Santo</option>
                <option  <?= (in_array('GO', $states)) ? 'selected="select"' : '' ?>value="GO">Goiás</option>
                <option  <?= (in_array('MA', $states)) ? 'selected="select"' : '' ?>value="MA">Maranhão</option>
                <option  <?= (in_array('MT', $states)) ? 'selected="select"' : '' ?>value="MT">Mato Grosso</option>
                <option  <?= (in_array('MS', $states)) ? 'selected="select"' : '' ?>value="MS">Mato Grosso do Sul</option>
                <option  <?= (in_array('MG', $states)) ? 'selected="select"' : '' ?>value="MG">Minas Gerais</option>
                <option  <?= (in_array('PA', $states)) ? 'selected="select"' : '' ?>value="PA">Pará</option>
                <option  <?= (in_array('PB', $states)) ? 'selected="select"' : '' ?>value="PB">Paraíba</option>
                <option  <?= (in_array('PR', $states)) ? 'selected="select"' : '' ?>value="PR">Paraná</option>
                <option  <?= (in_array('PE', $states)) ? 'selected="select"' : '' ?>value="PE">Pernambuco</option>
                <option  <?= (in_array('PI', $states)) ? 'selected="select"' : '' ?>value="PI">Piauí</option>
                <option  <?= (in_array('RJ', $states)) ? 'selected="select"' : '' ?>value="RJ">Rio de Janeiro</option>
                <option  <?= (in_array('RN', $states)) ? 'selected="select"' : '' ?>value="RN">Rio Grande do Norte</option>
                <option  <?= (in_array('RS', $states)) ? 'selected="select"' : '' ?>value="RS">Rio Grande do Sul</option>
                <option  <?= (in_array('RO', $states)) ? 'selected="select"' : '' ?>value="RO">Rondônia</option>
                <option  <?= (in_array('RR', $states)) ? 'selected="select"' : '' ?>value="RR">Roraima</option>
                <option  <?= (in_array('SC', $states)) ? 'selected="select"' : '' ?>value="SC">Santa Catarina</option>
                <option  <?= (in_array('SP', $states)) ? 'selected="select"' : '' ?>value="SP">São Paulo</option>
                <option  <?= (in_array('SE', $states)) ? 'selected="select"' : '' ?>value="SE">Sergipe</option>
                <option  <?= (in_array('TO', $states)) ? 'selected="select"' : '' ?>value="TO">Tocantins</option>
            </select>
            <p>(Use shift or control to select multiple items)</p>
        </div>

        <button id="search-btn" class="btn btn-xs btn-primary pull-right">Search</button>

    </div>
</div>

<hr>

<h5 class="text-center">Cases</h5>

<div id="cases" style="width: 100%;height:300px;"></div>

<h5 class="text-center">Deaths</h5>

<div id="deaths" style="width: 100%;height:300px;"></div>
