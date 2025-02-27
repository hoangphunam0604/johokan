<?php

add_action('init', 'johokan_entry_router');

function johokan_entry_router()
{
  if ($_SERVER['REQUEST_METHOD'] !== "POST") :
    global $pagenow;
    if (!is_user_logged_in() && !is_admin() && $pagenow != 'wp-login.php') {
      require_once __DIR__ . "/../404.php";
      status_header(404, 'Page Not Found');
      //wp_redirect(wp_login_url(), 301);
      exit;
    }
    return;
  endif;
  if (
    !isset($_POST['entry_action'])
    || !isset($_POST['entry_client'])
    || $_POST['entry_client'] != "johokan"
  )
    return;
  switch ($_POST['entry_action']):
    case "get_companies":
      get_companies();
      break;
    case "store_entry":
      store_entry();
      break;
  endswitch;

  return;
}
