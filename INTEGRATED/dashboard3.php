<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../LOGIN/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>6 X 6</title>

    <link rel="stylesheet" href="style3.css">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/p5@1.1.9/lib/p5.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    <div class="header">
        <div id="name">6 X 6</div>
        <div id="form">
            <form id="email">
                Email: <input type="text" name="gmail" id="gmail1" placeholder="only_gmail">
                <input type="submit" value="submit">
            </form>
        </div>

    </div>

    <div id="maincontainer1">
        <div id="chart-temp" class="container"></div>
        <div id="map">
            <button id="update">LATEST LOCATION</button>
            <div id="googleMap"></div>
        </div>
    </div>

    <div id="maincontainer2">
        <div id="chart-pres" class="container"></div>
        <div id="draw"></div>
    </div>

    <div id="maincontainer3">
        <div id="chart-humi" class="container"></div>
        <div id="battery" class="chart-container"></div>
    </div>

    <div id="maincontainer4">
        <div id="gauge1" class="container"></div>
        <div id="gauge2" class="container"></div>
        <div id="gauge3" class="container"></div>
        <div id="gauge4" class="container"></div>
        <div id="gauge5" class="container"></div>
    </div>

    <div id="maincontainer5">
        <table cellspacing="5" cellpadding="5" id="TablePres">
            <tr>
                <th colspan="3">Pressure readings</th>
            </tr>
            <tr>
                <td>Min</td>
                <td>Max</td>
                <td>Average</td>
            </tr>
            <tr>
                <td> hPa</td>
                <td> hPa</td>
                <td> hPa</td>
            </tr>
        </table>

        <table cellspacing="5" cellpadding="5" id="TableHumi">
            <tr>
                <th colspan="3">Humidity readings</th>
            </tr>
            <tr>
                <td>Min</td>
                <td>Max</td>
                <td>Average</td>
            </tr>
            <tr>
                <td> %</td>
                <td> %</td>
                <td> %</td>
            </tr>
        </table>

        <table cellspacing="5" cellpadding="5" id="TableTemp">
                <tr>
                    <th colspan="3">Temperature readings</th>
                </tr>
                <tr>
                    <td>Min</td>
                    <td>Max</td>
                    <td>Average</td>
                </tr>
                <tr>
                    <td> &deg;C</td>
                    <td> &deg;C</td>
                    <td> &deg;C</td>
                </tr>
        </table>

        <table cellspacing="5" cellpadding="5" id="TableGas">
                <tr>
                    <th colspan="3">Gas readings</th>
                </tr>
                <tr>
                    <td>Min</td>
                    <td>Max</td>
                    <td>Average</td>
                </tr>
                <tr>
                    <td> kOhms</td>
                    <td> kOhms</td>
                    <td> kOhms</td>
                </tr>
        </table>

        <table cellspacing="5" cellpadding="5" id="TableAlti">
            <tr>
                <th colspan="3">Altitude readings</th>
            </tr>
            <tr>
                <td>Min</td>
                <td>Max</td>
                <td>Average</td>
            </tr>
            <tr>
                <td> m</td>
                <td> m</td>
                <td> m</td>
            </tr>
        </table>
    </div>

    <div id="footer">
        Made by Team 6 X 6
        <p>
            <button class='manage'><a href="../LOGIN/welcome.php" class="btn btn-warning">Account Management</a></button>
            <button><a href="../LOGIN/logout.php" class="btn btn-danger">Sign Out</a></button>
        </p>
    </div>
    
<!-- Email -->
    <script>
        document.getElementById('email').addEventListener('submit', sendGmail);

        function sendGmail(e){
            e.preventDefault();

            var gmail = document.getElementById('gmail1').value;

            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'email.php?email='+gmail, true);

            xhr.onload = function(){
                console.log(this.responseText);
            }
            xhr.send();
        }
    </script>

