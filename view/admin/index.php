<?php 

  include_once 'includes/header.php';
  include_once '../../vendor/autoload.php';

  use App\Admin\Employee\Employee;

  $employee = new Employee();

  $total_employee = $employee->count_employee();



  //include '../timezone.php'; 
  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }

  $total_attend = $employee->today_attend($today);
  $ontime_attend = $employee->today_ontime_attend($today);
  $late_attend   = $employee->today_late_attend($today);

  $ontime_percentage = ($ontime_attend/$total_attend)*100;
  $ontime_percentage = number_format($ontime_percentage, 2);
?>


  <!-- end header other part..-->



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner"><h3><?php echo $total_employee ?></h3>
              <?php
               /* $sql = "SELECT * FROM employees";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";*/
              ?>

              <p>Total Employees</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="view/admin/employee/index.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner"><h3><?php echo $ontime_percentage; ?>%</h3>
              <?php
                /*$sql = "SELECT * FROM attendance where date='$today'";
                $query = $conn->query($sql);
                $total = $query->num_rows;
                //echo $total;
                $sql = "SELECT * FROM attendance WHERE status = 1 and date='$today'";
                $query = $conn->query($sql);
                $early = $query->num_rows;
                
                $percentage = ($early/$total)*100;

                echo "<h3>".number_format($percentage, 2)."<sup style='font-size: 20px'>%</sup></h3>";*/
              ?>
          
              <p>On Time Percentage</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="view/admin/empattend/employee_attend.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner"><h3><?php echo $ontime_attend; ?></h3>
              <?php
                /*$sql = "SELECT * FROM attendance WHERE date = '$today' AND status = 1";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>"*/
              ?>
             
              <p>On Time Today</p>
            </div>
            <div class="icon">
              <i class="ion ion-clock"></i>
            </div>
            <a href="view/admin/empattend/employee_attend.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner"><h3><?php echo $late_attend; ?></h3>
              <?php
               /* $sql = "SELECT * FROM attendance WHERE date = '$today' AND status = 0";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>"*/
              ?>

              <p>Late Today</p>
            </div>
            <div class="icon">
              <i class="ion ion-alert-circled"></i>
            </div>
            <a href="view/admin/empattend/employee_attend.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Attendance Report</h3>
              <div class="box-tools pull-right">
                <form class="form-inline">
                  <div class="form-group">
                    <label>Select Year: </label>
                    <select class="form-control input-sm" id="select_year">
                      <?php
                        for($i=2015; $i<=2050; $i++){
                          $selected = ($i==$year)?'selected':'';
                          echo "
                            <option value='".$i."' ".$selected.">".$i."</option>
                          ";
                        }
                      ?>
                    </select>
                  </div>
                </form>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <br>
                <div id="legend" class="text-center"></div>
                <canvas id="barChart" style="height:350px"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      </section>
      <!-- right col -->
    </div>
    <?php include 'includes/footer.php'; ?>

  	<?php include 'chart.php'; ?>
    
</div>

<!-- ./wrapper -->

<!-- Chart Data -->
<?php
//   $and = 'AND YEAR(date) = '.$year;
//   $months = array();
//   $ontime = array();
//   $late = array();
//   for( $m = 1; $m <= 12; $m++ ) {
//     $sql = "SELECT * FROM attendance WHERE MONTH(date) = '$m' AND status = 1 $and";
//     $oquery = $conn->query($sql);

//     //insert one or more data in the last position of array....
//     array_push($ontime, $oquery->num_rows);

//     $sql = "SELECT * FROM attendance WHERE MONTH(date) = '$m' AND status = 0 $and";
//     $lquery = $conn->query($sql);
//     array_push($late, $lquery->num_rows);

//     //str_pad() function pads to a string to a new lengtyh
//     $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
//     //echo $num.' <br>';

//     // 'M' means short text of month 3 letter, mktime(hour, min, second, mon, day, year)
//     $month =  date('M', mktime(0, 0, 0, $m, 1));
//     //echo $month;

//     array_push($months, $month);
//   }

//   $months = json_encode($months);
//   $late = json_encode($late);
//   $ontime = json_encode($ontime);

// ?>
 <script>
// $(function(){
//   var barChartCanvas = $('#barChart').get(0).getContext('2d')
//   var barChart = new Chart(barChartCanvas)
//   var barChartData = {
//     labels  : <?php echo $months; ?>,
//     datasets: [
//       {
//         label               : 'Late',
//         fillColor           : 'rgba(210, 214, 222, 1)',
//         strokeColor         : 'rgba(210, 214, 222, 1)',
//         pointColor          : 'rgba(210, 214, 222, 1)',
//         pointStrokeColor    : '#c1c7d1',
//         pointHighlightFill  : '#fff',
//         pointHighlightStroke: 'rgba(220,220,220,1)',
//         data                : <?php echo $late; ?>
//       },
//       {
//         label               : 'Ontime',
//         fillColor           : 'rgba(60,141,188,0.9)',
//         strokeColor         : 'rgba(60,141,188,0.8)',
//         pointColor          : '#3b8bba',
//         pointStrokeColor    : 'rgba(60,141,188,1)',
//         pointHighlightFill  : '#fff',
//         pointHighlightStroke: 'rgba(60,141,188,1)',
//         data                : <?php echo $ontime; ?>
//       }
//     ]
//   }
//   barChartData.datasets[1].fillColor   = '#00a65a'
//   barChartData.datasets[1].strokeColor = '#00a65a'
//   barChartData.datasets[1].pointColor  = '#00a65a'
//   var barChartOptions                  = {

//     scaleGridLineColor      : 'rgba(0,0,0,.05)',
//     responsive              : true,
//     maintainAspectRatio     : true

    
//     //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
//     /*scaleBeginAtZero        : true,
//     //Boolean - Whether grid lines are shown across the chart
//     scaleShowGridLines      : true,
   
//     //Number - Width of the grid lines
//     scaleGridLineWidth      : 1,
//     //Boolean - Whether to show horizontal lines (except X axis)
//     scaleShowHorizontalLines: true,
//     //Boolean - Whether to show vertical lines (except Y axis)
//     scaleShowVerticalLines  : true,
//     //Boolean - If there is a stroke on each bar
//     barShowStroke           : true,
//     //Number - Pixel width of the bar stroke
//     barStrokeWidth          : 2,
//     //Number - Spacing between each of the X value sets
//     barValueSpacing         : 5,
//     //Number - Spacing between data sets within X values
//     barDatasetSpacing       : 1,*/
//     //String - A legend template
//     /*legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',*/
//     //Boolean - whether to make the chart responsive
//      //String - Colour of the grid lines
   
//   }

//   barChartOptions.datasetFill = false
//   var myChart = barChart.Bar(barChartData, barChartOptions)
//   document.getElementById('legend').innerHTML = myChart.generateLegend();
// });
// </script>
 <script>
// $(function(){
//   $('#select_year').change(function(){
//     window.location.href = 'view/admin/index.php?year='+$(this).val();
//   });
// });
// </script>

