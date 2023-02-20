<?php
add_action('wp_ajax_get_statistics_by_year', 'get_statistics_by_year');
add_action('wp_ajax_nopriv_get_statistics_by_year', 'get_statistics_by_year');

add_action('wp_ajax_get_statistics_by_week', 'get_statistics_by_week');
add_action('wp_ajax_nopriv_get_statistics_by_week', 'get_statistics_by_week');

add_action('wp_ajax_get_statistics_by_month', 'get_statistics_by_month');
add_action('wp_ajax_nopriv_get_statistics_by_month', 'get_statistics_by_month');

function get_statistics_by_year()
{
  global $wpdb;

  check_user_statistics();

  $year =  get_statistics_query('year');
  $user_id =  get_user_id();

  if ($user_id) :
    $query_data_in_year = $wpdb->prepare(
      "SELECT  MONTH(post_date) as month, COUNT(*) as total
        FROM $wpdb->posts 
        INNER JOIN $wpdb->postmeta ON ($wpdb->postmeta.post_id = $wpdb->posts.ID) 
        WHERE  
            $wpdb->posts.post_status = 'publish'
            AND $wpdb->posts.post_type = %s 
            AND YEAR($wpdb->posts.post_date) = %d
            AND $wpdb->postmeta.meta_key ='companies'
            AND $wpdb->postmeta.meta_value LIKE '%\"%d\"%'
        GROUP BY month ASC ORDER BY post_date ASC",
      'entry',
      $year,
      $user_id
    );
  else :
    $query_data_in_year = $wpdb->prepare(
      "SELECT  MONTH(post_date) as month, COUNT(*) as total
        FROM $wpdb->posts 
        WHERE  
            $wpdb->posts.post_status = 'publish'
            AND $wpdb->posts.post_type = %s
            AND YEAR($wpdb->posts.post_date) = %d
        GROUP BY month  ORDER BY post_date ASC",
      'entry',
      $year
    );
  endif;


  $data_in_year = $wpdb->get_results($query_data_in_year);
  $data_results = [];

  $total = 0;
  foreach ($data_in_year as $month) {
    $data_results[$month->month] = $month->total;
    $total += $month->total;
  }

  $labels = [];
  $data = [];
  for ($i = 1; $i <= 12; $i++) {
    $labels[] = "{$i}月";
    $data[] = isset($data_results[$i]) ? $data_results[$i] : 0;
  }
  $title = "{$year}年の月";
  response_statistics($labels, $title, $data, $total);
}

function get_statistics_by_week()
{

  global $wpdb;

  check_user_statistics();
  $user_id =  get_user_id();

  $current_week_start = (new DateTime(date('Y-m-d')))->modify("Last Sunday");
  $current_week_end = (new DateTime(date('Y-m-d')))->modify("Next Saturday");

  $last_week_start = (new DateTime(date('Y-m-d')))->modify("-1 week")->modify("Last Sunday");
  $last_week_end = (new DateTime(date('Y-m-d')))->modify("-1 week")->modify("Next Saturday");



  if ($user_id) :
    $query_week = "SELECT DAYOFWEEK(post_date) as date_of_week,COUNT(*) as total
    FROM $wpdb->posts 
    INNER JOIN $wpdb->postmeta ON ($wpdb->postmeta.post_id = $wpdb->posts.ID) 
    WHERE  
        $wpdb->posts.post_status = 'publish'
        AND $wpdb->posts.post_type = %s
        AND $wpdb->postmeta.meta_key ='companies'
        AND $wpdb->postmeta.meta_value LIKE '%\"%d\"%'
        AND $wpdb->posts.post_date BETWEEN %s AND %s
    GROUP BY date_of_week 
    ORDER BY date_of_week ASC";
    $current_week_query = $wpdb->prepare($query_week, 'entry', $user_id, $current_week_start->format('Y-m-d 00:00:00'),    $current_week_end->format('Y-m-d 23:59:59'));
    $last_week_query = $wpdb->prepare($query_week, 'entry', $user_id, $last_week_start->format('Y-m-d 00:00:00'),    $last_week_end->format('Y-m-d 23:59:59'));

  else :
    $query_week = "SELECT DAYOFWEEK(post_date) as date_of_week, COUNT(*) as total
    FROM $wpdb->posts 
    WHERE  
        $wpdb->posts.post_status = 'publish'
        AND $wpdb->posts.post_type = %s
        AND $wpdb->posts.post_date BETWEEN %s AND %s
    GROUP BY date_of_week 
    ORDER BY date_of_week ASC";

    $current_week_query = $wpdb->prepare($query_week, 'entry',  $current_week_start->format('Y-m-d 00:00:00'),    $current_week_end->format('Y-m-d 23:59:59'));
    $last_week_query = $wpdb->prepare($query_week, 'entry',  $last_week_start->format('Y-m-d 00:00:00'),    $last_week_end->format('Y-m-d 23:59:59'));
  endif; //if ($user_id) :

  $current_week_results = $wpdb->get_results($current_week_query);
  $last_week_results = $wpdb->get_results($last_week_query);

  $labels = ["日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日"];
  $total = 0;
  $current_week_total = 0;
  $last_week_total = 0;

  $current_week_result_array = [];
  $last_week_result_array = [];

  foreach ($current_week_results as $day) {
    $current_week_result_array[$day->date_of_week] = $day->total;
    $current_week_total += $day->total;
    $total += $day->total;
  }

  foreach ($last_week_results as $day) {
    $last_week_result_array[$day->date_of_week] = $day->total;
    $last_week_total += $day->total;
    $total += $day->total;
  }

  $current_week_data = [];
  $last_week_data = [];
  foreach ($labels as $key => $label) :
    $current_week_data[] = isset($current_week_result_array[$key + 1]) ? $current_week_result_array[$key + 1] : 0;
    $last_week_data[] = isset($last_week_result_array[$key + 1]) ? $last_week_result_array[$key + 1] : 0;
  endforeach;

  $current_week_total_format = number_format($current_week_total);
  $last_week_total_format = number_format($last_week_total);
  $data = [
    'labels'  =>  $labels,
    'datasets'  =>   [
      [
        'label' => "今週",
        'backgroundColor' => ['#fd6468'],
        'data'  =>  $current_week_data,
      ],
      [
        'label' => "先週",
        'backgroundColor' => ['#369694'],
        'data'  =>  $last_week_data,
      ]
    ]
  ];
  $response = [
    'total' =>  number_format($total),
    'current_week_query'  =>  $current_week_query,
    'last_week_query'  =>  $last_week_query,
    'chart' =>  [
      'type'  =>  'bar',
      'data'  =>  $data
    ]
  ];

  exit(json_encode($response));
}


