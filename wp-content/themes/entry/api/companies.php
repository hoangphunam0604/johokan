<?php

add_action("pre_user_query", function ($query) {
  if ("rand" == $query->query_vars["orderby"]) {
    $query->query_orderby = str_replace("user_login", "RAND()", $query->query_orderby);
  }
});

function get_companies()
{
  $priority_companies = get_companies_by_rules(1);
  $random_companies = get_companies_by_rules(0);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(['priority'  =>  $priority_companies, 'other' =>  $random_companies]);
  exit;
}
function get_companies_by_rules($priority)
{
  $sub_admin_query = new WP_User_Query([
    'role'  =>  'sub-admin',
    'orderby' =>  'rand',
    'number' => -1,
    'meta_query'  =>  [
      [
        "key" =>  "company_priority",
        "value" =>  $priority
      ],
      [
        "key" =>  "company_active",
        "value" =>  true
      ]
    ]
  ]);
  $users = $sub_admin_query->get_results();
  $companies = getCompaniesPassAnyRule($users);
  return $companies;
}
function getCompaniesPassAnyRule($users)
{
  $companies = [];
  foreach ($users as $user) :
    $user_id = $user->ID;
    $company_business_name =  get_the_author_meta('company_business_name', $user_id);
    if (checkRules($user_id)) {
      $companies[]    =  get_company($user_id);
    }
  endforeach;
  return $companies;
}
function checkRules($user_id)
{
  $rules = get_the_author_meta('rules', $user_id);

  if (!is_array($rules) || empty($rules)) return false;
  foreach ($rules as $rule) {
    if (checkRule($rule)) return true;
  }
  return false;
}
function checkRule($rule)
{
  $business_type = sanitize_text_field($_POST['business_type']);
  $location = sanitize_text_field($_POST['location']);
  $business_form = sanitize_text_field($_POST['business_form']);
  $experience = sanitize_text_field($_POST['experience']);
  $receivable_amount = sanitize_text_field($_POST['receivable_amount']);
  $receivable_notify = sanitize_text_field($_POST['receivable_notify']);
  return
    in_array($business_type, $rule['business_type']) &&
    (in_array('全県', $rule['location'])  || in_array($location, $rule['location'])) &&
    in_array($business_form, $rule['business_form']) &&
    in_array($experience, $rule['experience']) &&
    $receivable_amount >= $rule['receivable_amount_from']    &&
    $receivable_amount  <= $rule['receivable_amount_to']  &&
    in_array($receivable_notify, $rule['receivable_notify']);
}

function get_company($user_ID)
{
  $src =  get_the_author_meta('company_logo', $user_ID) ?: get_stylesheet_directory_uri() . '/assets/img/default-logo.png';
  return [
    'id'  => (int)$user_ID,
    'logo'  => $src,
    'name'  => get_the_author_meta('company_business_name', $user_ID),
    'description'  => nl2br(get_the_author_meta('company_description', $user_ID)),
    'detail_url'  => get_the_author_meta('company_detail_url', $user_ID),
    'show_detail_url'  => !!get_the_author_meta('company_show_detail_url', $user_ID)
  ];
}
/* 
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

function get_companies_by_rules_meta_query($priority = 0)
{

  $business_type = sanitize_text_field($_POST['business_type']);
  $location = sanitize_text_field($_POST['location']);
  $business_form = sanitize_text_field($_POST['business_form']);
  $experience = sanitize_text_field($_POST['experience']);
  $receivable_amount = sanitize_text_field($_POST['receivable_amount']);
  $receivable_notify = sanitize_text_field($_POST['receivable_notify']);

  $meta_query = [
    [
      "key" =>  "company_priority",
      "value" =>  $priority
    ],
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
 */