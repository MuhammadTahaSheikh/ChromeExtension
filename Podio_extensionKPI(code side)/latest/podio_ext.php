<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
?>
<?php

$user = 'root';
$password = '';

$database = '360synergydb';


$servername = 'localhost';
$mysqli = new mysqli(
  $servername,
  $user,
  $password,
  $database
);

if ($mysqli->connect_error) {
  die('Connect Error (' .
    $mysqli->connect_errno . ') ' .
    $mysqli->connect_error);
}


$a = ['hot', 'warm', 'cold'];
$i = 0;
while ($i < count($a)) {
  $temp = $a[$i];
  $sqlw = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `Leads` FROM leads WHERE created_at between date_sub(now(),INTERVAL 1 WEEK) and now() AND `temperature`= '$temp'  AND
  Cleints_id=1";
  $resultw = $mysqli->query($sqlw);
  $sqlm = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `Leads` FROM leads WHERE created_at between date_sub(now(),INTERVAL 1 MONTH) and now() AND `temperature`= '$temp'  AND
  Cleints_id=1";
  $resultm = $mysqli->query($sqlm);
  $sql3m = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `Leads` FROM leads WHERE created_at between date_sub(now(),INTERVAL 3 MONTH) and now() AND `temperature`= '$temp'  AND
  Cleints_id=1";
  $result3m = $mysqli->query($sql3m);
  if ($temp == 'hot') {
    while ($rows = $resultw->fetch_assoc()) {
      $HotWeek = $rows['Leads'];
      // echo $HotWeek;

    }
    while ($rows = $resultm->fetch_assoc()) {
      $HotMonth = $rows['Leads'];
    }
    while ($rows = $result3m->fetch_assoc()) {
      $Hot3Month = $rows['Leads'];
    }
    $i++;
  } elseif ($temp == 'warm') {
    while ($row_warmw = $resultw->fetch_assoc()) {

      $WarmWeek = $row_warmw['Leads'];
    }
    while ($row_warmm = $resultm->fetch_assoc()) {
      $WarmMonth = $row_warmm['Leads'];
    }
    while ($row_warm3m = $result3m->fetch_assoc()) {
      $Warm3Month = $row_warm3m['Leads'];
    }
    $i++;
  } elseif ($temp == 'cold') {
    while ($row_coldw = $resultw->fetch_assoc()) {
      $ColdWeek = $row_coldw['Leads'];
    }
    while ($row_coldm = $resultm->fetch_assoc()) {
      $ColdMonth = $row_coldm['Leads'];
    }
    while ($row_cold3m = $result3m->fetch_assoc()) {
      $Cold3Month = $row_cold3m['Leads'];
    }
    $i++;
  }
}

$sqlcheck = "SELECT * from `leads` WHERE Appointment_Happened IN ('completed','pending','due_order','cancelled') AND Cleints_id=1";
$resultch = $mysqli->query($sqlcheck);
$b = ['completed', 'pending', 'due_order', 'cancelled'];
$j = 0;
$cinc = 0;
$pinc = 0;
$dinc = 0;
$cninc = 0;
while ($j < count($b)) {
  // $stat=$b[$j];

  while ($rows = $resultch->fetch_assoc()) {
    $check = $rows['Appointment_Happened'];

    if ($check == 'completed') {
      // echo $HotWeek;
      $cinc++;

      $j++;
    } elseif ($check == 'pending') {
      // echo $HotWeek;
      $pinc++;

      $j++;
    } elseif ($check == 'due_order') {
      // echo $HotWeek;
      $dinc++;

      $j++;
    } elseif ($check == 'cancelled') {
      // echo $HotWeek;
      $cninc++;

      $j++;
    } else {
      $j++;
    }
    $j++;
  }
  $j++;
}
$c = ['sms-in', 'sms-out', 'call-in', 'call-out'];
$k = 0;
while ($k < count($c)) {
  $tempt = $c[$k];
  $sqlw = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `telemarketing` FROM telemarketing WHERE created_at between date_sub(now(),INTERVAL 1 WEEK) and now() AND `communication_type`= '$tempt'  AND
    Cleints_id=1";
  $resultw = $mysqli->query($sqlw);
  $sqlm = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `telemarketing` FROM telemarketing WHERE created_at between date_sub(now(),INTERVAL 1 MONTH) and now() AND `communication_type`= '$tempt'  AND
    Cleints_id=1";
  $resultm = $mysqli->query($sqlm);
  $sql3m = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `telemarketing` FROM telemarketing WHERE created_at between date_sub(now(),INTERVAL 3 MONTH) and now() AND `communication_type`= '$tempt'  AND
    Cleints_id=1";
  $result3m = $mysqli->query($sql3m);
  if ($tempt == 'sms-in') {
    while ($rows = $resultw->fetch_assoc()) {
      $smsinw = $rows['telemarketing'];
      // echo $HotWeek;

    }
    while ($rows = $resultm->fetch_assoc()) {
      $smsinm = $rows['telemarketing'];
    }
    while ($rows = $result3m->fetch_assoc()) {
      $smsin3m = $rows['telemarketing'];
    }
    $k++;
  } elseif ($tempt == 'sms-out') {
    while ($row_warmw = $resultw->fetch_assoc()) {

      $smsoutw = $row_warmw['telemarketing'];
    }
    while ($row_warmm = $resultm->fetch_assoc()) {
      $smsoutm = $row_warmm['telemarketing'];
    }
    while ($row_warm3m = $result3m->fetch_assoc()) {
      $smsout3m = $row_warm3m['telemarketing'];
    }
    $k++;
  } elseif ($tempt == 'call-in') {
    while ($row_coldw = $resultw->fetch_assoc()) {
      $callinw = $row_coldw['telemarketing'];
    }
    while ($row_coldm = $resultm->fetch_assoc()) {
      $callinm = $row_coldm['telemarketing'];
    }
    while ($row_cold3m = $result3m->fetch_assoc()) {
      $callin3m = $row_cold3m['telemarketing'];
    }
    $k++;
  } elseif ($tempt == 'call-out') {
    while ($row_coldw = $resultw->fetch_assoc()) {
      $calloutw = $row_coldw['telemarketing'];
    }
    while ($row_coldm = $resultm->fetch_assoc()) {
      $calloutm = $row_coldm['telemarketing'];
    }
    while ($row_cold3m = $result3m->fetch_assoc()) {
      $callout3m = $row_cold3m['telemarketing'];
    }
    $k++;
  }
}