<!-- chart -->
    <script>
        Highcharts.theme = {
            colors: ['#2b908f', '#90ee7e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066',
                '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
            chart: {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
                    stops: [
                        [0, '#2a2a2b'],
                        [1, '#3e3e40']
                    ]
                },
                style: {
                    fontFamily: '\'Unica One\', sans-serif'
                },
                plotBorderColor: '#606063'
            },
            title: {
                style: {
                    color: '#E0E0E3',
                    textTransform: 'uppercase',
                    fontSize: '20px'
                }
            },
            subtitle: {
                style: {
                    color: '#E0E0E3',
                    textTransform: 'uppercase'
                }
            },
            xAxis: {
                gridLineColor: '#707073',
                labels: {
                    style: {
                        color: '#E0E0E3'
                    }
                },
                lineColor: '#707073',
                minorGridLineColor: '#505053',
                tickColor: '#707073',
                title: {
                    style: {
                        color: '#A0A0A3'
                    }
                }
            },
            yAxis: {
                gridLineColor: '#707073',
                labels: {
                    style: {
                        color: '#E0E0E3'
                    }
                },
                lineColor: '#707073',
                minorGridLineColor: '#505053',
                tickColor: '#707073',
                tickWidth: 1,
                title: {
                    style: {
                        color: '#A0A0A3'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.85)',
                style: {
                    color: '#F0F0F0'
                }
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        color: '#F0F0F3',
                        style: {
                            fontSize: '13px'
                        }
                    },
                    marker: {
                        lineColor: '#333'
                    }
                },
                boxplot: {
                    fillColor: '#505053'
                },
                candlestick: {
                    lineColor: 'white'
                },
                errorbar: {
                    color: 'white'
                }
            },
            legend: {
                backgroundColor: 'rgba(0, 0, 0, 0.5)',
                itemStyle: {
                    color: '#E0E0E3'
                },
                itemHoverStyle: {
                    color: '#FFF'
                },
                itemHiddenStyle: {
                    color: '#606063'
                },
                title: {
                    style: {
                        color: '#C0C0C0'
                    }
                }
            },
            credits: {
                style: {
                    color: '#666'
                }
            },
            labels: {
                style: {
                    color: '#707073'
                }
            },
            drilldown: {
                activeAxisLabelStyle: {
                    color: '#F0F0F3'
                },
                activeDataLabelStyle: {
                    color: '#F0F0F3'
                }
            },
            navigation: {
                buttonOptions: {
                    symbolStroke: '#DDDDDD',
                    theme: {
                        fill: '#505053'
                    }
                }
            },
            // scroll charts
            rangeSelector: {
                buttonTheme: {
                    fill: '#505053',
                    stroke: '#000000',
                    style: {
                        color: '#CCC'
                    },
                    states: {
                        hover: {
                            fill: '#707073',
                            stroke: '#000000',
                            style: {
                                color: 'white'
                            }
                        },
                        select: {
                            fill: '#000003',
                            stroke: '#000000',
                            style: {
                                color: 'white'
                            }
                        }
                    }
                },
                inputBoxBorderColor: '#505053',
                inputStyle: {
                    backgroundColor: '#333',
                    color: 'silver'
                },
                labelStyle: {
                    color: 'silver'
                }
            },
            navigator: {
                handles: {
                    backgroundColor: '#666',
                    borderColor: '#AAA'
                },
                outlineColor: '#CCC',
                maskFill: 'rgba(255,255,255,0.1)',
                series: {
                    color: '#7798BF',
                    lineColor: '#A6C7ED'
                },
                xAxis: {
                    gridLineColor: '#505053'
                }
            },
            scrollbar: {
                barBackgroundColor: '#808083',
                barBorderColor: '#808083',
                buttonArrowColor: '#CCC',
                buttonBackgroundColor: '#606063',
                buttonBorderColor: '#606063',
                rifleColor: '#FFF',
                trackBackgroundColor: '#404043',
                trackBorderColor: '#404043'
            }
        };
    Highcharts.setOptions(Highcharts.theme);
    </script>

    <script>
    
    function loadCharts(){
        let xhrC = new XMLHttpRequest();
        xhrC.open('GET', 'chartData.php', true);

        xhrC.onload = function(){
            if (this.status === 200){
                var charts = JSON.parse(this.responseText);
                console.log(charts)

                var chartT = new Highcharts.Chart({
                    chart:{ renderTo : 'chart-temp',},
                    title: { text: 'BME680 Temperature' },
                    series: [{
                    name: 'Temperature',
                    showInLegend: false,
                    data: charts[1],
                    color: '#059e8a'
                    }],
                    plotOptions: {
                    line: { animation: false,
                        dataLabels: { enabled: true }
                    },
                    },
                    xAxis: { 
                    type: 'datetime',
                    categories: charts[3]
                    },
                    yAxis: {
                    title: { text: 'Temperature(Celcius)' }
                    //title: { text: 'Temperature (Fahrenheit)' }
                    },
                    credits: { enabled: false },
                });

                var chartP = new Highcharts.Chart({
                        chart:{ renderTo : 'chart-pres' },
                        title: { text: 'BME680 Pressure' },
                        series: [{
                            name: 'Pressure',
                            showInLegend: false,
                            data: charts[0],
                            color: '#FF0000'
                        }],
                        plotOptions: {
                            line: { animation: false,
                            dataLabels: { enabled: true }
                            },
                        },
                        xAxis: { 
                            type: 'datetime',
                            categories: charts[3]
                        },
                        yAxis: {
                            title: { text: 'Pressure(KPa)' }
                            //title: { text: 'Temperature (Fahrenheit)' }
                        },
                        credits: { enabled: false },
                    });

                    var chartH = new Highcharts.Chart({
                        chart:{ renderTo : 'chart-humi' },
                        title: { text: 'BME680 Humidity' },
                        series: [{
                            name: 'Humidity',
                            showInLegend: false,
                            data: charts[2],
                            color: '#0000FF'
                        }],
                        plotOptions: {
                            line: { animation: false,
                            dataLabels: { enabled: true }
                            },
                        },
                        xAxis: { 
                            type: 'datetime',
                            categories: charts[3]
                        },
                        yAxis: {
                            title: { text: 'Humidity(%)' }
                            //title: { text: 'Temperature (Fahrenheit)' }
                        },
                        credits: { enabled: false },
                        });

                //console.log(charts[0]);
                //console.log(charts[1]);
            }
        }
        xhrC.send()
    }

    setInterval(loadCharts, 1000);

    </script>
