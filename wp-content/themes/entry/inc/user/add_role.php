<?php
add_action('init', 'register_sub_admin_role', 11);
function register_sub_admin_role()
{
  add_role(
    'sub-admin',
    "フォーム副管理"
  );
}


add_action('init', 'reload_capabilities_role');

function reload_capabilities_role()
{
  $capabilities = [
    "edit_entry",
    "read_entry",
    "delete_entry",
    "edit_entries",
    "edit_others_entries",
    "publish_entries",
    "read_private_entries",
    "read_entry",
    "delete_entries",
    "delete_private_entries",
    "delete_published_entries",
    "delete_others_entries",
    "edit_private_entries",
    "edit_published_entries",
    "create_entries"
  ];
  $administrator = get_role('administrator');
  $sub_admin = get_role('sub-admin');
  foreach ($capabilities as $cap) {
    $administrator->add_cap($cap);
  }
  $administrator->remove_cap('create_entries');


  if ($sub_admin = get_role('sub-admin')) :
    foreach ($capabilities as $cap) {
      $sub_admin->add_cap($cap);
    }
    $sub_admin->remove_cap('create_entries');
    $sub_admin->remove_cap('delete_entry');
    $sub_admin->remove_cap('list_users');
    $sub_admin->add_cap('read');
  endif;
}
