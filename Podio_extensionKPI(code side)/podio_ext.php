<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

//if(!isset($_REQUEST['client_id']) || empty($_REQUEST['client_id'])){
//  echo '<!DOCTYPE html>
//<html lang="en">
//</html>';
//  exit;
//}

$user = 'root';
$password = '';
$database = 'updated_podio_extension';
$servername = 'localhost';

$mysqli = new mysqli(
  $servername,
  $user,
  $password,
  $database
);

if ($mysqli->connect_error) {
  die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}



// Get the sent value from the $_POST superglobal
$client_id = $_REQUEST['client_id'];
$client_url = $_REQUEST['page_url'];

$sql = "SELECT c.id AS company_id
FROM clients cl
JOIN client_companies cc ON cl.id = cc.client_id
JOIN companies c ON cc.company_id = c.id
WHERE cl.id = '$client_id' AND c.url ='$client_url'";


$result = mysqli_query($mysqli, $sql);
$row = $result->fetch_assoc();
$company_id = $row['company_id'];
// Fetch the value from the database based on the client_id





$sqlw = "SELECT
    COALESCE(SUM(CASE WHEN temperature = 'Hot' AND created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY  THEN 1 ELSE 0 END), 0) AS hot_week,
    COALESCE(SUM(CASE WHEN temperature = 'Hot' AND created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY THEN 1 ELSE 0 END), 0) AS hot_month,
    COALESCE(SUM(CASE WHEN temperature = 'Hot' AND created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY THEN 1 ELSE 0 END), 0) AS hot_3months,
    COALESCE(SUM(CASE WHEN temperature = 'Warm' AND created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY THEN 1 ELSE 0 END), 0) AS warm_week,
    COALESCE(SUM(CASE WHEN temperature = 'Warm' AND created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY THEN 1 ELSE 0 END), 0) AS warm_month,
    COALESCE(SUM(CASE WHEN temperature = 'Warm' AND created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY THEN 1 ELSE 0 END), 0) AS warm_3months,
    COALESCE(SUM(CASE WHEN temperature = 'Cold' AND created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY THEN 1 ELSE 0 END), 0) AS cold_week,
    COALESCE(SUM(CASE WHEN temperature = 'Cold' AND created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY THEN 1 ELSE 0 END), 0) AS cold_month,
    COALESCE(SUM(CASE WHEN temperature = 'Cold' AND created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY THEN 1 ELSE 0 END), 0) AS cold_3months
FROM leads
WHERE company_id = $company_id";

$resultw = $mysqli->query($sqlw);
$row = $resultw->fetch_assoc();

$HotWeek = $row['hot_week'];
$HotMonth = $row['hot_month'];
$Hot3Month = $row['hot_3months'];
$WarmWeek = $row['warm_week'];
$WarmMonth = $row['warm_month'];
$Warm3Month = $row['warm_3months'];
$ColdWeek = $row['cold_week'];
$ColdMonth = $row['cold_month'];
$Cold3Month = $row['cold_3months'];

// ==========================================================================================Lead End Here===========================================================================================================

$sqlcheck = "SELECT 
    COUNT(CASE WHEN status = 'Completed' THEN 1 END) AS completed_count,
    COUNT(CASE WHEN status = 'Pending' THEN 1 END) AS pending_count,
    COUNT(CASE WHEN status = 'Rescheduled' THEN 1 END) AS rescheduled_count,
    COUNT(CASE WHEN status = 'Cancelled' THEN 1 END) AS cancelled_count
FROM `appointments`
WHERE status IN ('Completed', 'Pending', 'Rescheduled', 'Cancelled')
    AND company_id = $company_id";

$resultch = $mysqli->query($sqlcheck);
$row = $resultch->fetch_assoc();

$cinc = $row['completed_count'];
$pinc = $row['pending_count'];
$dinc = $row['rescheduled_count'];
$cninc = $row['cancelled_count'];


// ==========================================================================================Appointment End Here===========================================================================================================


