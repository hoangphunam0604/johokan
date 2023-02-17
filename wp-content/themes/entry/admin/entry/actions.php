<?php

function remove_bulk_actions($actions, $post)
{

  if ($post->post_type == "entry") :
    unset($actions['inline hide-if-no-js']);
    unset($actions['view']);
    $title            = _draft_or_post_title($post);
    $actions['edit'] = sprintf(
      '<a href="%s" aria-label="%s">%s</a>',
      get_edit_post_link($post->ID),
      /* translators: %s: Post title. */
      esc_attr(sprintf(__('View &#8220;%s&#8221;'), $title)),
      __('View')
    );
  endif;  //($post->post_type =="entry"):
  return $actions;
}
add_filter('post_row_actions', 'remove_bulk_actions', 20, 2);
