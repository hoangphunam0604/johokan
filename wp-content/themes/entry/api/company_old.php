<?php

function get_companies()
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

  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(['companies'  =>  $companies]);
  exit;
}