$sql = "SELECT
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY AND title = 'sms-in' THEN 1 ELSE 0 END) AS smsinw,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY AND title = 'sms-in' THEN 1 ELSE 0 END) AS smsinm,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY AND title = 'sms-in' THEN 1 ELSE 0 END) AS smsin3m,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY AND title = 'sms-out' THEN 1 ELSE 0 END) AS smsoutw,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY AND title = 'sms-out' THEN 1 ELSE 0 END) AS smsoutm,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY AND title = 'sms-out' THEN 1 ELSE 0 END) AS smsout3m,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY AND title = 'call-in' THEN 1 ELSE 0 END) AS callinw,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY AND title = 'call-in' THEN 1 ELSE 0 END) AS callinm,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY AND title = 'call-in' THEN 1 ELSE 0 END) AS callin3m,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY AND title = 'call-out' THEN 1 ELSE 0 END) AS calloutw,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY AND title = 'call-out' THEN 1 ELSE 0 END) AS calloutm,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY AND title = 'call-out' THEN 1 ELSE 0 END) AS callout3m
FROM telemarketing
INNER JOIN types ON telemarketing.type_id = types.id
WHERE company_id = $company_id";

$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();

  $smsinw = $row['smsinw'] ?? 0;
  $smsinm = $row['smsinm'] ?? 0;
  $smsin3m = $row['smsin3m'] ?? 0;
  $smsoutw = $row['smsoutw'] ?? 0;
  $smsoutm = $row['smsoutm'] ?? 0;
  $smsout3m = $row['smsout3m'] ?? 0;
  $callinw = $row['callinw'] ?? 0;
  $callinm = $row['callinm'] ?? 0;
  $callin3m = $row['callin3m'] ?? 0;
  $calloutw = $row['calloutw'] ?? 0;
  $calloutm = $row['calloutm'] ?? 0;
  $callout3m = $row['callout3m'] ?? 0;
}

// ==========================================================================================Telemarketing End Here===========================================================================================================


$sql = "SELECT
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY AND `type` = 'Text' THEN 1 ELSE 0 END) AS leadw,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY AND `type` = 'Text' THEN 1 ELSE 0 END) AS leadm,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY AND `type` = 'Text' THEN 1 ELSE 0 END) AS lead3m,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY AND `type` = 'Cold' THEN 1 ELSE 0 END) AS leadcw,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY AND `type` = 'Cold' THEN 1 ELSE 0 END) AS leadcm,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY AND `type` = 'Cold' THEN 1 ELSE 0 END) AS leadc3m,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY AND `type` = 'PPL' THEN 1 ELSE 0 END) AS leadwppl,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY AND `type` = 'PPL' THEN 1 ELSE 0 END) AS leadmppl,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY AND `type` = 'PPL' THEN 1 ELSE 0 END) AS lead3mppl,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY AND `type` = 'PPC' THEN 1 ELSE 0 END) AS leadwppc,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY AND `type` = 'PPC' THEN 1 ELSE 0 END) AS leadmppc,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY AND `type` = 'PPC' THEN 1 ELSE 0 END) AS lead3mppc
FROM leads
WHERE company_id = $company_id";

$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

$leadw = $row['leadw'] ?? 0;
$leadm = $row['leadm'] ?? 0;
$lead3m = $row['lead3m'] ?? 0;
$leadcw = $row['leadcw'] ?? 0;
$leadcm = $row['leadcm'] ?? 0;
$leadc3m = $row['leadc3m'] ?? 0;
$leadwppl = $row['leadwppl'] ?? 0;
$leadmppl = $row['leadmppl'] ?? 0;
$lead3mppl = $row['lead3mppl'] ?? 0;
$leadwppc = $row['leadwppc'] ?? 0;
$leadmppc = $row['leadmppc'] ?? 0;
$lead3mppc = $row['lead3mppc'] ?? 0;


// ==========================================================================================Lead Type End Here===========================================================================================================



