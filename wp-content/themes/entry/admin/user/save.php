<?php

add_action('user_register', 'save_custom_user_profile_fields');
add_action('profile_update', 'save_custom_user_profile_fields');

function save_custom_user_profile_fields($user_id)
{


  if ($_POST["role"] !== "sub-admin")
    return;

  $location =  $_POST['location'];
  if ($_POST['radio_location'] == 1)
    $location =  ['全県'];
  update_user_meta($user_id, 'location', $location);
  $company_priority = isset($_POST['company_priority']) && $_POST['company_priority'] == "on" ? 1 : 0;
  update_user_meta($user_id, 'company_priority',  $company_priority);
  update_user_meta($user_id, 'company_logo',  $_POST['company_priority']);
  update_user_meta($user_id, 'company_logo',  $_POST['company_logo']);
  update_user_meta($user_id, 'company_business_name',  $_POST['company_business_name']);
  update_user_meta($user_id, 'company_description',  $_POST['company_description']);
  update_user_meta($user_id, 'business_type',  $_POST['business_type']);
  update_user_meta($user_id, 'business_form',  $_POST['business_form']);
  update_user_meta($user_id, 'experience',  $_POST['experience']);
  update_user_meta($user_id, 'receivable_amount_from',  $_POST['receivable_amount_from']);
  update_user_meta($user_id, 'receivable_amount_to',  $_POST['receivable_amount_to']);
  update_user_meta($user_id, 'receivable_notify',  $_POST['receivable_notify']);
}
