@extends ('layouts.admin')
@section('css')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
@endsection
@section ('contenido')
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="container" style="min-width: 340px; height: 400px; max-width: 510px; margin: 0 auto"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="container2" style="min-width: 340px; height: 400px; max-width: 510px; margin: 0 auto"></div>
      </div>
    </div>

  </div>  
</div>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="container3" style="min-width: 340px; height: 400px; max-width: 510px; margin: 0 auto"></div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="container4" style="min-width: 340px; height: 400px; max-width: 510px; margin: 0 auto"></div>
      </div>
    </div>

  </div>  
</div>
@endsection
@section('js')
<script type="text/javascript">
    var cont=[0,0,0,0,0,0,0,0,0,0,0,0];
    <?php foreach ($compra_i1 as $com): ?>
        cont[{{$com->mes_c}}-1]={{$com->total_c}};
    <?php endforeach ?>
    var cont2=[0,0,0,0,0,0,0,0,0,0,0,0];
    <?php foreach ($venta_i1 as $ven): ?>
        cont2[{{$ven->mes_v}}-1]={{$ven->total_v}};
    <?php endforeach ?>
    Highcharts.chart('container', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Comparacion Compras y Ventas'
    },
    xAxis: {
        categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
    },
    yAxis: {
        title: {
            text: 'Valor en Bolivianos'
        },
        labels: {
            formatter: function () {
                return this.value + ' Bs.';
            }
        }
    },
    tooltip: {
        pointFormat: 'Se han realizado {series.name} de productos por un total de <b>{point.y:,.0f} Bs.</b><br/>'
    },
    plotOptions: {
        area: {
            marker: {
                enabled: false,
                symbol: 'circle',
                radius: 2,
                states: {
                    hover: {
                        enabled: true
                    }
                }
            }
        }
    },
    series: [{
        name: 'Compras',
        data: cont
      },{
        name: 'Ventas',
        data: cont2
    }
    ]
});
</script>
<script type="text/javascript">
    var cont=[0,0,0,0,0,0,0,0,0,0,0,0];
    <?php foreach ($venta_i2 as $ven): ?>
        cont[{{$ven->mes_v}}-1]={{$ven->total_v}};
    <?php endforeach ?>
    Highcharts.chart('container2', {
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Ventas'
    },
    xAxis: {
        categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
    },
    yAxis: {
        title: {
            text: 'Valor en Bolivianos'
        },
        labels: {
            formatter: function () {
                return this.value + ' Bs.';
            }
        }
    },
    tooltip: {
        crosshairs: true,
        shared: true,
        pointFormat: 'Se han realizado {series.name} de productos por un total de <b>{point.y:,.0f} Bs.</b><br/>'
    },
    plotOptions: {
        spline: {
            marker: {
                radius: 4,
                lineColor: '#666666',
                lineWidth: 1
            }
        }
    },
    series: [{
        name: 'Ventas',
        data: cont

    }]
});
</script>
<script type="text/javascript">
  Highcharts.chart('container3', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Productos mas vendidos '
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Productos',
        colorByPoint: true,
        data: [
            <?php foreach ($vendidos_i3 as $ven): ?>
                {   name: '{{$ven->nombre}}',
                    y: {{$ven->contador}}
                },                
            <?php endforeach ?>
        ]
    }]
});
</script>
<script type="text/javascript">    
    var aux=[0,0,0,0,0,0,0,0,0,0,0,0];
    var dato=[0,0,0,0,0,0,0,0,0,0,0,0];
    Highcharts.chart('container4', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Venta de Bebidas'
    },
    xAxis: {
        categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Artúculos Vendidos'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} unidades</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
    
        <?php foreach ($artic_i4 as $art): ?>
            
            {   name: '{{$art->nombre}}',
                
                <?php foreach ($articulos_i4 as $ar): ?>
                        <?php if ($art->nombre==$ar->nombre): ?>
                            dato[{{$ar->mes}}-1]={{$ar->cant}}
                        <?php endif ?>
                <?php endforeach ?>

                data: dato
            },
        <?php endforeach ?>
    
    ]
});
</script>
@endsection
<!--series: [{
        name: 'Tokyo',
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

    }, {
        name: 'New York',
        data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

    }, {
        name: 'London',
        data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

    }, {
        name: 'Berlin',
        data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

    }]-->
    