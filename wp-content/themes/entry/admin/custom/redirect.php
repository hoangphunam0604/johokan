<?php
add_action('admin_init', 'check_screen_edit_post');
function check_screen_edit_post()
{
  global $pagenow;
  if ($pagenow == 'index.php') {
    wp_redirect(admin_url('/edit.php?post_type=entry'));
    exit;
  }
  if ($pagenow == 'post.php' && (isset($_GET['action']) && $_GET['action'] == 'edit')) {
    wp_redirect(admin_url("/edit.php?post_type=entry&page=entry-detail&post=" . $_GET['post']));
    exit;
  }
}
