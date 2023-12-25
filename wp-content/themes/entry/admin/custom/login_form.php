<?php

function my_login_logo()
{
  wp_enqueue_style("johokan-admin", get_stylesheet_directory_uri() . "/admin/assets/css/style.css", array(), '1.0.0');
}
add_action('login_enqueue_scripts', 'my_login_logo');

add_filter('login_headertext', 'custom_login_headertext');
function custom_login_headertext()
{
  $logo_image = get_stylesheet_directory_uri() . "/assets/img/logo_fa.png";
  return "<img src=\"{$logo_image}\"  alt=\"一括査定システム ログイン画面\">";
}

add_filter('login_headerurl', 'custom_login_headerurl');
function custom_login_headerurl()
{
  return wp_login_url();
}
