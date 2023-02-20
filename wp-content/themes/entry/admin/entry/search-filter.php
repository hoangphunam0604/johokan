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

  <?php $location = esc_attr(isset($_GET['location']) ? $_GET['location'] : ""); ?>
  <?php global $locations; ?>
  <select name="location">
    <option value="">所在地を選択</option>
    <?php foreach ($locations as  $option) : ?>
      <option value="<?php echo $option; ?>" <?php get_selected($option, $location); ?>><?php echo $option; ?></option>
    <?php endforeach; ?>
  </select>
  <?php $business_form = esc_attr(isset($_GET['business_form']) ? $_GET['business_form'] : ""); ?>
  <select name="business_form">
    <option value="">あなたの事業形態を選択</option>
    <option value="法人" <?php get_selected("法人", $business_form); ?>>法人</option>
    <option value="個人事業主" <?php get_selected("個人事業主", $business_form); ?>>個人事業主</option>
    <option value="その他" <?php get_selected("その他", $business_form); ?>>その他</option>
  </select>
  <?php $experience = esc_attr(isset($_GET['experience']) ? $_GET['experience'] : ""); ?>
  <select name="experience">
    <option value="">あなたの事業形態を選択</option>
    <option value="有り" <?php get_selected("有り", $experience); ?>>有り</option>
    <option value="無し" <?php get_selected("無し", $experience); ?>>無し</option>
  </select>
  <?php $receivable_notify = esc_attr(isset($_GET['receivable_notify']) ? $_GET['receivable_notify'] : ""); ?>
  <select name="receivable_notify">
    <option value="">売掛先への債権譲渡通知は可能ですか？</option>
    <option value="可能（三社間取引）" <?php get_selected("可能（三社間取引）", $receivable_notify); ?>>可能（三社間取引）</option>
    <option value="不可（二社間取引）" <?php get_selected("不可（二社間取引）", $receivable_notify); ?>>不可（二社間取引）</option>
  </select>
  <?php $company_id = esc_attr(isset($_GET['company_id']) ? $_GET['company_id'] : ""); ?>

  <select name="company_id">
    <option value="">サブ管理者を選択</option>
    <?php $sup_admin_users = get_users(array('role' => 'sub-admin')); ?>
    <?php foreach ($sup_admin_users as $user) : ?>
      <option value="<?php echo $user->ID; ?>" <?php get_selected($user->ID, $company_id); ?>>
        <?php echo $user->user_nicename; ?> - <?php echo $user->display_name; ?>
      </option>
    <?php endforeach; ?>
  </select>


<?php
}
