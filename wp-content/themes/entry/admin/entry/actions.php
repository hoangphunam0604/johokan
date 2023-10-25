<?php
add_action('admin_init', 'check_screen_edit_post');
function check_screen_edit_post()
{
  global $pagenow;
  if ($pagenow == 'post.php' && (isset($_GET['action']) && $_GET['action'] == 'edit')) {
    wp_redirect(admin_url("/edit.php?post_type=entry&page=entry-detail&post=" . $_GET['post']));
    exit;
  }
}
//bỏ kiểm tra người edit
add_filter('wp_check_post_lock_window', '__return_false');

function remove_bulk_actions($actions, $post)
{

  if ($post->post_type == "entry") :
    return [];
    unset($actions['inline hide-if-no-js']);
    unset($actions['view']);
    $title            = _draft_or_post_title($post);
    $actions['edit'] = sprintf(
      '<a href="%s" aria-label="%s">%s</a>',
      admin_url("/edit.php?post_type=entry&page=entry-detail&post=" . $post->ID),
      /* translators: %s: Post title. */
      esc_attr(sprintf(__('View &#8220;%s&#8221;'), $title)),
      __('View')
    );
  endif;  //($post->post_type =="entry"):
  return $actions;
}
add_filter('post_row_actions', 'remove_bulk_actions', 20, 2);

if (!is_super_admin()) {
  //Xóa hành động hàng loạt
  add_filter('bulk_actions-edit-entry', '__return_false', 20);
}