<!-- 3D -->
    <script>
        let sketch = function(p){
            let cylinder;
            let font,fontsize = 20;

            p.preload = function(){
                cylinder = p.loadModel('assets/tinker.obj');
                font = p.loadFont('assets/Montserrat-Black.otf');
            }

            p.setup = function(){
                if (p.windowWidth < 480) {
                    p.createCanvas((p.windowWidth)*0.95, 400, p.WEBGL);
                    font,fontsize = 15;
                }
                else if (p.windowWidth < 1000){
                    p.createCanvas((p.windowWidth)*0.90, 400, p.WEBGL);
                } else {
                    p.createCanvas((p.windowWidth)*0.28, 400, p.WEBGL);
                }
                
                img = p.loadImage('assets/blue.jpg');

                p.textFont(font);
                p.textSize(fontsize);
                p.textAlign(p.CENTER, p.CENTER);
            }

            p.draw = function(){
                let xhrP = new XMLHttpRequest();
                xhrP.open('GET', 'animation.php', true)
                //orbitControl();
                p.translate(15, 50, 00);
                //translate(0, 120, 0);
                xhrP.onload = function(){
                if (this.status === 200){
                    var gyro = JSON.parse(this.responseText)
                    //console.log(gyro)

                    var angX = gyro[0];
                    //console.log(angX);
                    var angY = gyro[1];
                    //console.log(angY);
                    var angZ = gyro[2];
                    //console.log(angZ);
                    p.background(0);
                    p.push();
                    
                    p.rotateX(angX-5);
                    p.rotateY(angY);
                    p.rotateZ(angZ);

                    p.texture(img);
                    p.scale(2.5);
                    p.model(cylinder);
                    p.pop();

                    p.fill(255);
                    p.text(`accX: ${gyro[3]}`, -150, -200);
                    p.text(`accY: ${gyro[4]}`, -150, -100);
                    p.text(`accZ: ${gyro[5]}`, -150, 000);

                }
                }
                xhrP.send()
            }

        }

        new p5(sketch, 'draw')
    </script>
