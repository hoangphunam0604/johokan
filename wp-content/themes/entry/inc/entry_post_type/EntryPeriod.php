<?php
function getFirstDateEntry()
{
  global $wpdb;
  $first_data_query = $wpdb->prepare(
    "SELECT  post_date
    FROM $wpdb->posts 
    WHERE  
      $wpdb->posts.post_status = 'publish'
      AND $wpdb->posts.post_type = %s 
    ORDER BY post_date ASC
    LIMIT 0,1",
    'entry'
  );
  $first_data = $wpdb->get_row($first_data_query);
  return $first_data->post_date;
}
function listYears($from, $to = null)
{
  $start = (new DateTime($from))->format('Y');
  $end = date('Y');
  $list = [];
  for ($i = $end; $i >= $start; $i--) {
    $list[] = [
      'year' => $i,
      'year_name' => "{$i}年"
    ];
  }
  return $list;
}
function listMonthYears($from, $to = null)
{
  $start = (new DateTime($from))->modify('first day of this month');
  $end = (new DateTime($to ?: date('Y-m-d')))->modify('first day of next month');
  $interval = DateInterval::createFromDateString('1 month');
  $periods = new DatePeriod($start, $interval, $end);
  $list = [];
  foreach ($periods as $dt) {
    $list[] = [
      'month' =>  $dt->format("Y-m"),
      'month_name' =>  $dt->format("Y年m月"),
    ];
  }
  $col = array_column($list, "month");
  array_multisort($col, SORT_DESC, $list);
  return $list;
}

function listDateOfMonth($month)
{
  $start = (new DateTime($month))->modify('first day of this month');
  $end = (new DateTime($month))->modify('first day of next month');
  $interval = DateInterval::createFromDateString('1 day');
  $periods = new DatePeriod($start, $interval, $end);
  $list = [];
  foreach ($periods as $dt) {
    $list[] = $dt->format("Y年m月d");
  }

  return $list;
}