$contract = ['signed', 'sent'];

$sql = "SELECT
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY  AND `status` = 'signed' THEN 1 ELSE 0 END) AS leadw_contract,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY AND `status` = 'signed' THEN 1 ELSE 0 END) AS leadm_contract,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY AND `status` = 'signed' THEN 1 ELSE 0 END) AS lead3m_contract,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 WEEK) AND NOW() + INTERVAL 1 DAY AND `status` = 'sent' THEN 1 ELSE 0 END) AS leadcw_contract,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY AND `status` = 'sent' THEN 1 ELSE 0 END) AS leadcm_contract,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY AND `status` = 'sent' THEN 1 ELSE 0 END) AS leadc3m_contract
FROM contracts
WHERE company_id = $company_id";

$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

$leadw_contract = $row['leadw_contract'] ?? 0;
$leadm_contract = $row['leadm_contract'] ?? 0;
$lead3m_contract = $row['lead3m_contract'] ?? 0;
$leadcw_contract = $row['leadcw_contract'] ?? 0;
$leadcm_contract = $row['leadcm_contract'] ?? 0;
$leadc3m_contract = $row['leadc3m_contract'] ?? 0;

// ==========================================================================================Contract End Here===========================================================================================================



$sql = "SELECT
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() + INTERVAL 1 DAY THEN escrow_money ELSE 0 END) AS leadw_escrow,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 2 MONTH) AND NOW() + INTERVAL 1 DAY THEN escrow_money ELSE 0 END) AS leadm_escrow,
    SUM(CASE WHEN created_at BETWEEN DATE_SUB(NOW(), INTERVAL 3 MONTH) AND NOW() + INTERVAL 1 DAY THEN escrow_money ELSE 0 END) AS lead3m_escrow
FROM escrow
WHERE compnay_id = $company_id";

$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

$leadw_escrow = $row['leadw_escrow'] ?? 0;
$leadm_escrow = $row['leadm_escrow'] ?? 0;
$lead3m_escrow = $row['lead3m_escrow'] ?? 0;


// ==========================================================================================Escrow End Here===========================================================================================================




$sqlcsr = "select * from `campaign_success` WHERE company_id=$company_id ";
$rescsr = $mysqli->query($sqlcsr);

$sql = "SELECT
    COALESCE(SUM(CASE WHEN leads_under_drip = '1' THEN 1 ELSE 0 END), 0) AS leads_under_drip_true,
    COALESCE(SUM(CASE WHEN leads_under_drip = '0' THEN 1 ELSE 0 END), 0) AS leads_under_drip_false
FROM leads
WHERE company_id = $company_id";

$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

$trinc = $row['leads_under_drip_true'];
$fainc = $row['leads_under_drip_false'];


// ==========================================================================================Lead Under Drip End Here===========================================================================================================



$sqlvah = "select * from `va_hours` ";
$resvah = $mysqli->query($sqlvah);

// ===================================================================START of marketing Expense CHart=========================================================================================================


// $marketing_expense = $mysqli->query("SELECT COALESCE(DATE_FORMAT(m.month, '%b'), monthnames.monthname) AS monthname, IFNULL(SUM(amount), 0) AS amount
// FROM (
//     SELECT 1 AS month_seq, 'Jan' AS monthname UNION
//     SELECT 2 AS month_seq, 'Feb' AS monthname UNION
//     SELECT 3 AS month_seq, 'Mar' AS monthname UNION
//     SELECT 4 AS month_seq, 'Apr' AS monthname UNION
//     SELECT 5 AS month_seq, 'May' AS monthname UNION
//     SELECT 6 AS month_seq, 'June' AS monthname UNION
//     SELECT 7 AS month_seq, 'July' AS monthname UNION
//     SELECT 8 AS month_seq, 'Augt' AS monthname UNION
//     SELECT 9 AS month_seq, 'Sept' AS monthname UNION
//     SELECT 10 AS month_seq, 'Oct' AS monthname UNION
//     SELECT 11 AS month_seq, 'Nov' AS monthname UNION
//     SELECT 12 AS month_seq, 'Dec' AS monthname
// ) AS monthnames
// LEFT JOIN (
//     SELECT MONTH(created_at) AS month_seq, SUM(amount) AS amount
//     FROM marketing_expense
//     WHERE created_at >= DATE_FORMAT(CURRENT_DATE - INTERVAL 12 MONTH, '%Y-%m-01') 
//       AND created_at <= LAST_DAY(CURRENT_DATE)
//       AND company_id = $company_id
//     GROUP BY month_seq
// ) AS expenses ON monthnames.month_seq = expenses.month_seq
// LEFT JOIN (
//     SELECT 1 AS month_seq, 'January' AS month
// ) AS m ON monthnames.month_seq = m.month_seq
// WHERE monthnames.month_seq <= MONTH(NOW())
// GROUP BY monthnames.month_seq
// ORDER BY monthnames.month_seq ASC;");

