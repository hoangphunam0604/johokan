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
      'register_meta_box_cb' => 'entry_form_meta_boxes',
    )
  );
}
