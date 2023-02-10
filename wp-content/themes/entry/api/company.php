<?php

add_action("pre_user_query", function ($query) {
  if ("rand" == $query->query_vars["orderby"]) {
    $query->query_orderby = str_replace("user_login", "RAND()", $query->query_orderby);
  }
});

function get_companies()
{
  $max_company = 6;
  $companies = get_companies_by_rules();

  if (count($companies) < $max_company) {
    $limit = $max_company - count($companies);
    $random_companies = get_companies_by_random_exclude_companies($companies, $limit);
    $companies = array_merge($companies, $random_companies);
  }
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(['companies'  =>  $companies]);
  exit;
}

function get_companies_by_rules()
{
  $meta_query = get_companies_by_rules_meta_query();

  $sub_admin_query = new WP_User_Query(['role'  =>  'sub-admin',  'orderby' =>  'rand', 'number' => 6,  'meta_query'  =>  $meta_query]);
  $users = $sub_admin_query->get_results();

  $companies = [];
  foreach ($users as $user) :
    $companies[]    =  get_company($user->ID);
  endforeach;
  return $companies;
}

function get_companies_by_random_exclude_companies($companies, $limit)
{
  $excludes = array_map(function ($company) {
    return $company['id'];
  }, $companies);

  $sub_admin_query = new WP_User_Query(['role'  =>  'sub-admin', 'exclude' => $excludes,  'orderby' =>  'rand', 'number' =>  $limit]);
  $users = $sub_admin_query->get_results();

  $companies = [];
  foreach ($users as $user) :
    $companies[]    =  get_company($user->ID);
  endforeach;
  return $companies;
}


function get_company($user_ID)
{
  $src =  get_the_author_meta('company_logo', $user_ID) ?: get_stylesheet_directory_uri() . '/assets/img/default-logo.png';
  return [
    'id'  => (int)$user_ID,
    'logo'  => $src,
    'name'  => get_the_author_meta('company_business_name', $user_ID),
    'description'  => nl2br(get_the_author_meta('company_description', $user_ID))
  ];
}

function get_companies_by_rules_meta_query()
{

  $business_type = sanitize_text_field($_POST['business_type']);
  $location = sanitize_text_field($_POST['location']);
  $business_form = sanitize_text_field($_POST['business_form']);
  $experience = sanitize_text_field($_POST['experience']);
  $receivable_amount = sanitize_text_field($_POST['receivable_amount']);
  $receivable_notify = sanitize_text_field($_POST['receivable_notify']);
  $meta_query = [
    [
      "key" =>  "business_type",
      "value" =>  $business_type
    ],
    [
      "key" =>  "business_form",
      "value" =>  $business_form
    ],
    [
      "key" =>  "experience",
      "value" =>  $experience
    ],
    [
      "key" =>  "receivable_notify",
      "value" =>  $receivable_notify
    ],
    [
      "key" =>  "receivable_amount_from",
      "value" =>  $receivable_amount,
      "compare" =>  "<="
    ],
    [
      "key" =>  "receivable_amount_to",
      "value" =>  $receivable_amount,
      "compare" =>  ">="
    ],

    [
      'relation'  =>  'OR',
      [
        "key" =>  "location",
        "value" =>  $location,
        'compare'   => 'LIKE'
      ],
      [
        "key" =>  "location",
        "value" =>  '全県',
        'compare'   => 'LIKE'
      ]
    ],
  ];
  return $meta_query;
}