$d = ['text', 'cold', 'ppc', 'ppl'];
$l = 0;
while ($l < count($d)) {
  $tempty = $d[$l];
  $sqlw = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `Leads` FROM leads WHERE created_at between date_sub(now(),INTERVAL 1 WEEK) and now() AND `type`= '$tempty'  AND
    Cleints_id=1";
  $resultw = $mysqli->query($sqlw);
  $sqlm = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `Leads` FROM leads WHERE created_at between date_sub(now(),INTERVAL 1 MONTH) and now() AND `type`= '$tempty'  AND
    Cleints_id=1";
  $resultm = $mysqli->query($sqlm);
  $sql3m = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `Leads` FROM leads WHERE created_at between date_sub(now(),INTERVAL 3 MONTH) and now() AND `type`= '$tempty'  AND
    Cleints_id=1";
  $result3m = $mysqli->query($sql3m);
  if ($tempty == 'text') {
    while ($rows = $resultw->fetch_assoc()) {
      $leadw = $rows['Leads'];
    }
    while ($rows = $resultm->fetch_assoc()) {
      $leadm = $rows['Leads'];
    }
    while ($rows = $result3m->fetch_assoc()) {
      $lead3m = $rows['Leads'];
    }
    $l++;
  }
  if ($tempty == 'cold') {
    while ($rows = $resultw->fetch_assoc()) {
      $leadcw = $rows['Leads'];
    }
    while ($rows = $resultm->fetch_assoc()) {
      $leadcm = $rows['Leads'];
    }
    while ($rows = $result3m->fetch_assoc()) {
      $leadc3m = $rows['Leads'];
    }
    $l++;
  }
  if ($tempty == 'ppl') {
    while ($rows = $resultw->fetch_assoc()) {
      $leadwppl = $rows['Leads'];
    }
    while ($rows = $resultm->fetch_assoc()) {
      $leadmppl = $rows['Leads'];
    }
    while ($rows = $result3m->fetch_assoc()) {
      $lead3mppl = $rows['Leads'];
    }
    $l++;
  }
  if ($tempty == 'ppc') {
    while ($rows = $resultw->fetch_assoc()) {
      $leadwppc = $rows['Leads'];
    }
    while ($rows = $resultm->fetch_assoc()) {
      $leadmppc = $rows['Leads'];
    }
    while ($rows = $result3m->fetch_assoc()) {
      $lead3mppc = $rows['Leads'];
    }
    $l++;
  }
}

