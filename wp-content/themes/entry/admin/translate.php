<?php
add_filter('admin_body_class', 'custom_admin_body_class');
function custom_admin_body_class($classes)
{
  if (current_user_can('sub-admin'))
    $classes .= ' sub_admin';
  return $classes;
}
add_filter('gettext', 'custom_test', 100, 2);
function custom_test($translation, $text)
{
  switch ($text) {
    case "Howdy, %s":
      return "会社名： %s";
  }
  return $text;
}
