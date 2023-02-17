<?php
add_action('parse_query', 'check_parse_query');
function check_parse_query($parse_query)
{
}
add_action('posts_where', 'custom_entrys_where');
function custom_entrys_where($where)
{
  global $wpdb, $post_type, $pagenow, $wpdb;

  if ($pagenow !== "edit.php" || $post_type !== "entry") return $where;

  if (!is_super_admin()) :
    $user = wp_get_current_user();
    $where .= $wpdb->prepare(
      " AND $wpdb->posts.post_content_filtered  LIKE '%\"%1d\"%' ",
      $user->ID
    );
  else :

    $filter_querys = [];
    $search_fields = [
      'business_type',
      'location',
      'business_form',
      'experience',
    ];
    foreach ($search_fields as $field) :
      if (isset($_GET[$field]) && $_GET[$field]) :
        $filter_querys[] = $wpdb->prepare(" $wpdb->posts.post_content  LIKE '%\"%1s\":\"%2s\"%' ", $field, $_GET[$field]);
      endif;
    endforeach;
    if (!empty($filter_querys)) {
      $content_filter = join(" AND ", $filter_querys);
      $where .= sprintf(
        " AND ( %1s )",
        $content_filter
      );
    }
  endif;
  return $where;
}


add_filter("views_edit-entry", 'custom_entry_view_count', 10, 1);

function custom_entry_view_count($views)
{

  global $wpdb;
  if (!is_super_admin()) {
    $user = wp_get_current_user();
    $user_ID = $user->ID;
    $total = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish'  AND post_type = 'entry' AND post_content_filtered  LIKE '%\"$user_ID\"%'");
  } else {
    $total = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'entry' ");
  }
  $_views['all'] = preg_replace('/\(.+\)/U', '(' . $total . ')', $views['all']);

  return $_views;
}