$contract = ['signed', 'sent'];
$contract_d = 0;
while ($contract_d < count($contract)) {
  $contract_y = $contract[$contract_d];
  $sql_contract = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `Status` FROM contracts WHERE created_at between date_sub(now(),INTERVAL 1 WEEK) and now() AND `status`= '$contract_y' AND client_id=1;
  ";
  $result_contract = $mysqli->query($sql_contract);
  $sqlm_contract = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `Status` FROM contracts WHERE created_at between date_sub(now(),INTERVAL 1 MONTH) and now() AND `status`= '$contract_y' AND client_id=1;
  ";
  $resultm_contract = $mysqli->query($sqlm_contract);
  $sql3m_contract = "SELECT DATE(created_at) AS `Date`, COUNT(*) AS `Status` FROM contracts WHERE created_at between date_sub(now(),INTERVAL 3 MONTH) and now() AND `status`= '$contract_y' AND client_id=1;
  ";
  $result3m_contract = $mysqli->query($sql3m_contract);
  if ($contract_y == 'signed') {
    while ($rows = $result_contract->fetch_assoc()) {
      $leadw_contract = $rows['Status'];
    }
    while ($rows = $resultm_contract->fetch_assoc()) {
      $leadm_contract = $rows['Status'];
    }
    while ($rows = $result3m_contract->fetch_assoc()) {
      $lead3m_contract = $rows['Status'];
    }
    $contract_d ++;
  }
  if ($contract_y == 'sent') {
    while ($rows = $result_contract->fetch_assoc()) {
      $leadcw_contract = $rows['Status'];
    }
    while ($rows = $resultm_contract->fetch_assoc()) {
      $leadcm_contract = $rows['Status'];
    }
    while ($rows = $result3m_contract->fetch_assoc()) {
      $leadc3m_contract = $rows['Status'];
    }
    $contract_d ++;
  }
  
}

$escrow = "SELECT SUM(escrow_money) AS total_amount FROM escrow WHERE created_at between date_sub(now(),INTERVAL 1 MONTH) and now()
 AND client_id=1;";
$result_escrow = $mysqli->query($escrow);
$sqlm_escrow = "SELECT SUM(escrow_money) AS total_amount FROM escrow WHERE created_at between date_sub(now(),INTERVAL 2 MONTH) and now()
 AND client_id=1;";
$resultm_escrow = $mysqli->query($sqlm_escrow);
$sql3m_escrow = "SELECT SUM(escrow_money) AS total_amount FROM escrow WHERE created_at between date_sub(now(),INTERVAL 3 MONTH) and now()
  AND client_id=1;";
$result3m_escrow = $mysqli->query($sql3m_escrow);

  while ($rows = $result_escrow->fetch_assoc()) {
    $leadw_escrow = $rows['total_amount'];
  }
  while ($rows = $resultm_escrow->fetch_assoc()) {
    $leadm_escrow = $rows['total_amount'];
  }
  while ($rows = $result3m_escrow->fetch_assoc()) {
    $lead3m_escrow = $rows['total_amount'];
  }





$sqlcsr = "select * from `campaign_success` ";
$rescsr = $mysqli->query($sqlcsr);


$sqlchecklud = "SELECT * from `leads` WHERE Cleints_id=1";
$resultlud = $mysqli->query($sqlchecklud);
$arr_lud = ['0', '1'];
$lud = 0;
$trinc = 0;
$fainc = 0;

while ($lud < count($arr_lud)) {
  // $stat=$b[$j];

  while ($rows = $resultlud->fetch_assoc()) {
    $check = $rows['leads_under_drip'];

    if ($check == '1') {
      // echo $HotWeek;
      $trinc++;

      $lud++;
    } elseif ($check == '0') {
      // echo $HotWeek;
      $fainc++;

      $lud++;
    } else {
      $lud++;
    }
  }
  $lud++;
}


$sqlvah = "select * from `va_hours` ";
$resvah = $mysqli->query($sqlvah);


$linechart_mon = $mysqli->query("SELECT count(*) as month_count, monthname(created_at), YEAR(created_at) FROM telemarketing GROUP BY MONTH(created_at),YEAR(created_at) ORDER BY created_at;");
$monthname = [];
foreach ($linechart_mon as $data) {
  $monthnamech[] = $data['monthname(created_at)'];
}



$bar_chart = $mysqli->query("SELECT DATE_FORMAT(created_at, '%M') AS month_name, SUM(amount) AS total_sales FROM bar_chart WHERE YEAR(created_at) = YEAR(NOW()) GROUP BY month_name ORDER BY MONTH(created_at) ASC;");
// $bar_chart_res= $mysqli->query($bar_chart);
foreach ($bar_chart as $data) {
  $month[] = $data['month_name'];
  $amount[] = $data['total_sales'];
}
// $mysqli->close();

// $profitchart=$mysqli->query("SELECT `year` as year, SUM(sale) as sale FROM `profit_chart` GROUP BY year" );
// $bar_chart_res= $mysqli->query($bar_chart);



$profitchart = $mysqli->query("SELECT DATE_FORMAT(created_at, '%M') AS month_name, SUM(sale) AS total_sales FROM profit_chart WHERE YEAR(created_at) = YEAR(NOW()) GROUP BY month_name ORDER BY MONTH(created_at) ASC");