<!-- Google Map -->
    <script>
    loadMap();
    document.getElementById("update").addEventListener('click', loadMap)

    function loadMap(){
        let xhrM = new XMLHttpRequest();
        xhrM.open('GET', 'mapData.php', true);

        xhrM.onload = function(){
            if (this.status === 200){
                var gps = JSON.parse(this.responseText);

                myMap(gps[0], gps[1]);
            }
        }
        xhrM.send()
    }

    function myMap(x=0, y=0) {
        var pos = {lat: x, lng: y};
        // var mapProp= {
        // center:new google.maps.LatLng(pos),
        // zoom:5,
        // };
        //var marker = new google.maps.Marker({position: uluru, map: map});
        var map = new google.maps.Map(document.getElementById("googleMap"),{zoom: 17, center: pos});
        var marker = new google.maps.Marker({position: pos, animation:google.maps.Animation.BOUNCE, map: map});
    }
    ///setInterval(loadMap, 5000)
    
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdnHCKL5j9hnlNXD8nsC1O8i1wJYbqBsU&callback=myMap"></script>
    <!-- U -->
<!-- Battery -->
    <script>
        var gaugeOptions = {
            chart: {
                type: 'solidgauge',
                backgroundColor: {
                linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
                stops: [
                    [0, '#2a2a2b'],
                    [1, '#3e3e40']
                ]
            }
            },

            title: 'Battery Percentage',

            pane: {
                center: ['50%', '85%'],
                size: '100%',
                startAngle: -90,
                endAngle: 90,
                background: {
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                    innerRadius: '60%',
                    outerRadius: '100%',
                    shape: 'arc'
                }
            },

            exporting: {
                enabled: false
            },

            tooltip: {
                enabled: false
            },

            // the value axis
            yAxis: {
                stops: [
                    [0.1, '#DF5353'], // green
                    [0.5, '#DDDF0D'], // yellow
                    [0.9, '#55BF3B'] // red
                ],
                lineWidth: 0,
                tickWidth: 0,
                minorTickInterval: null,
                tickAmount: 2,
                title: {
                    y: -120
                },
                labels: {
                    y: 36
                }
            },

            plotOptions: {
                solidgauge: {
                    dataLabels: {
                        y: 15,
                        borderWidth: 0,
                        useHTML: true
                    }
                }
            }
        };

        var chartBattery = Highcharts.chart('battery', Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: 'Battery Percentage'
                }
            },

            credits: {
                enabled: false
            },

            series: [{
                name: 'Battery',
                data: [0],
                dataLabels: {
                    format:
                        '<div style="text-align:center">' +
                        '<span style="font-size:35px">{y}</span><br/>' +
                        '<span style="font-size:22px;opacity:0.4">%</span>' +
                        '</div>'
                },
                tooltip: {
                    valueSuffix: ' %'
                }
            }]

        }));

        setInterval(() => {
            xhrB = new XMLHttpRequest();
            xhrB.open('GET', 'battery.php', true);

            var point, newVal;

            xhrB.onload = function(){
                if (this.status === 200){
                    var bat = JSON.parse(this.responseText)
                    //console.log(info);

                    point = chartBattery.series[0].points[0];
                    point.update(bat[0])
                }
            }
            xhrB.send()            
        }, 1000);
    </script>
