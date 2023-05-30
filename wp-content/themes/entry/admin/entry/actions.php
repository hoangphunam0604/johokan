<?php

function remove_bulk_actions($actions, $post)
{

  if ($post->post_type == "entry") :
    unset($actions['inline hide-if-no-js']);
    unset($actions['view']);
    $title            = _draft_or_post_title($post);
    $actions['detail'] = sprintf(
      '<a href="%s" aria-label="%s">%s</a>',
      admin_url('/edit.php?post_type=entry&page=entry-detail&post_id=' . $post->ID),
      /* translators: %s: Post title. */
      esc_attr(sprintf(__('View &#8220;%s&#8221;'), $title)),
      __('View')
    );
  endif;  //($post->post_type =="entry"):
  return $actions;
}
add_filter('post_row_actions', 'remove_bulk_actions', 20, 2);

//bỏ kiểm tra người edit
add_filter('wp_check_post_lock_window', '__return_false');