foreach ($profitchart as $data) {
  $year[] = $data['month_name'];
  $sale[] = $data['total_sales'];
}



// $linechart = $mysqli->query("SELECT count(*) as month_count, MONTHNAME(created_at), YEAR(created_at) FROM telemarketing WHERE `communication_type`='sms-in' GROUP BY MONTH(created_at),YEAR(created_at) ORDER BY created_at");
// $bar_chart_res= $mysqli->query($bar_chart);
$linechart = $mysqli->query("SELECT DATE_FORMAT(created_at, '%M') AS month_name, count(*) AS month_count FROM telemarketing WHERE `communication_type`='sms-in' AND YEAR(created_at) = YEAR(NOW()) GROUP BY month_name ORDER BY MONTH(created_at) ASC;");
foreach ($linechart as $data) {
  $MONTHNAME[] = $data['month_name'];

  $month_count_smsin[] = $data['month_count'];
}
// print_r($MONTHNAME);
$linechartsmsout = $mysqli->query("SELECT count(*) as month_count, MONTHNAME(created_at), YEAR(created_at) FROM telemarketing WHERE `communication_type`='sms-out' GROUP BY MONTH(created_at),YEAR(created_at) ORDER BY created_at");
// $bar_chart_res= $mysqli->query($bar_chart);
foreach ($linechartsmsout as $data2) {
  $MONTHNAME[] = $data2['MONTHNAME(created_at)'];
  $month_count_smsout[] = $data2['month_count'];
}


$linechartcallin = $mysqli->query("SELECT count(*) as month_count, MONTHNAME(created_at), YEAR(created_at) FROM telemarketing WHERE `communication_type`='call-in' GROUP BY MONTH(created_at),YEAR(created_at) ORDER BY created_at");
// $bar_chart_res= $mysqli->query($bar_chart);
foreach ($linechartcallin as $data3) {
  $MONTHNAME[] = $data2['MONTHNAME(created_at)'];
  $month_count_callin[] = $data3['month_count'];
}


$linechartcallout = $mysqli->query("SELECT count(*) as month_count, MONTHNAME(created_at), YEAR(created_at) FROM telemarketing WHERE `communication_type`='call-out' GROUP BY MONTH(created_at),YEAR(created_at) ORDER BY created_at");
// $bar_chart_res= $mysqli->query($bar_chart);
foreach ($linechartcallout as $data4) {
  $MONTHNAME[] = $data2['MONTHNAME(created_at)'];
  $month_count_callout[] = $data4['month_count'];
}

$query = "SELECT date, value1, value2, value3, value4 FROM multilinechart";
$result = $mysqli->query($query);

$datasets = array();
$labels = array();
$colors = array('#2DC12A', '#FF3838', '#FFC738' , 'rgba(255, 206, 86, 0.2)');
while ($row = $result->fetch_assoc()) {
  // add label
  $labels[] = $row['date'];

  // add data to datasets
  $datasets[0]['data'][] = $row['value1'];
  $datasets[1]['data'][] = $row['value2'];
  $datasets[2]['data'][] = $row['value3'];
  $datasets[3]['data'][] = $row['value4'];
}
$datasets[0]['label'] = 'SMS-IN';
$datasets[1]['label'] = 'SMS-OUT';
$datasets[2]['label'] = 'Call-IN';
$datasets[3]['label'] = 'Call-OUT';
$datasets[0]['backgroundColor'] = $colors[0];
$datasets[1]['backgroundColor'] = $colors[1];
$datasets[2]['backgroundColor'] = $colors[2];
$datasets[3]['backgroundColor'] = $colors[3];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <link rel="stylesheet" href="main.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->

  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0;" />

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;700&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;500&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;600&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet">
  <title>360Synergy</title>
</head>