<!-- Gauge -->
    <script>
    var gaugeOptions = {
    chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false,
            backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
            stops: [
                [0, '#2a2a2b'],
                [1, '#3e3e40']
            ]
        }
        },

        title: {
            text: 'Meter'
        },

        pane: {
            startAngle: -150,
            endAngle: 150,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },

        // the value axis
        yAxis: {
            min: 0,
            max: 200,

            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: 'km/h'
            },
            plotBands: [{
                from: 0,
                to: 120,
                color: '#55BF3B' // green
            }, {
                from: 120,
                to: 160,
                color: '#DDDF0D' // yellow
            }, {
                from: 160,
                to: 200,
                color: '#DF5353' // red
            }]
        }
    }

    chartPres = Highcharts.chart('gauge1', Highcharts.merge(gaugeOptions, {
        title: {
            text: 'Pressure'
        },
        yAxis: {
            title: {
                text: 'hpa'
            }, 
            min: 1000,
            max: 1100,
            plotBands: [{
                from: 1000,
                to: 1060,
                color: '#55BF3B' // green
            }, {
                from: 1060,
                to: 1090,
                color: '#DDDF0D' // yellow
            }, {
                from: 1090,
                to: 1100,
                color: '#DF5353' // red
            }]
        },

        series: [{
            name: 'Pressure',
            data: [1000],
            tooltip: {
                valueSuffix: ' hpa'
            }
        }]

    }
    ));

    chartHumi = Highcharts.chart('gauge2', Highcharts.merge(gaugeOptions, {
        title: {
            text: 'Humidity'
        },
        yAxis: {
            title: {
                text: '%'
            }, 
            min: 0,
            max: 100,
            plotBands: [{
                from: 0,
                to: 60,
                color: '#55BF3B' // green
            }, {
                from: 60,
                to: 80,
                color: '#DDDF0D' // yellow
            }, {
                from: 80,
                to: 100,
                color: '#DF5353' // red
            }]
        },
        series: [{
            name: 'Humidity',
            data: [0],
            tooltip: {
                valueSuffix: ' %'
            }
        }]

    }
    ));

    chartTemp = Highcharts.chart('gauge3', Highcharts.merge(gaugeOptions, {
        title: {
            text: 'Temperature'
        },
        yAxis: {
            title: {
                text: "'C"
            }, 
            min: 0,
            max: 100,
            plotBands: [{
                from: 0,
                to: 40,
                color: '#55BF3B' // green
            }, {
                from: 40,
                to: 80,
                color: '#DDDF0D' // yellow
            }, {
                from: 80,
                to: 100,
                color: '#DF5353' // red
            }]
        },
        series: [{
            name: 'Temperature',
            data: [0],
            tooltip: {
                valueSuffix: " 'C"
            }
        }]

    }
    ));

    chartGas = Highcharts.chart('gauge4', Highcharts.merge(gaugeOptions, {
        title: {
            text: 'Gas'
        },
        yAxis: {
            title: {
                text: 'kOhms'
            }, 
            min: 0,
            max: 1000,
            plotBands: [{
                from: 0,
                to: 800,
                color: '#55BF3B' // green
            }, {
                from: 800,
                to: 900,
                color: '#DDDF0D' // yellow
            }, {
                from: 900,
                to: 1000,
                color: '#DF5353' // red
            }]
        },
        series: [{
            name: 'Gas',
            data: [10],
            tooltip: {
                valueSuffix: 'kOhms'
            }
        }]

    }
    ));

    chartAlti = Highcharts.chart('gauge5', Highcharts.merge(gaugeOptions, {
        title: {
            text: 'Altitude'
        },
        yAxis: {
            title: {
                text: 'm'
            }, 
            min: 0,
            max: 100,
            plotBands: [{
                from: 0,
                to: 60,
                color: '#55BF3B' // green
            }, {
                from: 60,
                to: 90,
                color: '#DDDF0D' // yellow
            }, {
                from: 90,
                to: 100,
                color: '#DF5353' // red
            }]
        },
        series: [{
            name: 'Altitude',
            data: [0],
            tooltip: {
                valueSuffix: ' m'
            }
        }]

    }
    ));
    
    setInterval(() => {
            xhrG = new XMLHttpRequest();
            xhrG.open('GET', 'station.php', true);

            var point, newVal;

            xhrG.onload = function(){
                if (this.status === 200){
                    var points = JSON.parse(this.responseText)
                    var point
                    //console.log(info);

                    if(chartPres){
                        point = chartPres.series[0].points[0];
                        point.update(parseFloat(points['last_reading_pres']))
                    }
                    if(chartHumi){
                        point = chartHumi.series[0].points[0];
                        point.update(parseFloat(points['last_reading_humi']))
                    }
                    if(chartTemp){
                        point = chartTemp.series[0].points[0];
                        point.update(parseFloat(points['last_reading_temp']))
                    }
                    if(chartGas){
                        point = chartGas.series[0].points[0];
                        point.update(parseFloat(points['last_reading_gas']))
                    }
                    if(chartAlti){
                        point = chartAlti.series[0].points[0];
                        point.update(parseFloat(points['last_reading_alti']))
                    }
                }
            }
            xhrG.send()            
        }, 1000);
    </script>

