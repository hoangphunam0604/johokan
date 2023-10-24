<?php

add_action('init', 'register_entry_post_type');
function register_entry_post_type()
{
  register_post_type(
    'entry',
    array(
      'labels'             => array(
        'name' => 'フォーム送信内容',
        'singular_name' => 'フォーム送信内容'
      ),
      'rewrite'            => array('slug' => ""),
      'supports' => array('title',),
      'capability_type'    => 'post',
      'public'             => false,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'hierarchical'       => false,
      'menu_position'      => 20,
      'menu_icon' =>  'dashicons-id',
      'capabilities' => array(
        "edit_post" =>  "edit_entry",
        "read_post" =>  "read_entry",
        "delete_post" =>  "delete_entry",
        "edit_posts"  =>  "edit_entries",
        "edit_others_posts" =>  "edit_others_entries",
        "publish_posts" =>  "publish_entries",
        "read_private_posts"  =>  "read_private_entries",
        "read"  =>  "read_entry",
        "delete_posts"  =>  "delete_entries",
        "delete_private_posts"  =>  "delete_private_entries",
        "delete_published_posts"  =>  "delete_published_entries",
        "delete_others_posts" =>  "delete_others_entries",
        "edit_private_posts"  =>  "edit_private_entries",
        "edit_published_posts"  =>  "edit_published_entries",
        "create_posts"  =>  "create_entries"
      ),
    )
  );
}


// Thêm cột loại nội dung
add_filter('manage_entry_posts_columns', 'custom_entry_columns');
function custom_entry_columns($columns)
{
  $columns = [];
  $columns['title'] = __('Title');
  $columns['summary'] = __('物件概要');

  return $columns;
}


// HIện thị loại nội dung trong bảng danh sách bài viết
add_action('manage_entry_posts_custom_column', 'add_value_custom_entry_columns', 10, 2);
function add_value_custom_entry_columns($column, $post_id)
{
  switch ($column) {
    case 'summary':
      $entry_id =  get_post_meta($post_id, 'entry_id', true);
      $info_company_name =  get_post_meta($post_id, 'info_company_name', true);
      $coms = [];
      $coms[] = "ABC";
      $coms[] = "XXX";
      $com_name = implode("\n", $coms);
      echo $com_name;
?>
      ■申込日時:<?php echo get_the_date('Y年m月d日', $post_id); ?><br>
      ■お客様ナンバー: <?php echo $entry_id; ?><br>
      ■会社名・事業者名: <?php echo $info_company_name; ?>
<?php
  }
}
