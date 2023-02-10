<?php
require_once(__DIR__ . "/inc/init.php");

/* add_action('init', 'required_login_user', 10);
 function required_login_user()
{
  if (!is_user_logged_in() && $GLOBALS['pagenow'] !== 'wp-login.php' && $_SERVER['REQUEST_METHOD'] !== "POST" && !isset($_POST['entry_client']) && $_POST['entry_client'] != "mumbai-central") {
    wp_redirect(wp_login_url());
    exit;
  }
}  */
/* 
add_action('init', 'redirect_sub_admin_to_home', 20);

function redirect_sub_admin_to_home()
{
  $user = wp_get_current_user();
  if (!in_array('administrator', (array) $user->roles)) {
    wp_redirect(home_url());
    exit;
  }
} */

add_action('init', 'request_register_entry_form');

function request_register_entry_form()
{
  if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['entry_client']) && $_POST['entry_client'] = "mumbai-central") {

    if (isset($_POST['action']) && $_POST['action'] == 'get_list_sub_admin')
      get_list_sub_admin();

    if (!check_valid_entry_form_data())
      exit(json_encode(['status'  =>  0, 'msg' =>  "Missing params"]));

    if (!save_register_entry_form())
      exit(json_encode(['status'  =>  0, 'msg' =>  "Can not save entry"]));

    exit(json_encode(['status'  =>  1]));
  }


  return;
}

function get_list_sub_admin()
{

  $user_query = get_users(array('role' => 'sub-admin', 'number'  => -1));
/* 
  $_business_type = sanitize_text_field($_POST['business_type']);
  $_location = sanitize_text_field($_POST['location']);
  $_accounts_receivable = sanitize_text_field($_POST['accounts_receivable']);
  $_company_account = sanitize_text_field($_POST['company_account']);
  $_notification = sanitize_text_field($_POST['notification']);
  $_experience = sanitize_text_field($_POST['experience']); */
  $companies = [];
  if (!empty($user_query)) {

    foreach ($user_query as $user) {
     /*  $business_type = get_the_author_meta('business_type', $user->ID);

      if (!$business_type || $_business_type != $business_type)
        continue;

      $location = (array) get_the_author_meta('location', $user->ID);
      if ($location[0] != "全県" && !in_array($_location, $location))
        continue;

      $accounts_receivable = get_the_author_meta('accounts_receivable', $user->ID);
      if ($_accounts_receivable != $accounts_receivable)
        continue;
      $company_account = get_the_author_meta('company_account', $user->ID);
      if ($_company_account != $company_account)
        continue;

      $notification = get_the_author_meta('notification', $user->ID);
      if ($_notification != $notification)
        continue;
      $experience = get_the_author_meta('experience', $user->ID);
      if ($_experience != $experience)
        continue;
         */
      $src =  get_the_author_meta('company_logo', $user->ID) ?: get_stylesheet_directory_uri() . '/assets/img/default-logo.png';
      $companies[]    =  [
        'id'  => (int)$user->ID,
        'logo'  => $src,
        'name'  => get_the_author_meta('company_business_name', $user->ID),
        'description'  => nl2br(get_the_author_meta('company_description', $user->ID))
      ];
    }
  }
  echo json_encode(['companies'  =>  $companies]);
  exit;
}