<body>
  <div>
    <div class="grid-container">

      <div class="grid-item">

        <div class="fl-div1">Lead Temperature</div>
        <table class="t-1">
          <tr>

            <th class="th-1"><span class="th-s1a">Week</span></th>
            <th class="th-1a"><span class="th-s1a">Month</span></th>
            <th class="th-1b"><span class="th-s1b">3 Month</span></th>
          </tr>
        </table>
        <table class="tab-1">
          <tr>
            <td class="td-1">
              <div class="circle" style="background-color:#FF8B38 ;"> </div><span>Hot</span>
            </td>

            <td class="td-2s"><?php echo $HotWeek ?></td>
            <td class="td-2jj"><?php echo $HotMonth ?></td>
            <td class="td-2pp"><?php echo $Hot3Month ?></td>
          </tr>
          <tr>
            <td class="td-1">
              <div class="circle" style="background-color:#FFC738 ;"></div><span>Warm</span>
            </td>
            <td class="td-2s"><?php echo $WarmWeek ?></td>
            <td class="td-2jj"><?php echo $WarmMonth ?></td>
            <td class="td-2pp"><?php echo $Warm3Month ?></td>
          </tr>
          <tr>
            <td class="td-1">
              <div class="circle" style="background-color:#38ABFF ;"></div><span>Cold</span>
            </td>
            <td class="td-2s"><?php echo $ColdWeek ?></td>
            <td class="td-2jj"><?php echo $ColdMonth ?></td>
            <td class="td-2pp"><?php echo $Cold3Month ?></td>
          </tr>
        </table>


      </div>
      <div class="grid-item1">
        <div class="d-3"> Appointments</div>
        <div>
          <table class="tb-c">

            <tr class="l1">
              <td class="cc">
                <div class="circle" style="background-color:#2DC12A ; "></div>Completed
              </td>
              <td class="sp1"><?php echo $cinc ?></td>
            </tr>
            <tr class="l1">
              <td class="cc">
                <div class="circle" style="background-color: #FFC738;  "></div><span>Pending</span>
              </td>
              <td class="sp2"><?php echo $pinc ?></td>
            </tr>
            <tr class="l1">
              <td class="cc">
                <div class="circle" style="background-color: #FF8B38;   "></div><span>Due Oder</span>
              </td>
              <td class="sp3"><?php echo $dinc ?></td>
            </tr>
            <tr class="l1">
              <td class="cc">
                <div class="circle" style="background-color: #FF3838;   "></div><span>Cancled</span>
              </td>

              <td class="sp4"><?php echo $cninc ?></td>
            </tr>
          </table>

        </div>
      </div>
      <div class="grid-item2">
        <div class="d-2">Leads Under Drip</div>
        <div class="d-2a"><?php echo $trinc ?></div>
      </div>
      <div class="grid-item3">
        <div class="fl-div2">Telemarketing</div>
        <table class="t-1" style="float: right;">
          <tr>
            <th class="th-1aa"><span class="th-s1a">Week</span></th>
            <th class="th-1ab"><span class="th-s1a">Month</span></th>
            <th class="th-1b"><span class="th-s1b">3 Month</span></th>

          </tr>
        </table>
        <table class="tab_1">
          <tr>
            <td class="td-1a">SMS<span style="color: #2DC12A; background-color: white;padding-left: 4%;">In</span></td>
            <td class="td-31"><?php echo $smsinw ?></td>
            <td class="td-3a1"><?php echo $smsinm ?></td>
            <td class="td-3b1"><?php echo $smsin3m ?></td>
          </tr>
          <tr>
            <td class="td-1a">SMS<span style="color: #FF3838; background-color: white;padding-left: 4%;">Out</span>
            </td>
            <td class="td-31"><?php echo $smsoutw ?></td>
            <td class="td-3a1"><?php echo $smsoutm ?></td>
            <td class="td-3b1"><?php echo $smsout3m ?></td>
          </tr>
          <tr>
            <td class="td-1a">Calls<span style="color: #FFC738; background-color: white;padding-left: 4%;">In</span>
            </td>
            <td class="td-31"><?php echo $callinw ?></td>
            <td class="td-3a1"><?php echo $callinm ?></td>
            <td class="td-3b1"><?php echo $callin3m ?></td>
          </tr>
          <tr>
            <td class="td-1a">Calls<span style="color: #FF8B38; padding-left: 4%;">Out</span>
            </td>
            <td class="td-31"><?php echo $calloutw ?></td>
            <td class="td-3a1"><?php echo $calloutm ?></td>
            <td class="td-3b1"><?php echo $callout3m ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="container3">

    <div class="contract_one">
      <p class="contract_data_sign">Text Lead<img src="images/Group 5.png" alt="" class="img_agreement"></p>
      <div class="contract_imgdata">
         
      <table class="tb_sign">
          <tr>
            <th class="th_sign">Week</th>
          </tr>
          <tr>
            <td class="td_sign"><?php echo $leadw ?></td>
          </tr>
          
        </table>
        <table class="tb">
          <tr>
            <th class="th_sign">Month</th>
          </tr>
          <tr>
            <td class="td_sign"><?php echo $leadm ?></td>
          </tr>
          
        </table>
        <table class="tb">
          <tr>
            <th class="th_sign">3 Months</th>
          </tr>
          <tr>
            <td class="td_sign"><?php echo $lead3m ?></td>
          </tr>
          
        </table>

      </div>


    </div>
    <div class="contract_two">
      <p class="contract_data">Cold Call Leads<img src="images/Vector.png" alt="" class="img_agreement"></p>
      <div class="contract_imgdata">
        
        <table class="tb">
          <tr>
            <th class="th_signed">Week</th>
          </tr>
          <tr>
            <td class="td_signed"><?php echo $leadcw ?></td>
          </tr>
          
        </table>
        <table class="tb">
          <tr>
            <th class="th_signed">Month</th>
          </tr>
          <tr>
            <td class="td_signed"><?php echo $leadcm ?></td>
          </tr>
          
        </table>
        <table class="tb">
          <tr>
            <th class="th_signed">3 Months</th>
          </tr>
          <tr>
            <td class="td_signed"><?php echo $leadc3m ?></td>
          </tr>
          
        </table>
      </div>
    </div>
    <div class="contract_three">
      <p class="contract_data1">PPC Leads <img src="images/Group 7.png" alt="" class="escrow_img"></p>
      <div class="contract_imgdata">
      <table class="tb_sign1">
          <tr>
            <th class="th_sign1">Week</th>
          </tr>
          <tr>
            <td class="td_sign1"><?php echo $leadwppc ?></td>
          </tr>
          
        </table>
        <table class="tb_sign1">
          <tr>
            <th class="th_sign1">Month</th>
          </tr>
          <tr>
            <td class="td_sign1"><?php echo $leadmppc ?></td>
          </tr>
          
        </table>
        <table class="tb_sign1">
          <tr>
            <th class="th_sign1">3 Months</th>
          </tr>
          <tr>
            <td class="td_sign1"><?php echo $lead3mppc ?></td>
          </tr>
          
        </table>
       
       

      </div>
    </div>
    <div class="contract_four">
      
    <p class="contract_data">PPL Leads<img src="images/Group 8.png" alt="" class="img_agreement"></p>
      <div class="contract_imgdata">
        
        <table class="tb">
          <tr>
            <th class="th_signed">Week</th>
          </tr>
          <tr>
            <td class="td_signed"><?php echo $leadwppl ?></td>
          </tr>
          
        </table>
        <table class="tb">
          <tr>
            <th class="th_signed">Month</th>
          </tr>
          <tr>
            <td class="td_signed"><?php echo $leadmppl ?></td>
          </tr>
          
        </table>
        <table class="tb">
          <tr>
            <th class="th_signed">3 Months</th>
          </tr>
          <tr>
            <td class="td_signed"><?php echo $lead3mppl ?></td>
          </tr>
          
        </table>
      </div>
    </div>
    
    </div>


  </div>
  <!-- </div> -->
  </div>

  <!-- </div> -->
  </div>
  </div>
  <div class="grid-container1">
    <div class="grid-item1a">
      <div class="gia">
        SMS In/Out Graph
      </div>
      <!-- <img src="Chart.png" class="img1"/> -->
      <canvas id="speedChart"></canvas>

    </div>
    <div class="grid-item1b">
      <div class="item3d11">


          <p class="th-111">Marketing Expense</p>


       

