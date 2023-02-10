<?php
/*
Plugin Name: Entry Manager
Author: Hoàng Phú Nam
Author URI: https://fb.me/hoangphunam/
*/
require_once(__DIR__ . '/setting.php');
require_once(__DIR__ . '/entry_post_type/init.php');
require_once(__DIR__ . '/page-option.php');
require_once(__DIR__ . '/user/init.php');

add_action('admin_menu', 'custom_admin_menu');
function custom_admin_menu()
{
  remove_menu_page('index.php'); //Dashboard
  remove_menu_page('edit.php'); // Posts
  remove_menu_page('upload.php'); // Media
  remove_menu_page('edit.php?post_type=page'); // Pages
  remove_menu_page('edit-comments.php'); // Comments
  $user = wp_get_current_user();

  // hidden without admin
  if (!in_array('administrator', (array) $user->roles)) {
    remove_menu_page('themes.php'); // themes
    remove_menu_page('plugins.php'); // plugins/* 
    //remove_menu_page('users.php'); // users */
    remove_menu_page('tools.php'); // tools
    remove_menu_page('options-general.php'); // options-general
  }
}
