<?php
$judul = "Quick Count";
include 'template/header.php';

$getCandidate = mysqli_query($koneksi, "SELECT * FROM candidates");
$candidateRows = mysqli_num_rows($getCandidate);

$getVoter = mysqli_query($koneksi, "SELECT count(id_voter) AS count_voter FROM voter");
$dataVoter = mysqli_fetch_array($getVoter);

$getValid = mysqli_query($koneksi, "SELECT count(voter_status) AS count_valid FROM voter WHERE voter_status='1'");
$sudah = mysqli_fetch_array($getValid);

$getNotVoted = mysqli_query($koneksi, "SELECT count(voter_status) AS count_not FROM voter WHERE voter_status='0'");
$belum = mysqli_fetch_array($getNotVoted);

$getVoterCount = mysqli_query($koneksi, "SELECT * FROM voter");
$voter_rows = mysqli_num_rows($getVoterCount);
?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $judul; ?></h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
      <li class="breadcrumb-item" aria-current="page"><?php echo $judul; ?></li>
    </ol>
  </div>

  <div class="row">
    <div class="col-xl-12 col-lg-7 mb-4">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"><?php echo $judul; ?></h6>
          <a href="" id="download" download="Grafik_Voting_Bar.png" class="m-0 float-right btn btn-sm btn-primary "> <i class="fas fa-save"></i> Save Bar Chart</a>
        </div>
        <div class="card-body">
          <div class="table-responsive ">
            <table class="table align-items-center table-flush table-bordered">
              <thead class="thead-light">
                <tr>
                  <th>Candidate Name</th>
                  <th width="20%">Number of Votes</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($candidateRows != "") {
                  while ($candidateArr = mysqli_fetch_array($getCandidate)) {
                    $candidate_id = $candidateArr['candidate_id'];

                    $getsuara = mysqli_query($koneksi, "SELECT count(vote_candidate_id) AS jumlah_suara FROM voter_votes WHERE vote_candidate_id='$candidate_id'");
                    $suara = mysqli_fetch_array($getsuara);
                ?>

                    <tr>
                      <td><?php echo htmlspecialchars($candidateArr['candidate_name']); ?></td>
                      <td>
                        <?php echo htmlspecialchars($suara['jumlah_suara']); ?>
                      </td>
                    </tr>
                <?php }
                } ?>
                <tr>
                  <td></td>
                  <td></td>
                </tr>
                <?php if ($voter_rows != "") { ?>
                  <tr>
                    <td><b> Total Number of Voters</b></td>
                    <td>
                      <?php echo $dataVoter['count_voter']; ?>
                    </td>
                  </tr>
                  <tr>
                    <td><b> Number of Valid Votes</b></td>
                    <td>
                      <?php
                      $persentasi = round($sudah['count_valid'] / $dataVoter['count_voter'] * 100, 2);
                      echo $persentasi;
                      ?>% <?php echo "(" . $sudah['count_valid'] . " Suara)" ?>
                    </td>
                  </tr>
                  <tr>
                    <td><b> Number of Unused Votes</b></td>
                    <td>
                      <?php
                      $persentasi = round($belum['count_not'] / $dataVoter['count_voter'] * 100, 2);
                      echo $persentasi;
                      ?>% <?php echo "(" . $belum['count_not'] . " Suara)" ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <br>
          <div class="row">

            <div class="col-md-6">
              <div class="chart-area">
                <canvas id="myBarChart" class="chart-canvas"></canvas>
              </div>
            </div>
            <div class="col-md-6">
              <br>
              <div class="chart-pie pt-4" id="chartnya">
                <canvas id="myPieChart"></canvas>
              </div>
            </div>
          </div>


        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </div>
</div>
<!---Container Fluid-->
<?php
include 'template/footer.php';
?>
<!-- Page level plugins -->
<script src="../assets_back/vendor/chart.js/Chart.min.js"></script>
<!-- Page level custom scripts -->
<!-- <script src="../assets_back/js/demo/chart-bar-demo.js"></script> -->
<?php

$getCandidate = mysqli_query($koneksi, "SELECT * FROM candidates");
while ($candidate = mysqli_fetch_array($getCandidate)) {
  $candidateData[] = $candidate['candidate_name'];

  $query = mysqli_query($koneksi, "SELECT count(vote_candidate_id) AS jumlah_suara FROM voter_votes WHERE vote_candidate_id='" . $candidate['candidate_id'] . "'");
  $row = $query->fetch_array();
  $suara_data[] = $row['jumlah_suara'];
}

$getVotesArr = mysqli_query($koneksi, "SELECT count(id_voter) AS jumlah_pemilih FROM voter");
$pemilih = mysqli_fetch_array($getVotesArr);
?>

<script type="text/javascript">
  //Download Chart Image
  document.getElementById("download").addEventListener('click', function() {
    /*Get image of canvas element*/
    var url_base64jp = document.getElementById("myBarChart").toDataURL("image/jpg");
    /*get download button (tag: <a></a>) */
    var a = document.getElementById("download");
    /*insert chart image url to download button (tag: <a></a>) */
    a.href = url_base64jp;
  });

  // //Download Chart Image
  // document.getElementById("download_pie").addEventListener('click', function(){
  //   /*Get image of canvas element*/
  //   var url_base64jp = document.getElementById("myPieChart").toDataURL("image/jpg");
  //   /*get download button (tag: <a></a>) */
  //   var a =  document.getElementById("download");
  //   /*insert chart image url to download button (tag: <a></a>) */
  //   a.href = url_base64jp;
  // });


  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
      dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
      s = '',
      toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
      };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }

  // Bar Chart Example
  var ctx = document.getElementById("myBarChart");
  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($candidateData); ?>,
      datasets: [{
        label: "Number of Votes",
        backgroundColor: "#4e73df",
        hoverBackgroundColor: "#2e59d9",
        borderColor: "#4e73df",
        data: <?php echo json_encode($suara_data); ?>,
      }],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'month'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 6
          },
          maxBarThickness: 25,
        }],
        yAxes: [{
          ticks: {
            min: 0,
            max: <?php echo $pemilih['jumlah_pemilih']; ?>,
            maxTicksLimit: 5,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function(value, index, values) {
              return number_format(value);
            }
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: false
      },
      tooltips: {
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
        callbacks: {
          label: function(tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
          }
        }
      },
    }
  });

  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  // Pie Chart Example
  var ctx = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: <?php echo json_encode($candidateData); ?>,
      datasets: [{
        data: <?php echo json_encode($suara_data); ?>,
        backgroundColor: ['#fc544b', '#1cc88a', '#ffa426', '#66bb6a', '#6777EF', '#3abaf4', '#757575'],
        hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: false
      },
      cutoutPercentage: 80,
    },
  });
</script>