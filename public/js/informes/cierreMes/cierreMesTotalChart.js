var app = new Vue({
    el: '#vue-app',
    data: {
      data: data
    },

    methods: {

      drawChart: function() {

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(draw);

        function draw() {
          var data = google.visualization.arrayToDataTable(this.data);

  				var options = {
  			    title: '',
  			    hAxis: {title: '',  titleTextStyle: {color: '#333'}},
  			    vAxis: {minValue: 0}
  			  };

          var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

          chart.draw(data, options);
        }
      }
    },
    beforeMount(){

      this.drawChart();

    },
    updated() {
      $('.selectpicker').selectpicker('refresh');
    }
});
