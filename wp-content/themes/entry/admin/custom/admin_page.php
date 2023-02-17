<?php

function admin_default_page()
{
  return admin_url('edit.php?post_type=entry');
}

add_filter('login_redirect', 'admin_default_page');

function redirect_sub_admin_to_home()
{
  $user = wp_get_current_user();
  if (!in_array('administrator', (array) $user->roles)) {
    wp_redirect(home_url());
    exit;
  }
}
