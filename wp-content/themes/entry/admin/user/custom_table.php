<?php
add_filter('get_avatar', 'custom_avatar', 20, 2);
function custom_avatar($avatar, $user_id)
{
  $src =  get_the_author_meta('company_logo', $user_id) ?: get_stylesheet_directory_uri() . '/assets/img/default-logo.png';
  $avatar = sprintf("<img  src='%s' class='company_logo' height='65' width='150' loading='lazy' decoding='async' />", esc_url($src));
  return $avatar;
}


function new_modify_user_table($columns)
{
  $_colums = [];
  foreach ($columns as  $column => $label):
    $_colums[$column] = $label;
    if ($column == 'name')
      $_colums['company_active'] = '絞り込みで表示';
  endforeach;
  return $_colums;
}
add_filter('manage_users_columns', 'new_modify_user_table');

function user_has_role($user_id, $role_name)
{
  $user_meta = get_userdata($user_id);
  $user_roles = $user_meta->roles;
  return in_array($role_name, $user_roles);
}

function new_modify_user_table_row($val, $column_name, $user_id)
{
  switch ($column_name) {
    case 'company_active':
      if (!user_has_role($user_id, "sub-admin"))
        return "";
      $company_active = get_the_author_meta("company_active", $user_id);
      if (!current_user_can('administrator'))
        return $company_active == 1 ? "有効" : "無効";
      $checked = $company_active == 1 ? "checked" : "";
      $html = "<label class='switch-button r'>
          <input type='checkbox' class='checkbox switch_company_active' value='{$user_id}' name='company_active_{$user_id}' {$checked} />
          <div class='knobs'></div>
          <div class='layer'></div>
        </label>";
      return $html;
    default:
  }
  return $val;
}
add_filter('manage_users_custom_column', 'new_modify_user_table_row', 10, 3);
