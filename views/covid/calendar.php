<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Cases x Deaths - ' . ($city) ? "{$city} ({$state})" : $state;

$json_data = json_encode($data);

$fmax_deaths = (fmod($max_deaths, 10) - 10) * - 1;
$fmax_cases = (fmod($max_cases, 100) - 100) * - 1;
$max_deaths += $fmax_deaths + 1;
$max_cases += $fmax_cases + 1;

$js = <<<JS

var _json_data = {$json_data};

var casesC = echarts.init(document.getElementById('cases'));

function getDataCases() {
    var data = [];
    
    for(var k in _json_data) {
        data.push([
            _json_data[k].date,
            _json_data[k].cases
        ]);
    }
    
    
    return data;
}

var deathD = echarts.init(document.getElementById('deaths'));

function getDataDeaths() {
    var data = [];
    
    for(var k in _json_data) {
        data.push([
            _json_data[k].date,
            _json_data[k].deaths
        ]);
    }
    
    
    return data;
}

optionc = {
    tooltip: {
        position: 'top',
        formatter: function (p) {
            var format = echarts.format.formatTime('dd/MM/yyyy', p.data[0]);
            return format + ': ' + p.data[1] + ' cases';
        }
    },
    visualMap: {
        show: true,
        min: 1,
        max: {$max_cases},
        calculable: true,
        type: 'piecewise',
        orient: 'horizontal',
        left: 'center',
        top: 0,
        // splitNumber: 10
    },
    calendar: {
        top: 50,
        left: 'center',
        range: '2020',
        dayLabel: {
            margin: 5
        }
    },
    series: {
        type: 'heatmap',
        coordinateSystem: 'calendar',
        data: getDataCases()
    }
};

optiond = {
    tooltip: {
        position: 'top',
        formatter: function (p) {
            var format = echarts.format.formatTime('dd/MM/yyyy', p.data[0]);
            return format + ': ' + p.data[1] + ' deaths';
        }
    },
    visualMap: {
        show: true,
        min: 1,
        max: {$max_deaths},
        calculable: true,
        type: 'piecewise',
        orient: 'horizontal',
        left: 'center',
        top: 0,
        // splitNumber: 10
    },
    calendar: {
        top: 50,
        left: 'center',
        range: '2020',
        dayLabel: {
            margin: 5
        }
    },
    series: {
        type: 'heatmap',
        coordinateSystem: 'calendar',
        data: getDataDeaths()
    }
};

casesC.setOption(optionc);

deathD.setOption(optiond);

$('#estado').on('change', function(){
   window.location = '/covid/calendar?state=' + $(this).val();
});

$('#city').on('change', function(){
    var state = $('#estado').val();
   window.location = '/covid/calendar?state=' + state + '&city=' + $(this).val();
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

<h5 class="text-center">Cases - <?= ($city) ? "{$city} ({$state})" : $state ?></h5>

<div id="cases" style="width: 100%;height:300px;"></div>

<h5 class="text-center">Deaths - <?= ($city) ? "{$city} ({$state})" : $state ?></h5>

<div id="deaths" style="width: 100%;height:300px;"></div>