$marketing_expense = $mysqli->query("SELECT DATE_FORMAT(created_at, '%b') AS month_name, SUM(amount) AS total_amount 
FROM marketing_expense 
WHERE created_at >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-01'), INTERVAL 12 MONTH) 
AND company_id = $company_id
GROUP BY DATE_FORMAT(created_at, '%Y-%m') 
ORDER BY created_at;");

$month = array();
$amount = array();

if ($marketing_expense->num_rows > 0) {
  foreach ($marketing_expense as $data) {
    $month[] = $data['month_name'];
    $amount[] = $data['total_amount'];
  }
} else {
  // If no data found, populate month array with empty values
  $month = array_fill(0, 12, '');
}

$current_month = array_pop($month);
array_push($month, $current_month);

$current_amount = array_pop($amount);
array_push($amount, $current_amount);

$month_json = json_encode($month);
$amount_json = json_encode($amount);





// ===================================================================END of marketing Expense CHart=========================================================================================================


$profitchart = $mysqli->query("SELECT COALESCE(DATE_FORMAT(p.created_at, '%M'), m.monthname) AS month_name, IFNULL(SUM(profit), 0) AS profit
FROM (
    SELECT 'January' AS monthname, 1 AS month_order UNION
    SELECT 'February' AS monthname, 2 AS month_order UNION
    SELECT 'March' AS monthname, 3 AS month_order UNION
    SELECT 'April' AS monthname, 4 AS month_order UNION
    SELECT 'May' AS monthname, 5 AS month_order UNION
    SELECT 'June' AS monthname, 6 AS month_order UNION
    SELECT 'July' AS monthname, 7 AS month_order UNION
    SELECT 'August' AS monthname, 8 AS month_order UNION
    SELECT 'September' AS monthname, 9 AS month_order UNION
    SELECT 'October' AS monthname, 10 AS month_order UNION
    SELECT 'November' AS monthname, 11 AS month_order UNION
    SELECT 'December' AS monthname, 12 AS month_order
) AS m
LEFT JOIN profit_chart p ON DATE_FORMAT(p.created_at, '%M') = m.monthname AND YEAR(p.created_at) = YEAR(NOW()) AND company_id = $company_id
GROUP BY month_name
ORDER BY m.month_order ASC;
");

foreach ($profitchart as $data) {
  $year[] = $data['month_name'];
  $sale[] = $data['profit'];
}

// ==========================================================================================profit chart End Here================================================================================================




// ============================================================START of multiline CHart===============================================================================================





$query = "SELECT DATE_FORMAT(created_at, '%b') AS `Month`, title, created_at, COUNT(*) AS `count` FROM telemarketing 
INNER JOIN types ON telemarketing.type_id = types.id WHERE created_at >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-01'), INTERVAL 11 MONTH)
 AND title IN ('sms-in', 'sms-out', 'call-in', 'call-out') AND company_id = $company_id
 GROUP BY DATE_FORMAT(created_at, '%Y-%m'), `Month`, title ORDER BY DATE_FORMAT(created_at, '%Y-%m')";

$result = $mysqli->query($query);
$monthYear = array();
$labels = array();
$chartData = array();

$colors = array(
  'sms-in' => '#2DC12A',
  'sms-out' => '#FF3838',
  'call-in' => '#FFC738',
  'call-out' => '#FF8B38'
);

while ($row = $result->fetch_assoc()) {
  $month = $row['Month'];
  $title = $row['title'];
  $count = $row['count'];

  // Store the data in an array grouped by title instead of month
  $chartData[$title][$month] = $count;

  $yearMonth = date('Y-m', strtotime($row['created_at']));
  if (!in_array($yearMonth, $monthYear)) {
    $monthYear[] = $yearMonth;
    $labels[] = $month; // Store the month name as it is from the query
  }
}

// Prepare the chart dataset
$datasets = array();

// Loop through the chart data and create datasets
foreach ($chartData as $title => $data) {
  $dataset = array(
    'label' => $title,
    'data' => array(),
    'lineTension' => 0,
    'fill' => false,
    'borderColor' => $colors[$title],
    'backgroundColor' => $colors[$title]
  );

  // Loop through the sorted months and add the count to the dataset
  foreach ($labels as $month) {
    $count = isset($data[$month]) ? $data[$month] : 0;
    $dataset['data'][] = $count;
  }

  $datasets[] = $dataset;
}





// ===================================================================END of multiline CHart=========================================================================================================










?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="main.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0;" />

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;700&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;500&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;600&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet">
  <title>360Synergy</title>
  <style>
    body {
      margin-top: 2%;
      /* overflow: hidden; */
    }
  </style>
</head>

<body>
  <div>
    <div class="grid-container">

      <div class="grid-item">

        <div class="fl-div1">Lead Temperature</div>
        <table class="stats-table">
          <thead>
            <tr>
              <th></th>
              <th class="tele_week">Week</th>
              <th class="tele_month">Month</th>
              <th class="tele_mmonth">3 Month</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="td_lab"><span class="circle" style="background-color:#FF8B38 ;"></span><span>Hot</span>
              </td>

              <td class="td_data"><?php echo $HotWeek ?></td>
              <td class="td_data"><?php echo $HotMonth ?></td>
              <td class="td_data"><?php echo $Hot3Month ?></td>
            </tr>
            <tr>
              <td class="td-1">
                <span class="circle" style="background-color:#FFC738 ;"></span><span>Warm</span>
              </td>
              <td class="td_data"><?php echo $WarmWeek ?></td>
              <td class="td_data"><?php echo $WarmMonth ?></td>
              <td class="td_data"><?php echo $Warm3Month ?></td>
            </tr>
            <tr>
              <td class="td-1">
                <span class="circle" style="background-color:#38ABFF ;"></span><span>Cold</span>
              </td>
              <td class="td_data"><?php echo $ColdWeek ?></td>
              <td class="td_data"><?php echo $ColdMonth ?></td>
              <td class="td_data"><?php echo $Cold3Month ?></td>
            </tr>
          </tbody>
        </table>



      </div>
      <div class="grid-item1">
        <div class="d-3">Appointments</div>
        <div>
          <table class="tb-c">
            <tr class="l1">
              <td class="cc">
                <div class="circle" style="background-color:#2DC12A;"></div>Completed
              </td>
              <td class="sp1"><?php echo $cinc ?></td>
            </tr>
            <tr class="l1">
              <td class="cc">
                <div class="circle" style="background-color: #FFC738;"></div><span>Pending</span>
              </td>
              <td class="sp2"><?php echo $pinc ?></td>
            </tr>
            <tr class="l1">
              <td class="cc">
                <div class="circle" style="background-color: #FF8B38;"></div><span>Due Order</span>
              </td>
              <td class="sp3"><?php echo $dinc ?></td>
            </tr>
            <tr class="l1">
              <td class="cc">
                <div class="circle" style="background-color: #FF3838;"></div><span>Cancelled</span>
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

        <table class="stats-table">
          <thead>
            <tr>
              <th></th>
              <th class="tele_week">Week</th>
              <th class="tele_month">Month</th>
              <th class="tele_mmonth">3 Months</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="td_lab">SMS<span class="label-green">In</span></td>
              <td class="td_data"><?php echo $smsinw ?></td>
              <td class="td_data"><?php echo $smsinm ?></td>
              <td class="td_data"><?php echo $smsin3m ?></td>
            </tr>
            <tr>
              <td class="td_lab">SMS<span class="label-red">Out</span></td>
              <td class="td_data"><?php echo $smsoutw ?></td>
              <td class="td_data"><?php echo $smsoutm ?></td>
              <td class="td_data"><?php echo $smsout3m ?></td>
            </tr>
            <tr>
              <td class="td_lab">Calls<span class="label-yellow">In</span></td>
              <td class="td_data"><?php echo $callinw ?></td>
              <td class="td_data"><?php echo $callinm ?></td>
              <td class="td_data"><?php echo $callin3m ?></td>
            </tr>
            <tr>
              <td class="td_lab">Calls<span class="label-orange">Out</span></td>
              <td class="td_data"><?php echo $calloutw ?></td>
              <td class="td_data"><?php echo $calloutm ?></td>
              <td class="td_data"><?php echo $callout3m ?></td>
            </tr>
          </tbody>
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
        <div class="contract_imgdata1">
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


        <p class="th-111">Marketing Expense (<?php echo date('Y') ?>)</p>




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
      <div class="contract_imgdata1">
        <table class="tb_sign1">
          <tr>
            <th class="th_sign1">1 Month</th>
          </tr>
          <tr>
            <td class="td_sign1">$<?php echo $leadw_escrow == "" ? 0 : $leadw_escrow ?></td>
          </tr>

        </table>
        <table class="tb_sign1">
          <tr>
            <th class="th_sign1">2 Month</th>
          </tr>
          <tr>
            <td class="td_sign1">$<?php echo $leadm_escrow == "" ? 0 : $leadm_escrow ?></td>

          </tr>

        </table>
        <table class="tb_sign1">
          <tr>
            <th class="th_sign1">3 Months</th>
          </tr>
          <tr>
            <td class="td_sign1">$<?php echo $lead3m_escrow == "" ? 0 : $lead3m_escrow ?></td>
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

      <div class="basicPackagesUL">
        <table class="tb_vahour">
          <thead>
            <tr>
              <th class="t_hash1">#</th>
              <th class="t_name1">Name</th>
              <th class="t_lead1">Leads</th>
            </tr>
          </thead>
          <tbody class="t_body">
            <?php
            $count = 0; // Initialize the count variable outside the loop

            while ($row = mysqli_fetch_assoc($rescsr)) :
              $count++; // Increment count for each row
            ?>

              <tr>
                <td>
                  <div class="csr_id"><?php echo $count ?></div>
                </td>
                <td class="csr_name">
                  <div><?php echo $row['campaign_name'] ?></div>
                </td>
                <td>
                  <div class="csr_lead"><?php echo $row['campaign_leads'] ?></div>
                </td>
              </tr>

            <?php
            endwhile;
            ?>

          </tbody>
        </table>
      </div>
    </div>

    <div class="item3">
      <div class="va_hour">VA’s Hours</div>

      <div class="basicPackagesUL">
        <table class="tb_vahour">
          <thead>
            <tr>
              <th class="t_hash">#</th>
              <th class="t_name">Name</th>
              <th class="w_chan">Week</th>
              <th class="m_chan">Month</th>
              <th class="m3_chan">3 Month</th>
            </tr>
          </thead>
          <tbody class="t_body">
            <?php
            $sql = "SELECT * FROM va_hours WHERE `company_id`=$company_id";
            $result = $mysqli->query($sql);
            $count = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              $count++;
              $va_id = $row['id'];
              $va_name = $row['name'];

              $week_hours = get_hours($va_id, "1 WEEK");
              $month_hours = get_hours($va_id, "1 MONTH");
              $three_month_hours = get_hours($va_id, "3 MONTH");
            ?>

              <tr>
                <td>
                  <div class="va_id"><?php echo $count ?></div>
                </td>
                <td class="va_name">
                  <div>
                    <?php echo $va_name ?>
                  </div>
                </td>
                <td>
                  <div class="va_week"><?php echo $week_hours ?></div>
                </td>
                <td>
                  <div class="va_month"><?php echo $month_hours ?></div>
                </td>
                <td>
                  <div class="va_3month"><?php echo $three_month_hours ?></div>
                </td>
              </tr>
            <?php
            }
            $mysqli->close();

            function get_hours($va_id, $interval)
            {
              global $mysqli;
              $sql = "SELECT working_hours AS `working_hours` FROM va_hours WHERE created_at BETWEEN DATE_SUB(NOW(), INTERVAL $interval) AND NOW() + INTERVAL 1 DAY AND id=$va_id";
              $result = $mysqli->query($sql);
              $row = mysqli_fetch_assoc($result);
              return $row['working_hours'] ?? 0;
            }
            ?>
          </tbody>
        </table>
      </div>

    </div>









  </div>

  </div>


  <div class="grid-container-last">
    <div class="grid-last">
      <div class="ll">Current Year Profit (<?php echo date('Y') ?>)</div>

      <!-- <div  id="chartContainer" ></div>  -->
      <!-- <img src="Chart3.png" class="img3"/> -->
      <canvas id="speedChart1"></canvas>
    </div>
  </div>


  <script>
    var data = {
      labels: <?php echo $month_json ?>,
      datasets: [{
        label: "Expenses",
        backgroundColor: '#FFC738',
        borderColor: "#FFC738",
        hoverBackgroundColor: "rgba(255,99,132,0.4)",
        hoverBorderColor: "rgba(255,99,132,1)",
        data: <?php echo $amount_json ?>,
      }]
    };

    var options = {
      maintainAspectRatio: false,
      scales: {
        yAxes: [{
          ticks: {
            min: 0,
            max: 2000
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




































  <!-- <script>
    var speedCanvas = document.getElementById("speedChart");


    var dataFirst = {
      label: "SMS In",
      data: [0, 0, 700, 600, 20, 755, 40, 150, 50, 800, 500, 0, 200, 900],
      lineTension: 0,
      fill: false,
      borderColor: '#2DC12A',
      backgroundColor: '#2DC12A'
    };

    var dataSecond = {
      label: "SMS Out",
      data: [0, 0, 50, 280, 700, 0, 400, 300, 100, 600, 450, 100],
      lineTension: 0,
      fill: false,
      borderColor: '#FF3838',
      backgroundColor: '#FF3838'
    };
    var dataThird = {
      label: "Calls In",
      data: [300, 550, 75, 250, 620, 750, 300, 150, 300, 400],
      lineTension: 0,
      fill: false,
      borderColor: '#FFC738',
      backgroundColor: '#FFC738'
    };

    var dataFourth = {
      label: "Calls Out",
      data: [260, 300, 690, 300, 780, 200, 990, 500, 750, 800, 730],
      lineTension: 0,
      fill: false,
      borderColor: '#FF8B38',
      backgroundColor: '#FF8B38'
    };
    var speedData = {
      labels: ["Jan", "Feb", "Mar", "April", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
      datasets: [dataFirst, dataSecond, dataThird, dataFourth]
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
      data: speedData,
      options: chartOptions
    });
  </script> -->
  <script>
    var speedCanvas = document.getElementById('speedChart');
    var data = {
      labels: <?php echo json_encode($labels) ?>,
      datasets: <?php echo json_encode($datasets) ?>
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
      data: data,
      options: chartOptions
    });
  </script>


</body>
</div>

</body>

</html>
<?php
//   } else {
//     return 0;
//     echo "No results found.";
//   }
// }

?>