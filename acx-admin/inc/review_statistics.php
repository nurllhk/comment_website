<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$register_dates = $db->query("select COUNT(*) as total,date from reviews where status='1' group by DATE(date) order by date asc")->fetchAll(PDO::FETCH_ASSOC);
	$dates = '';
	foreach($register_dates  as $date)
	{
		$dates.='\''.date('d/m/Y',strtotime($date['date'])).'\',';
		$totals.=''.$date['total'].',';
	}
	$dates = trim($dates,',');
	$totals = trim($totals,',');

?>   
<style>
.c3-axis-x .tick {
   display: none;
}
</style>
<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo ADMIN_URL;?>" class="navbar-nav-link">Anasayfa</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">İnceleme Giriş İstatistikleri</a>
		</li>
	</ul>

</div>
</div>


<form method="post" enctype="multipart/form-data">

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">ONAYLI İnceleme Giriş İstatistikleri</h5>
</div>

<div class="card-body">

<div class="chart-container">
	<div class="chart has-fixed-height" id="line_zoom"></div>
</div>

</div>
</div>




<div>
</div>
</div>
<script>

document.addEventListener("DOMContentLoaded", function(){
	
    var line_zoom_element = document.getElementById('line_zoom');
	 if (line_zoom_element) {

            // Initialize chart
            var line_zoom = echarts.init(line_zoom_element);


            //
            // Chart config
            //

            // Options
            line_zoom.setOption({

                // Define colors
                color: ["#c23531","#5c6bc0"],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 750,

                // Setup grid
                grid: {
                    left: 0,
                    right: 40,
                    top: 35,
                    bottom: 60,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Ziyaretçi','Bot'],
                    itemHeight: 8,
                    itemGap: 20
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    data: [<?php echo $dates; ?>]
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        formatter: '{value} ',
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                        }
                    }
                }],

                // Zoom control
                dataZoom: [
                    {
                        type: 'inside',
                    },
                    {
                        show: true,
                        type: 'slider',
                        height: 40,
                        bottom: 0,
                        borderColor: '#ccc',
                        fillerColor: 'rgba(0,0,0,0.05)',
                        handleStyle: {
                            color: '#585f63'
                        }
                    }
                ],

                // Add series
                series: [
                    {
                        name: 'Kayıt',
                        type: 'line',
                        smooth: true,
                        symbolSize: 6,
                        itemStyle: {
                            normal: {
                                borderWidth: 2
                            }
                        },
                        data: [<?php echo $totals; ?>]
                    }
                ]
            });
        }
		
		var triggerChartResize = function() {
            line_zoom_element && line_zoom.resize();
        };

   
        $(document).on('click', '.sidebar-control', function() {
            setTimeout(function () {
                triggerChartResize();
            }, 0);
        });

       
        var resizeCharts;
        window.onresize = function () {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        };
		
		
});

</script>