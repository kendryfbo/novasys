google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Meses', 'Año 2018', 'Año 2019'],
    ['1',2,3],
    ['2',4,8]
  ]);

  var options = {
    title: 'Ventas en USD$',
    hAxis: {title: 'Meses',  titleTextStyle: {color: '#333'}},
    vAxis: {minValue: 0}
  };

  var chart = new google.visualization.LineChart(document.getElementById('grafico1'));
  chart.draw(data, options);
}
