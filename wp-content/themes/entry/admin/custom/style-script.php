<?php
function enqueue_johokabn_admin_style()
{
  wp_enqueue_style("johokan-admin", get_stylesheet_directory_uri() . "/admin/assets/css/style.css", array(), '1.0.0');

  wp_enqueue_script('johokan-admin', get_stylesheet_directory_uri() . "/admin/assets/js/script.css");
}
add_action('admin_enqueue_scripts', 'enqueue_johokabn_admin_style');
