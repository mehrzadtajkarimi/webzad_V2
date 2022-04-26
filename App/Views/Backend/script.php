<script>
  $(document).ready(function() {


    $(function() {
      'use strict'

      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }

      var mode = 'index'
      var intersect = true

      var $salesChart = $('#sales-chart')
      var salesChart = new Chart($salesChart, {
        type: 'bar',
        data: {
          labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
          datasets: [{
              backgroundColor: '#007bff',
              borderColor: '#007bff',
              data: <?= $count_see_logs_login_user ?>,
            },
            {
              backgroundColor: '#6c757d',
              borderColor: '#6c757d',
              data: <?= $count_see_logs_guest_user ?>,
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                // callback: function(value, index, values) {
                //   if (value >= 1000) {
                //     value /= 1000
                //     value += 'k'
                //   }
                //   return '$' + value
                // }
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })

      var $visitorsChart = $('#visitors-chart')
      var visitorsChart = new Chart($visitorsChart, {
        data: {
          labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
          datasets: [{
              type: 'line',
              data: <?= json_encode($grand) ?>,
              backgroundColor: 'transparent',
              borderColor: '#007bff',
              pointBorderColor: '#007bff',
              pointBackgroundColor: '#007bff',
              fill: false
              // pointHoverBackgroundColor: '#007bff',
              // pointHoverBorderColor    : '#007bff'
            },
            {
              type: 'line',
              data: <?= json_encode($discount) ?>,
              backgroundColor: 'tansparent',
              borderColor: '#ced4da',
              pointBorderColor: '#ced4da',
              pointBackgroundColor: '#ced4da',
              fill: false
              // pointHoverBackgroundColor: '#ced4da',
              // pointHoverBorderColor    : '#ced4da'
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                suggestedMax: <?= max($grand) ?>,
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    })




    $('#btn-count').children('button').click(function(e) {
      e.preventDefault();
      var that = $(this);
      var count = $(this).data('count');
      that.addClass('active').siblings().removeClass('active');

      $.ajax({
        type: "post",
        url: "<?= base_url() ?>admin/bestsellers/number_view_chart_pri",
        data: {
          'count': count
        },
        success: function(response) {
          location.reload();
        }
      });
    });


    $('#btn-date').children('button').click(function(e) {
      e.preventDefault();
      var that = $(this);
      var li_chart_pir = $('#li-chart-pir');
      var chart_pir_this = $('#chart_pir_this');
      var chart_pir_last = $('#chart_pir_last');
      var change_item_sale = $('#change-item-sale');
      var time = $(this).data('time');
      var chart_pir_color = ['danger', 'success', 'warning', 'primary', 'secondary', 'info', 'dark'];
      that.addClass('active').siblings().removeClass('active');

      // درصد مقایسه با سال قبل
      $.ajax({
        type: "post",
        url: "<?= base_url() ?>admin/bestsellers/cent",
        data: {
          'time': time,
        },
        success: function(response) {
          var parsed_data = JSON.parse(response);
          change_item_sale.empty();
          $(parsed_data.change_item_sale).each(function(key, value) {
            if (value) {
              if (value[0] > 0) {
                change_item_sale.append(`
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                    ` + value[1] + `
                      <span class="float-left text-success">
                        <i class="fa fa-arrow-up' text-sm"></i>
                        ` + value[0] + `%
                        </span>
                    </a>
                  </li>
              `);
              } else {
                change_item_sale.append(`
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                    ` + value[1] + `
                      <span class="float-left text-danger">
                        <i class="fa fa-arrow-down' text-sm"></i>
                        ` + value[0] + `%
                        </span>
                    </a>
                  </li>
              `);
              }
            }
          });
        }
      });


      // برای چارت پیشرفت در سال
      $.ajax({
        type: "post",
        url: "<?= base_url() ?>admin/bestsellers",
        data: {
          'time': time,
        },
        success: function(response) {
          var parsed_data = JSON.parse(response);
          var data_grand_total = [];
          var data_comparison = [];
          var session_manager = <?= json_encode(App\Services\Session\SessionManager::get('quantity_chart_pir')  ?? 'grand_total') ?>;

          li_chart_pir.empty();
          $(parsed_data.chart_pir).each(function(key, value) {



            data_grand_total.push(value[session_manager]); //grand total OR quantity_total
            data_comparison.push(value['comparison']);

            li_chart_pir.append(`
              <li>
              <i class="fa fa-circle-o  text-` + chart_pir_color[key] + `">` + value['product_name'] + ` </i>
              </li>
              `);

            chart_pir_this.empty().append(`
            ` + value['chart_pir_this_to'] + `
              <i class="fa fa-arrow-left pr-1 pl-2 text-warning wow fadeInRight"  aria-hidden="true"></i>
              ` + value['chart_pir_this_as'] + `
              `);
            chart_pir_last.empty().append(`
            ` + value['chart_pir_last_to'] + `
              <i class="fa fa-arrow-left pr-1 pl-2 text-warning wow fadeInRight"  aria-hidden="true"></i>
            ` + value['chart_pir_last_as'] + `
            `);

          });

          var ctx = document.getElementById("pieChart").getContext('2d');
          var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
              datasets: [{
                data: data_grand_total,
                backgroundColor: [
                  'rgba(220, 53, 69)',
                  'rgba(40, 167, 69)',
                  'rgba(255, 193, 7)',
                  'rgba(0, 123, 255)',
                  'rgba(108, 117, 125)',
                  'rgba(23, 162, 184)',
                  'rgba(52, 58, 64)',
                ],
                borderColor: [
                  'rgba(220, 53, 69)',
                  'rgba(40, 167, 69)',
                  'rgba(255, 193, 7)',
                  'rgba(0, 123, 255)',
                  'rgba(108, 117, 125)',
                  'rgba(23, 162, 184)',
                  'rgba(52, 58, 64)',
                ],
              }],
              labels: data_comparison
            },
          });
        }
      });
    });

    var ctx = document.getElementById("pieChart").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        datasets: [{
          data: <?= json_encode(array_column($chart_pir, App\Services\Session\SessionManager::get('quantity_chart_pir')  ?? 'grand_total')) ?? 1 ?>,
          backgroundColor: [
            'rgba(220, 53, 69)',
            'rgba(40, 167, 69)',
            'rgba(255, 193, 7)',
            'rgba(0, 123, 255)',
            'rgba(108, 117, 125)',
            'rgba(23, 162, 184)',
            'rgba(52, 58, 64)',
          ],
          borderColor: [
            'rgba(220, 53, 69)',
            'rgba(40, 167, 69)',
            'rgba(255, 193, 7)',
            'rgba(0, 123, 255)',
            'rgba(108, 117, 125)',
            'rgba(23, 162, 184)',
            'rgba(52, 58, 64)',
          ],
        }],
        labels: <?= json_encode(array_column($chart_pir, 'comparison')) ?? 1   ?>
      },
    });



    //-----------------------
    //- MONTHLY SALES CHART -
    //-----------------------

    // Get context with jQuery - using jQuery's .get() method.
    var salesChartCanvas = $('#salesChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var salesChart = new Chart(salesChartCanvas)

    var salesChartData = {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [{
          label: 'Electronics',
          fillColor: '#dee2e6',
          strokeColor: '#ced4da',
          pointColor: '#ced4da',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgb(220,220,220)',
          data: [65, 59, 80, 81, 56, 55, 40]
        },
        {
          label: 'Digital Goods',
          fillColor: 'rgba(0, 123, 255, 0.9)',
          strokeColor: 'rgba(0, 123, 255, 1)',
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(0, 123, 255, 1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(0, 123, 255, 1)',
          data: [28, 48, 40, 19, 86, 27, 90]
        }
      ]
    }

    var salesChartOptions = {
      //Boolean - If we should show the scalto
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%=datasets[i].label%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    }

    //Create the line chart
    salesChart.Line(salesChartData, salesChartOptions)

    //---------------------------
    //- END MONTHLY SALES CHART -


























  });

  $(document).ready(function() {



    $(".start_at-1").pDatepicker({
      "inline": false,
      // "format": "LLLL",
      "viewMode": "day",
      "initialValue": true,
      "minDate": null,
      "maxDate": null,
      "autoClose": true,
      "position": "auto",
      "altFormat": "X",
      "altField": "#start_at-1",
      "onlyTimePicker": false,
      "TimePicker": true,
      "onlySelectOnDate": true,
      "calendarType": "persian",
      "inputDelay": 800,
      "observer": true,
      "calendar": {
        "persian": {
          "locale": "fa",
          "showHint": true,
          "leapYearMode": "algorithmic"
        },
        "gregorian": {
          "locale": "en",
          "showHint": true
        }
      },
      "navigator": {
        "enabled": true,
        "scroll": {
          "enabled": true
        },
        "text": {
          "btnNextText": "<",
          "btnPrevText": ">"
        }
      },
      "toolbox": {
        "enabled": true,
        "calendarSwitch": {
          "enabled": true,
          "format": "HH:mm"
        },
        "todayButton": {
          "enabled": true,
          "text": {
            "fa": "امروز",
            "en": "Today"
          }
        },
        "submitButton": {
          "enabled": true,
          "text": {
            "fa": "تایید",
            "en": "Submit"
          }
        },
        "text": {
          "btnToday": "امروز"
        }
      },
      "timePicker": {
        "enabled": true,
        "step": "1",
        "hour": {
          "enabled": true,
          "step": true
        },
        "minute": {
          "enabled": true,
          "step": null
        },
        "second": {
          "enabled": false,
          "step": null
        },
        "meridian": {
          "enabled": null
        }
      },
      "dayPicker": {
        "enabled": true,
        "titleFormat": "YYYY MMMM"
      },
      "monthPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
      },
      "yearPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
      },
      "responsive": true
    });

    $(".finish_at-1").pDatepicker({
      "inline": false,
      // "format": "LLL",
      "viewMode": "day",
      "initialValue": true,
      "minDate": null,
      "maxDate": null,
      "autoClose": true,
      "position": "auto",
      "altFormat": "X",
      "altField": "#finish_at-1",
      "onlyTimePicker": false,
      "TimePicker": true,
      "onlySelectOnDate": true,
      "calendarType": "persian",
      "inputDelay": 800,
      "observer": true,
      "calendar": {
        "persian": {
          "locale": "fa",
          "showHint": true,
          "leapYearMode": "algorithmic"
        },
        "gregorian": {
          "locale": "en",
          "showHint": true
        }
      },
      "navigator": {
        "enabled": true,
        "scroll": {
          "enabled": true
        },
        "text": {
          "btnNextText": "<",
          "btnPrevText": ">"
        }
      },
      "toolbox": {
        "enabled": true,
        "calendarSwitch": {
          "enabled": true,
          "format": "HH:mm"
        },
        "todayButton": {
          "enabled": true,
          "text": {
            "fa": "امروز",
            "en": "Today"
          }
        },
        "submitButton": {
          "enabled": true,
          "text": {
            "fa": "تایید",
            "en": "Submit"
          }
        },
        "text": {
          "btnToday": "امروز"
        }
      },
      "timePicker": {
        "enabled": true,
        "step": "1",
        "hour": {
          "enabled": true,
          "step": true
        },
        "minute": {
          "enabled": true,
          "step": null
        },
        "second": {
          "enabled": false,
          "step": null
        },
        "meridian": {
          "enabled": null
        }
      },
      "dayPicker": {
        "enabled": true,
        "titleFormat": "YYYY MMMM"
      },
      "monthPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
      },
      "yearPicker": {
        "enabled": true,
        "titleFormat": "YYYY"
      },
      "responsive": true
    });

  });
</script>