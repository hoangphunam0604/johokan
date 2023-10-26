<?php

function store_entry()
{
  header('Content-Type: application/json; charset=utf-8');
  if (!check_valid_entry_form_data())
    exit(json_encode(['status'  =>  0, 'msg' =>  "Missing params"]));
  $new_entry = save_register_entry_form();
  if (!$new_entry)
    exit(json_encode(['status'  =>  0, 'msg' =>  "Can not save entry"]));

  exit(json_encode(['status'  =>  1, 'entry_id'  =>  $new_entry]));
}

function save_register_entry_form()
{


  $post_title = current_time("Y年n月j日 H:i:s") . " - "  . get_post_data('info_fullname') . " - " . get_post_data('info_phone');

  //Insert new post
  $new_post = wp_insert_post(array(
    'post_status' => 'publish',
    'post_type' => 'entry',
    'post_title'    =>  $post_title,
  ));
  if (!$new_post)
    return false;

  update_entry_data($new_post);
  $entry_id = current_time("Ymd") . $new_post;
  update_post_meta($new_post, 'entry_id', $entry_id);
  $sub_emails = array();
  $select_companies = array();
  $sub_ids = $_POST['companies'];
  $user_query = get_users(array('role' => 'sub-admin', 'include' =>  $sub_ids));

  if (!empty($user_query)) {
    foreach ($user_query as $user) {
      $email = get_the_author_meta('email', $user->ID);
      if ($email) {
        $sub_emails[]   = $email;
        $company_name = get_the_author_meta("company_business_name", $user->ID);
        $select_companies[] =  "■ {$company_name}";
      }
    }
  }

  $entry_form_options = get_option('entry_form_options');
  $from_email = $entry_form_options["from_email"];
  $from_name = $entry_form_options["from_name"];


  $headers = "From: " . $from_name . " <" . $from_email . ">";
  $additional = "-f " . $from_email;

  //send mail to user
  $customer_mail_to = sanitize_email(trim($_POST['info_email']));
  $customer_subject     =  $entry_form_options['customer_subject'];
  $customer_message     =  $entry_form_options['customer_message'];
  $customer_message  = replace_email_content($customer_message);
  $customer_message  = preg_replace("/\[entry_id\]/", $entry_id, $customer_message);
  $companies = "";
  if (!empty($select_companies)) {
    $companies = implode("\n", $select_companies);
  }

  $customer_message  = preg_replace("/\[companies\]/", $companies, $customer_message);

  //send mail to admin
  $admin_email_to   =  $entry_form_options['admin_to'];
  $admin_subject     =  $entry_form_options['admin_subject'];
  $admin_message     =  $entry_form_options['admin_message'];
  $admin_message  = replace_email_content($admin_message);
  $admin_message  = preg_replace("/\[entry_id\]/", $entry_id, $admin_message);

  $company_number = count($select_companies);
  $company_number = "{$company_number}社";
  if ($company_number == 1)
    $company_number = "御社のみ";
  $admin_message  = preg_replace("/\[company_number\]/", $company_number, $admin_message);

  wp_mail($customer_mail_to, $customer_subject, $customer_message, $headers);

  $admin_header = $headers;

  $admin_bcc =  $entry_form_options['admin_bcc'];
  if ($admin_bcc)
    $admin_header .= "\r\nBcc: " . $admin_bcc;

  wp_mail($admin_email_to, $admin_subject, $admin_message, $admin_header);

  //send mail to sub-admin
  if (!empty($sub_emails)) {
    $subadmin_subject     =  $entry_form_options['subadmin_subject'];
    foreach ($sub_emails as  $email)
      wp_mail($email, $subadmin_subject, $admin_message, $headers);
  }

  return $entry_id;
}

function update_entry_data($post_id)
{
  $fields = [
    'business_type',
    'location',
    'business_form',
    'experience',
    'receivable_amount',
    'receivable_quantity',
    'receivable_date',
    'receivable_notify',
    'receivable_company_name',
    'receivable_company_address',
    'receivable_company_year',
    'receivable_company_annual',
    'info_company_name',
    'info_duration',
    'info_founding_year',
    'info_annual_turnover',
    'info_industry',
    'info_fullname',
    'info_furigana_name',
    'info_email',
    'info_phone',
    'info_preferred_contact_date',
    'info_preferred_contact_type',
    'other',
    'companies'
  ];
  update_contact_post_fields($post_id, $fields);
}
function update_contact_post_fields($post_id, $fields)
{

  foreach ($fields as $field) :
    $value = get_post_data($field);
    update_post_meta($post_id, $field, $value);
  endforeach;
}
if (!function_exists('get_post_data')) {
  function get_post_data($field, $default = '')
  {
    if (isset($_POST[$field])) return $_POST[$field];
    return $default;
  }
}
function replace_email_content($content)
{
  $fields = [
    'business_type',
    'location',
    'business_form',
    'experience',
    'receivable_amount',
    'receivable_quantity',
    'receivable_date',
    'receivable_notify',
    'receivable_company_name',
    'receivable_company_address',
    'receivable_company_year',
    'receivable_company_annual',
    'info_company_name',
    'info_duration',
    'info_founding_year',
    'info_annual_turnover',
    'info_industry',
    'info_fullname',
    'info_furigana_name',
    'info_email',
    'info_phone',
    'info_preferred_contact_date',
    'info_preferred_contact_type',
    'other',
  ];

  foreach ($fields as $field) {
    $value = isset($_POST[$field]) ? $_POST[$field] : "";
    if (is_array($value))
      $value = implode(",", $value);
    if ($field == 'receivable_date' && $value) :
      $date = date_create($value);
      $value =  date_format($date, "Y年m月d日");
    endif;
    if ($field == 'info_preferred_contact_date' && $value) :
      $date = date_create($value);
      $value =  date_format($date, "Y年m月d日 H:i");
    endif;
    if ($field == 'info_preferred_contact_type' && $value) :
      $value = "（{$value}）";
    endif;
    $content  = preg_replace("/\[{$field}\]/", $value, $content);
  }
  return $content;
}

function get_email_content_customer()
{
}

function check_valid_entry_form_data(): bool
{

  $fields = [
    'business_type',
    'location',
    'business_form',
    'experience',
    'receivable_amount',
    'receivable_quantity',
    'receivable_date',
    'receivable_notify',
    /* 'receivable_company_name', */
    'receivable_company_address',
    'receivable_company_year',
    'receivable_company_annual',
    'info_company_name',
    'info_duration',
    'info_founding_year',
    'info_annual_turnover',
    'info_industry',
    'info_fullname',
    'info_furigana_name',
    'info_email',
    'info_phone',
    'accept',
    'companies'
  ];
  foreach ($fields as $field) {
    if (!isset($_POST[$field]) || !$_POST[$field]) :
      return false;
    endif;
  }

  return true;
}
