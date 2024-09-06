<?php

add_action('user_register', 'save_custom_user_profile_fields');
add_action('profile_update', 'save_custom_user_profile_fields');

function save_custom_user_profile_fields($user_id)
{


  if ($_POST["role"] !== "sub-admin")
    return;
  $company_active = isset($_POST['company_active']) && $_POST['company_active'] == "on" ? 1 : 0;
  $company_priority = isset($_POST['company_priority']) && $_POST['company_priority'] == "on" ? 1 : 0;
  update_user_meta($user_id, 'company_active',  $company_active);
  update_user_meta($user_id, 'company_priority',  $company_priority);
  update_user_meta($user_id, 'company_logo',  $_POST['company_logo']);
  update_user_meta($user_id, 'company_business_name',  $_POST['company_business_name']);
  update_user_meta($user_id, 'company_description',  $_POST['company_description']);
  update_user_meta($user_id, 'company_detail_url',  $_POST['company_detail_url']);

  $company_show_detail_url = isset($_POST['company_show_detail_url']) && $_POST['company_show_detail_url'] == "on" ? 1 : 0;
  update_user_meta($user_id, 'company_show_detail_url',  $company_show_detail_url);

  $rules = [];
  $_rules = $_POST['rules'];
  if (is_array($_rules) && !empty($_rules)) :
    foreach ($_rules as $rule) :
      $location =  isset($rule['location']) ? $rule['location'] : [];
      if ($rule['radio_location'] == 1)
        $location =  ['全県'];
      $business_type = $rule['business_type'] ?: [];
      $business_form = $rule['business_form'] ?: [];
      $experience = $rule['experience'] ?: [];
      $receivable_amount_from = $rule['receivable_amount_from'] ?: [];
      $receivable_amount_to = $rule['receivable_amount_to'] ?: [];
      $receivable_notify = $rule['receivable_notify'] ?: [];
      $rules[] = [
        'business_type' => $business_type,
        'location' => $location,
        'business_form' => $business_form,
        'experience'  => $experience,
        'receivable_amount_from'  => $receivable_amount_from,
        'receivable_amount_to'  => $receivable_amount_to,
        'receivable_notify' => $receivable_notify,
      ];
    endforeach;
  endif;
  update_user_meta($user_id, 'rules', $rules);
}



add_action('wp_ajax_change_company_active', 'change_company_active');
add_action('wp_ajax_nopriv_change_company_active', 'change_company_active');

function change_company_active()
{
  if ($_SERVER['REQUEST_METHOD'] != 'POST')
    return_json(['status' => false, 'msg' => 'Method not allow']);
  $user_id = $_POST['user_id'];
  $company_active = filter_var($_POST['company_active'], FILTER_VALIDATE_BOOLEAN);
  update_user_meta($user_id, 'company_active',  $company_active);
  return_json(['status' => true, 'company_active'  =>  $company_active]);
}

function return_json(array $data): void
{
  exit(json_encode($data));
}
