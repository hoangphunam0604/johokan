<?php
add_action('restrict_manage_posts', 'add_post_formats_filter_to_post_administration');

function add_post_formats_filter_to_post_administration()
{
  global $post_type;
  if ($post_type == 'entry' && is_super_admin()) :
    global $entry_form_fields;
    foreach ($entry_form_fields as $key => $field) :
      if (!isset($field["filter"]) || $field["filter"] == false) continue;
      $value = esc_attr(isset($_REQUEST[$key]) ? $_REQUEST[$key] : "");
?>
      <select id="<?php echo $key; ?>" name="<?php echo $key; ?>">
        <option value=""><?php echo $field["name"]; ?></option>
        <?php foreach ($field["options"] as  $option) : ?>
          <option <?php get_selected($option, $value); ?> value="<?php echo $option; ?>"><?php echo $option; ?></option>
        <?php endforeach; ?>
      </select>
<?php
    endforeach;
  endif;
}