<!-- Readings -->
    <script>
        // document.getElementById('getForm').addEventListener('submit', getRecord);
        // document.getElementById('b').addEventListener('click', getRecord);

        function getRecord(){
            

            let xhrR = new XMLHttpRequest();
            xhrR.open('GET', 'station.php', true);

            xhrR.onload = function(){
                if (this.status === 200){
                    console.log(JSON.parse(this.responseText))
                    var info = JSON.parse(this.responseText)

                    document.getElementById('TableTemp').innerHTML = `<tr><th colspan="3">Temperature latest readings</th></tr><br><tr><td>Min</td><td>Max</td><td>Average</td></tr><tr><td>${info['min_temp'].min} &deg;C</td><td>${info['max_temp'].max} &deg;C</td><td>${parseFloat(info['avg_temp'].avg).toFixed(2)} &deg;C</td></tr>`

                    document.getElementById('TableHumi').innerHTML = `<tr><th colspan="3">Humidity latest readings</th></tr><br><tr><td>Min</td><td>Max</td><td>Average</td></tr><tr><td>${info['min_humi'].min} %</td><td>${info['max_humi'].max} %</td><td>${parseFloat(info['avg_humi'].avg).toFixed(2)} %</td></tr>`

                    document.getElementById('TablePres').innerHTML = `<tr><th colspan="3">Pressure latest readings</th></tr><br><tr><td>Min</td><td>Max</td><td>Average</td></tr><tr><td>${info['min_pres'].min} hPa</td><td>${info['max_pres'].max} hPa</td><td>${parseFloat(info['avg_pres'].avg).toFixed(2)} hPa</td></tr>`

                    document.getElementById('TableGas').innerHTML = `<tr><th colspan="3">Gas latest readings</th></tr><br><tr><td>Min</td><td>Max</td><td>Average</td></tr><tr><td>${info['min_gas'].min}kOhms</td><td>${info['max_gas'].max}kOhms</td><td>${parseFloat(info['avg_gas'].avg).toFixed(2)}kOhms</td></tr>`

                    document.getElementById('TableAlti').innerHTML = `<tr><th colspan="3">Altitude latest readings</th></tr><br><tr><td>Min</td><td>Max</td><td>Average</td></tr><tr><td>${info['min_alti'].min} m</td><td>${info['max_alti'].max} m</td><td>${parseFloat(info['avg_alti'].avg).toFixed(2)} m</td></tr>`
                }
            }

            xhrR.send();
        }
        setInterval(getRecord, 1000)
    </script>
</body>
</html>