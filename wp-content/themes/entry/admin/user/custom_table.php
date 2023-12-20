<?php
add_filter('get_avatar', 'custom_avatar', 20, 2);
function custom_avatar($avatar, $user_id)
{
  $src =  get_the_author_meta('company_logo', $user_id) ?: get_stylesheet_directory_uri() . '/assets/img/default-logo.png';
  $avatar = sprintf("<img  src='%s' class='company_logo' height='65' width='150' loading='lazy' decoding='async' />", esc_url($src));
  return $avatar;
}