</div>

      <div class="chart-container">
        <canvas id="chart"></canvas>
      </div>
      <!-- <img src="Chart1.png" class="img2"/> -->
    </div>
  </div>
  </div>
  <div class="main_contract">
    <div class="contract_one">
      <p class="contract_data_sign">Signed Contracts<img src="images/Group 2.png" alt="" class="img_agreement"></p>
      <div class="contract_imgdata">
         
      <table class="tb_sign">
          <tr>
            <th class="th_sign">Week</th>
          </tr>
          <tr>
            <td class="td_sign"><?php echo $leadw_contract ?></td>
          </tr>
          
        </table>
        <table class="tb">
          <tr>
            <th class="th_sign">Month</th>
          </tr>
          <tr>
            <td class="td_sign"><?php echo $leadm_contract ?></td>
          </tr>
          
        </table>
        <table class="tb">
          <tr>
            <th class="th_sign">3 Months</th>
          </tr>
          <tr>
            <td class="td_sign"><?php echo $lead3m_contract ?></td>
          </tr>
          
        </table>

      </div>


    </div>
    <div class="contract_two">
      <p class="contract_data">Sent Contracts<img src="images/Group 3.png" alt="" class="img_agreement"></p>
      <div class="contract_imgdata">
        
        <table class="tb">
          <tr>
            <th class="th_signed">Week</th>
          </tr>
          <tr>
            <td class="td_signed"><?php echo $leadcw_contract ?></td>
          </tr>
          
        </table>
        <table class="tb">
          <tr>
            <th class="th_signed">Month</th>
          </tr>
          <tr>
            <td class="td_signed"><?php echo $leadcm_contract ?></td>
          </tr>
          
        </table>
        <table class="tb">
          <tr>
            <th class="th_signed">3 Months</th>
          </tr>
          <tr>
            <td class="td_signed"><?php echo $leadc3m_contract ?></td>
          </tr>
          
        </table>
      </div>
    </div>
    <div class="contract_three">
      <p class="contract_data1">Closed Escrows <img src="images/Group 4.png" alt="" class="escrow_img"></p>
      <div class="contract_imgdata">
      <table class="tb_sign1">
          <tr>
            <th class="th_sign1">1 Month</th>
          </tr>
          <tr>
            <td class="td_sign1"><?php echo $leadw_escrow ?></td>
          </tr>
          
        </table>
        <table class="tb_sign1">
          <tr>
            <th class="th_sign1">2 Month</th>
          </tr>
          <tr>
            <td class="td_sign1"><?php echo $leadm_escrow ?></td>
           
          </tr>
          
        </table>
        <table class="tb_sign1">
          <tr>
            <th class="th_sign1">3 Months</th>
          </tr>
          <tr>
            <td class="td_sign1"><?php echo $lead3m_escrow ?></td>
          </tr>
          
        </table>
       
       

      </div>
    </div>
    <div class="contract_four">
      
    <img src="images/Logo-1.png" alt="" class="stopshop">
    </div>
  </div>

















  <div class="campVas">
    <div class="item4">
      <div class="item4d1">
        Campaign Success Rate
      </div>
      <!-- <div id="table-wrapper"> -->

      <table class="item4d2">
        <!-- <div> -->
        <th class="th-41">#</th>

        <th class="th-42">Name</th>

        <th class="th-43">Leads</th>

      </table>
      <div id="table-scroll" class="basicPackagesUL">
        <table>
          <tr>
            <?php
            while ($row = mysqli_fetch_assoc($rescsr)) {

            ?>
              <td>
                <div class="td-12ab"><?php echo $row['id'] ?></div>
              </td>

              <td>

                <div class="td-41b"><?php echo $row['campaign_name'] ?></div>

              </td>
              <td>
                <div class="td-41c"><?php echo $row['campaign_leads'] ?></div>
              </td>

          </tr>
        <?php
            }
        ?>

        <!-- </div> -->

        </table>

      </div>
    </div>





    <div class="item3">
      <div class="item3d">VA’s Hours</div>
      <!-- <div id="table-wrapper"> -->
      <!-- <div id="table-scroll_VA"> -->
      <!-- <div> -->
      <table class="item3d1">


        <th class="th-11">#</th>
        <th class="th-11a">Name</th>

        <th class="th-12">Week</th>
        <th class="th-12a">Month</th>
        <th class="th-12b">3 Month</th>



      </table>
      <!-- </div> -->
      <div id="table-scroll_VA" class="basicPackagesUL">
        <table>
          <?php
          $i = 1;
          $temp = 1;
          $ah = "SELECT * FROM va_hours WHERE cleints_id=1";
          $resultah = $mysqli->query($ah);
          while ($row = mysqli_fetch_assoc($resultah)) {
            $temp = $row['id'];
          }
          while ($i <= $temp) {

            $ta = "SELECT *, SUM(TIMESTAMPDIFF(HOUR,`time-in`,`time-out`)) AS `working_hours` from va_hours WHERE  created_at between date_sub(now(),INTERVAL 1 WEEK) and now() AND id=$i AND cleints_id=1";
            $resultta = $mysqli->query($ta);
            $ta1 = "SELECT *, SUM(TIMESTAMPDIFF(HOUR,`time-in`,`time-out`)) AS `working_hours_m` from va_hours WHERE  created_at between date_sub(now(),INTERVAL 1 MONTH) and now() AND id=$i AND cleints_id=1";
            $resultta1 = $mysqli->query($ta1);
            $ta2 = "SELECT *, SUM(TIMESTAMPDIFF(HOUR,`time-in`,`time-out`)) AS `working_hours_3m` from va_hours WHERE  created_at between date_sub(now(),INTERVAL 3 MONTH) and now() AND id=$i AND cleints_id=1";
            $resultta2 = $mysqli->query($ta2);


            while ($row = mysqli_fetch_assoc($resvah)) {

          ?>
              <tr>
                <td>
                  <div class="td-12"><?php echo $row['id'] ?></div>
                </td>

                <td>
                  <div class="td-12a">
                    <div class="td-12b"><?php echo $row['Name'] ?></div>
                  </div>
                </td>
                <?php
                $cond = 0;
                $cond1 = 0;
                $cond2 = 0;
                while ($row = mysqli_fetch_assoc($resultta)) {
                  if ($row['working_hours'] == '') {
                    $cond = 0;
                  } else {
                    $cond = $row['working_hours'];
                  }

                ?>
                  <td>
                    <div class="td-12cc"><?php echo $cond ?></div>
                  </td>
                <?php

                }
                while ($row = mysqli_fetch_assoc($resultta1)) {
                  if ($row['working_hours_m'] == '') {
                    $cond1 = 0;
                  } else {
                    $cond1 = $row['working_hours_m'];
                  }
                ?>
                  <td>
                    <div class="td-12cd"><?php echo $cond1 ?></div>
                  </td>
                <?php
                }
                while ($row = mysqli_fetch_assoc($resultta2)) {
                  if ($row['working_hours_3m'] == '') {
                    $cond2 = 0;
                  } else {
                    $cond2 = $row['working_hours_3m'];
                  }
                ?>
                  <td>
                    <div class="td-12ce"><?php echo $cond2 ?></div>
                  </td>
                <?php
                }
                ?>
              </tr>
            <?php
              break;
            }
            $i++;


            ?>

          <?php

          }

          $mysqli->close();

          ?>

        </table>
      </div>
    </div>









  </div>

  </div>




















  <div class="grid-container-last">
    <div class="grid-last">
      <div class="ll">Current Year Profit (<?php echo date('Y') ?>)</div>
      <!--        
        <div  id="chartContainer" ></div> -->
      <!-- <img src="Chart3.png" class="img3"/> -->
      <canvas id="speedChart1"></canvas>
    </div>
  </div>


  <script>
    var data = {
      labels: <?php echo json_encode($month) ?>,
      datasets: [{
        label: "Expenses",
        backgroundColor: '#FFC738',
        borderColor: "#FFC738",
        // borderWidth: 0,
        hoverBackgroundColor: "rgba(255,99,132,0.4)",
        hoverBorderColor: "rgba(255,99,132,1)",
        data: <?php echo json_encode($amount) ?>,
      }]
    };
    //Chart.defaults.scale.gridLines.display = false;

    var options = {
      maintainAspectRatio: false,
      scales: {
        yAxes: [{
          ticks: {
            min: 0,
            max: 1000
          }
        }],
        y: {
          stacked: true,
          grid: {
            display: true,
            color: "rgba(255,99,132,0.2)"
          }
        },
        x: {
          grid: {
            display: false
          }
        }
      }
    };

    new Chart('chart', {
      type: 'bar',
      options: options,
      data: data,

    });
  </script>

  <script>
    var speedCanvas1 = document.getElementById("speedChart1");


    var dataFirst = {
      label: "",
      data: <?php echo json_encode($sale) ?>,
      lineTension: 0,
      fill: false,
      borderColor: 'yellow'
    };


    var speedData1 = {
      labels: <?php echo json_encode($year) ?>,
      datasets: [dataFirst]
    };

    var chartOptions = {
      legend: {
        display: true,
        position: 'bottom',
        labels: {
          boxWidth: 0,
          fontColor: '#05758A'
        }
      }
    };

    var lineChart = new Chart(speedCanvas1, {
      type: 'line',
      data: speedData1,
      options: chartOptions
    });
  </script>

  <?php
  ?>
  <script>
    var speedCanvas = document.getElementById("speedChart");


    var dataFirst = {
      labels: <?php echo json_encode($labels); ?>,
  datasets: <?php echo json_encode($datasets); ?>,
      lineTension: 0,
      fill: false,
      borderColor: '#2DC12A',
      backgroundColor: '#2DC12A'
    };

    // var dataSecond = {
    //   label: "SMS Out",
    //   data: [0, 0, 50, 280, 700, 0, 400, 300, 100, 600, 450, 100],
    //   lineTension: 0,
    //   fill: false,
    //   borderColor: '#FF3838',
    //   backgroundColor: '#FF3838'
    // };
    // var dataThird = {
    //   label: "Calls In",
    //   data: [300, 550, 75, 250, 620, 750, 300, 150, 300, 400],
    //   lineTension: 0,
    //   fill: false,
    //   borderColor: '#FFC738',
    //   backgroundColor: '#FFC738'
    // };

    // var dataFourth = {
    //   label: "Calls Out",
    //   data: [260, 300, 690, 300, 780, 200, 990, 500, 750, 800, 730],
    //   lineTension: 0,
    //   fill: false,
    //   borderColor: '#FF8B38',
    //   backgroundColor: '#FF8B38'
    // };
    var speedData = {
      // labels: ["Jan", "Feb", "Mar", "April", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
      datasets: [dataFirst]
    };

    var chartOptions = {
      legend: {
        display: true,
        position: 'bottom',
        labels: {
          boxWidth: 40,
          usePointStyle: true,
          fontColor: 'black'
        }
      }
    };

    var lineChart = new Chart(speedCanvas, {
      type: 'line',
      data: dataFirst,
      options: chartOptions
    });
  </script>
</body>
</div>

</body>

</html>