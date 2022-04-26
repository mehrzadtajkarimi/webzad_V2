   <!-- /.content-wrapper -->

   <footer class="main-footer">
       <strong>CopyLeft &copy; 2021 <a href="http://github.com/mehrzadtajkarimi/">مهرزاد تاج کریمی</a>.</strong>
       <div class=" text-left d-inline">
           <small class="text-muted">
               <?= jdate(' l , j / F / Y', time()) ?>
           </small>
       </div>
   </footer>

   <!-- Control Sidebar -->
   <aside class="control-sidebar control-sidebar-dark">
       <!-- Control sidebar content goes here -->
   </aside>
   <!-- /.control-sidebar -->
   </div>
   <!-- ./wrapper -->


   <!-- <script src="<?= asset_url() ?>Backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
   <script src="<?= asset_url() ?>Backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
   <script src="<?= asset_url() ?>Backend/plugins/fastclick/fastclick.js"></script>
   <script src="<?= asset_url() ?>Backend/dist/js/adminlte.min.js"></script>
   <!-- <script src="<?= asset_url() ?>Backend/dist/js/demo.js"></script> -->



   <script src="<?= asset_url() ?>Backend/plugins/bootstrap/js/bootstrap.min.js"></script>
   <!--script src="<?= asset_url() ?>Backend/plugins/chartjs-old/Chart.min.js"></!--script-->
   <script src="<?= asset_url() ?>Backend/plugins/chart.js/Chart.min.js"></script>
   <script src="<?= asset_url() ?>Backend/plugins/WOW/dist/wow.min.js"></script>
   <!-- <script src="<?= asset_url() ?>Backend/dist/js/demo.js"></script> -->
   <!-- <script src="<?= asset_url() ?>Backend/dist/js/pages/dashboard3.js"></script> -->
   <script src="<?= asset_url() ?>Backend/plugins/Multiple-Image-Picker-jQuery/spartan-multi-image-picker-min.js"></script>
   <script src="<?= asset_url() ?>Backend/plugins/select2/select2.full.min.js"></script>

   <script src="<?= asset_url() ?>Backend/dist/js/pages/my.js"></script>
   <script src="<?= asset_url() ?>Backend/plugins/jeditable/jquery.jeditable.min.js"></script>




   <script type="text/javascript">
       $(document).ready(function() {
           $(".start_at").pDatepicker({
               "inline": false,
               // "format": "LLLL",
               "viewMode": "day",
               "initialValue": true,
               "minDate": null,
               "maxDate": null,
               "autoClose": true,
               "position": "auto",
               "altFormat": "X",
               "altField": "#start_at",
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
           $(".finish_at").pDatepicker({
               "inline": false,
               // "format": "LLL",
               "viewMode": "day",
               "initialValue": true,
               "minDate": null,
               "maxDate": null,
               "autoClose": true,
               "position": "auto",
               "altFormat": "X",
               "altField": "#finish_at",
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





           /* $(".js-range-slider").ionRangeSlider({
               skin: "round",
               grid: true,
               min: 0,
               max: 100,
               from: 21,
               max_postfix: "+",
               prefix: "Age: ",
               postfix: " years"
           }); */

       });
   </script>