function save_register_entry_form()
{
  $content = "";
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
    'info_furiname',
    'info_email',
    'info_phone',
    'info_preferred_contact_date',
    'info_preferred_contact_type',
    'info_other',
  ];
  
  $meta_input = [];
  foreach ($fields as  $field) :
    $value = $field == 'info_other' ? sanitize_textarea_field($_POST[$field]) : sanitize_text_field($_POST[$field]);
    $meta_input[$field] = $value;
  endforeach;

  $sub_emails = array();
  $sub_ids = $_POST['companies'];
  $user_query = get_users(array('role' => 'sub-admin', 'include' =>  $sub_ids));


  if (!empty($user_query)) {

    foreach ($user_query as $user) {
      $user_meta = get_user_meta($user->ID);
      if (!empty($user_meta)) {
        /* 
        $business_type = $user_meta['business_type'][0];
        if (!empty($business_type) && $meta_input['business_type'] != $business_type)
          continue;

        $location = unserialize($user_meta['location'][0]);
        if (
          empty($location) ||
          (!empty($location) && $location[0] != "全県" && !in_array($meta_input['location'], $location))
        ) continue;

        $accounts_receivable = $user_meta['accounts_receivable'][0];
        if (!empty($accounts_receivable) && $meta_input['accounts_receivable'] != $accounts_receivable)
          continue;

        $company_account = $user_meta['company_account'][0];
        if (!empty($company_account) && $meta_input['company_account'] != $company_account)
          continue;

        $notification = $user_meta['notification'][0];
        if (!empty($notification) && $meta_input['notification'] != $notification)
          continue;

        $experience = $user_meta['experience'][0];
        if (!empty($experience) && $meta_input['experience'] != $experience)
          continue;
        */
        $sub_emails[]   = $user_meta['email'][0];
        /* $sub_ids[]    =  (string)$user->ID; */
      }
    }
  }
  $post_title = current_time("Y年n月j日 H:i:s") . " - " . $meta_input['company_name'] . " - " . $meta_input['contact_name'] . " - " . $meta_input['phone_number'];
  $post_name = sanitize_title(current_time("YnjHis") . $meta_input['phone_number']);
  $post_content_filtered = json_encode($sub_ids);
  $post_content = json_encode($meta_input, JSON_UNESCAPED_UNICODE);

  //Insert new post
  $new_post = wp_insert_post(array(
    'post_status' => 'publish',
    'post_type' => 'entry',
    'post_title'    =>  $post_title,
    'post_name'    =>  $post_name,
    'post_name' =>  $post_name,
    'post_content_filtered'  =>   $post_content_filtered,
    'post_content'  =>  $post_content
  ));
  if (!$new_post)
    return false;

  $entry_form_options = get_option('entry_form_options');
  $from_email = $entry_form_options["from_email"];
  $from_name = $entry_form_options["from_name"];


  $headers = "From: " . $from_name . " <" . $from_email . ">";
  $additional = "-f " . $from_email;

  //send mail to user
  $customer_mail_to = sanitize_email(trim($_POST['email']));
  $customer_subject     =  $entry_form_options['customer_subject'];
  $customer_message     =  $entry_form_options['customer_message'];
  $customer_message  = preg_replace("/{content}/", $content, $customer_message);

  //send mail to admin
  $admin_email_to   =  $entry_form_options['admin_to'];
  $admin_subject     =  $entry_form_options['admin_subject'];
  $admin_message     =  $entry_form_options['admin_message'];
  $admin_message  = preg_replace("/{content}/", $content, $admin_message);

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

  return true;
}

function check_valid_entry_form_data(): bool
{
  $fields = [
    'business_type', 'location',
    'accounts_receivable', 'company_account', 'notification', 'experience', 'yearly_quotient', 'establishment',
    'amount_of_accounts', 'payment_date', 'factoring', 'company_name', 'industry', 'contact_name', 'email',
    'phone_number', 'mobile_number', 'other', 'accept','companies'
  ];
  foreach ($fields as $field) {
    if (!isset($_POST[$field]) || !$_POST[$field])
      return false;
  }

  return true;
}

add_filter("wp_new_user_notification_email", "custom_wp_new_user_notification_email", 20, 3);

function custom_wp_new_user_notification_email($wp_new_user_notification_email, $user, $blogname)
{
  $wp_new_user_notification_email['subject'] = __('[%s]  ユーザー情報を登録いたしました');

  $key = get_password_reset_key($user);

  $message  = sprintf(__('ユーザー名: %s'), $user->user_login) . "\r\n\r\n";
  $message  .= "ユーザー登録が完了いたしました。\r\n\r\n";
  $message  .= "==================================================\r\n";
  $message  .= "・パスワードを再設定するには以下のアドレスへ移動してください。\r\n";
  $message  .= "　　↓↓↓↓↓\r\n";
  $message  .= "「パスワード再設定ページ」\r\n";
  $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login') . "\r\n\r\n\r\n";
  $message  .= "・ログインの際は以下のページより、メールアドレスと設定したパスワードを入力しお進みください。\r\n";
  $message  .= "　　↓↓↓↓↓\r\n";
  $message  .= "「ログインページ」\r\n";
  $message .= wp_login_url() . "\r\n";
  $message  .= "==================================================\r\n\r\n";
  $message  .= "※本メールは自動送信メールです。\r\n";
  $message  .= "※ログインIDおよびパスワードは、大切に保管くださいませ。\r\n";
  $wp_new_user_notification_email['message'] = $message;

  return $wp_new_user_notification_email;
}

function admin_default_page()
{
  return admin_url('edit.php?post_type=entry');
}

add_filter('login_redirect', 'admin_default_page');
