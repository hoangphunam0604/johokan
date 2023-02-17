<?php
add_action('restrict_manage_posts', 'add_post_formats_filter_to_post_administration');

function add_post_formats_filter_to_post_administration()
{
  global $post_type;
  if ($post_type != 'entry' || !is_super_admin())
    return;
?>


  <?php $business_type = esc_attr(isset($_GET['business_type']) ? $_GET['business_type'] : ""); ?>
  <select name="business_type">
    <option value="">あなたの事業形態を選択</option>
    <option value="法人" <?php get_selected("法人", $business_type); ?>>法人</option>
    <option value="個人事業主" <?php get_selected("個人事業主", $business_type); ?>>個人事業主</option>
    <option value="フリーランス" <?php get_selected("フリーランス", $business_type); ?>>フリーランス</option>
  </select>

  <?php /* $location = esc_attr(isset($_GET['location']) ? $_GET['location'] : ""); ?>
  <?php global $locations; ?>
  <select name="location">
    <option value="">全県</option>
    <?php foreach ($locations as  $option) : ?>
      <option value="<?php echo $option; ?>" <?php get_selected($option, $location); ?>><?php echo $option; ?></option>
    <?php endforeach; ?>
  </select> */ ?>
  <?php $business_form = esc_attr(isset($_GET['business_form']) ? $_GET['business_form'] : ""); ?>
  <select name="business_form" class="require background">
    <option value="">あなたの事業形態を選択</option>
    <option value="法人" <?php get_selected("法人", $business_form); ?>>法人</option>
    <option value="個人事業主" <?php get_selected("個人事業主", $business_form); ?>>個人事業主</option>
    <option value="その他" <?php get_selected("その他", $business_form); ?>>その他</option>
  </select>
  <?php $experience = esc_attr(isset($_GET['experience']) ? $_GET['experience'] : ""); ?>
  <select name="experience" class="require background">
    <option value="">あなたの事業形態を選択</option>
    <option value="有り" <?php get_selected("有り", $experience); ?>>有り</option>
    <option value="無し" <?php get_selected("無し", $experience); ?>>無し</option>
  </select>

<?php
}
