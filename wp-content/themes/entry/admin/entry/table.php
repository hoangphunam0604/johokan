<?php
add_action('posts_join', 'join_postmeta_for_custom_field');
function join_postmeta_for_custom_field($join)
{
  global $post_type, $pagenow;

  if ($pagenow !== "edit.php" || $post_type !== "entry") return $join;
  return  $join .= get_search_meta_query('join');
}

add_action('posts_where', 'custom_entrys_where');
function custom_entrys_where($where)
{


  global $post_type, $pagenow;
  if ($pagenow !== "edit.php" || $post_type !== "entry") return $where;

  return  $where .= get_search_meta_query('where');
}


function get_search_meta_query($type): string
{
  if (!in_array($type, ['join', 'where']))
    return '';
  global $wpdb;
  $meta_query_args = [];


  $user_ID = 0;
  if (is_super_admin() && isset($_GET['company_id'])) :
    $user_ID = $_GET['company_id'];
  endif;

  if (!is_super_admin()) :
    $user = wp_get_current_user();
    $user_ID = $user->ID;
  endif;

  if ($user_ID) :
    $meta_query_args[] = [
      'key' =>  'companies',
      'compare' =>  'LIKE',
      'value' =>  $user_ID
    ];
  endif;
  $search_fields = [
    'business_type',
    'location',
    'business_form',
    'experience',
    'receivable_notify'
  ];
  foreach ($search_fields as $field) :
    if (isset($_GET[$field]) && $_GET[$field]) :
      $meta_query_args[] = [
        'key' =>  $field,
        'value' =>   $_GET[$field]
      ];
    endif;
  endforeach;
  if (empty($meta_query_args))
    return '';
  $meta_query = new WP_Meta_Query($meta_query_args);
  $query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
  return $query_sql[$type];
}

add_filter("views_edit-entry", 'custom_entry_view_count', 10, 1);

function custom_entry_view_count($views)
{
  global $wpdb;
  if (!is_super_admin()) {
    $user = wp_get_current_user();
    $user_ID = $user->ID;
    $total = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts
    INNER JOIN $wpdb->postmeta ON ($wpdb->postmeta.post_id = $wpdb->posts.ID) 
    WHERE  
        $wpdb->posts.post_status = 'publish'
        AND $wpdb->posts.post_type ='entry'
        AND $wpdb->postmeta.meta_key ='companies'
        AND $wpdb->postmeta.meta_value LIKE '%\"$user_ID\"%'");
  } else {
    $total = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'entry' ");
  }
  $_views['all'] = preg_replace('/\(.+\)/U', '(' . $total . ')', $views['all']);

  return $_views;
}
