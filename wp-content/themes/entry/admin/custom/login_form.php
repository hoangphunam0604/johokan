<?php

function my_login_logo()
{
  wp_enqueue_style("johokan-admin", get_stylesheet_directory_uri() . "/admin/assets/css/style.css", array(), '1.0.0');
}
add_action('login_enqueue_scripts', 'my_login_logo');

add_filter('login_headertext', 'custom_login_headertext');
function custom_login_headertext()
{
  return "一括査定システム ログイン画面";
}