function get_statistics_by_month()
{
  global $wpdb;
  check_user_statistics();
  $month =  get_statistics_query('month');
  $user_id =  get_user_id();
  $first_day_of_this_month = (new DateTime($month))->modify('first day of this month');
  $last_day_of_this_month = (new DateTime($month))->modify('last day of this month');
  if ($user_id) :
    $query_string = "SELECT DAYOFMONTH(post_date) as date_of_month,COUNT(*) as total
    FROM $wpdb->posts 
    INNER JOIN $wpdb->postmeta ON ($wpdb->postmeta.post_id = $wpdb->posts.ID) 
    WHERE  
        $wpdb->posts.post_status = 'publish'
        AND $wpdb->posts.post_type = %s
        AND $wpdb->postmeta.meta_key ='companies'
        AND $wpdb->postmeta.meta_value LIKE '%\"%d\"%'
        AND $wpdb->posts.post_date BETWEEN %s AND %s
    GROUP BY date_of_month 
    ORDER BY date_of_month ASC";
    $query_prepare = $wpdb->prepare($query_string, 'entry', $user_id, $first_day_of_this_month->format('Y-m-d 00:00:00'),    $last_day_of_this_month->format('Y-m-d 23:59:59'));

  else :
    $query_string = "SELECT DAYOFMONTH(post_date) as date_of_month, COUNT(*) as total
    FROM $wpdb->posts 
    WHERE  
        $wpdb->posts.post_status = 'publish'
        AND $wpdb->posts.post_type = %s
        AND $wpdb->posts.post_date BETWEEN %s AND %s
    GROUP BY date_of_month 
    ORDER BY date_of_month ASC";
    $query_prepare = $wpdb->prepare($query_string, 'entry',  $first_day_of_this_month->format('Y-m-d 00:00:00'),    $last_day_of_this_month->format('Y-m-d 23:59:59'));
  endif; //if ($user_id) :
  $results = $wpdb->get_results($query_prepare);
  $total = 0;
  $result_array = [];
  foreach ($results as $item) {
    $result_array[$item->date_of_month] = $item->total;
    $total += $item->total;
  }

  $labels = listDateOfMonth($month);
  $data = [];
  foreach ($labels as $key => $label) {
    $data[] = isset($result_array[$key + 1]) ? $result_array[$key + 1] : 0;
  }
  $title = "{$first_day_of_this_month->format('Y年m月')}の月";
  response_statistics($labels, $title, $data, $total);
}

function response_statistics($labels, $title, $data, $total)
{
  $response = [
    'total' =>  number_format($total),
    'chart' =>  [
      'type'  =>  'bar',
      'data'  =>  [
        'labels'  =>  $labels,
        'datasets'  =>   [
          [
            'label' => $title,
            'backgroundColor' => color_list(count($data)),
            'data'  =>  $data,
          ]
        ]
      ]
    ]
  ];
  exit(json_encode($response));
}

function check_user_statistics()
{
  header('Content-type:application/json');
  // not user login in
  if (!is_user_logged_in())
    exit(json_encode(array('status' => 0, 'error' => "login required!")));
  $user = wp_get_current_user();
  // current user is not administrator or sub-admin
  if (!in_array('administrator', (array) $user->roles) && !in_array('sub-admin', (array) $user->roles))
    exit(json_encode(array('status' => 0, 'error' => "permission denied!")));
}

function get_statistics_query($field, $default = '')
{
  if (isset($_GET[$field]) && $_GET[$field])
    return $_GET[$field];
  return $default;
}

function get_user_id()
{
  $user_id =  get_statistics_query('user_id');
  $user = wp_get_current_user();
  // current user sub-admin
  if (in_array('sub-admin', (array) $user->roles))
    $user_id  =  $user->ID;

  return $user_id;
}

function color_list($slice = 31)
{
  $colors = [
    '#e17d60',
    '#85dcba',
    '#8b8c94',
    '#c38d9e',
    '#41b4a4',
    '#7a86ae',
    '#86d2c1',
    '#ae1f6c',
    '#ff5668',
    '#b2aee3',
    '#8d891a',
    '#00a5a1',
    '#afb463',
    '#8b0000',
    '#254367',
    '#6b4b4b',
    '#000000',
    '#c14a4a',
    '#212ed8',
    '#f1ff14',
    '#00ff00',
    '#ff8800',
    '#00ffff',
    '#a064ff',
    '#61f1fd',
    '#3e2974',
    '#af1acc',
    '#e36c21',
    '#e9a7b3',
    '#6776a5',
    '#49a49e',
  ];
  return array_slice($colors, 0, $slice);
}
