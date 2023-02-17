<?php
add_action('admin_menu', 'statistic_admin_menu');

function statistic_admin_menu()
{
  add_submenu_page("edit.php?post_type=entry", '統計', '統計', 'edit_entry', 'entry-form-statistic', 'statistic_entry_form_admin_page');
}

function my_admin_enqueue($hook_suffix)
{
  wp_enqueue_style('statistic-page', get_template_directory_uri() . '/assets/css/style.css', array(), filemtime(WP_CONTENT_DIR . "/themes/entry/assets/css/style.css"));

  if ($hook_suffix == 'entry_page_entry-form-statistic') {
    wp_enqueue_script('chart', get_template_directory_uri() . '/assets/js/chart.js', array('jquery'), "v3.3.2", true);
    wp_enqueue_script('statistic-page', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), filemtime(WP_CONTENT_DIR . "/themes/entry/assets/js/script.js"), true);
  }
}
add_action('admin_enqueue_scripts', 'my_admin_enqueue');


function statistic_entry_form_admin_page()
{


  /**
   * Thống kê theo năm -  chọn theo danh sách năm
   * Dữ liệu được nhóm theo tháng  
   */

  /**
   * Thống kê theo tuần -  chọn theo danh sách tuần của năm 
   * Dữ liệu được nhóm theo các ngày trong tuần
   */
  /*
  /**
    * Thống kê theo tháng - chọn theo danh sách tháng của năm
    * Dữ liệu được nhóm theo ngày 
    */

  $first_date =  getFirstDateEntry();
  $years = listYears($first_date);
  $months = listMonthYears($first_date);
?>
  <h1>統計</h1>
  <?php if (is_super_admin()) : ?>
    <?php
    $roles = ['administrator', 'sub-admin'];
    $wp_roles = new WP_Roles();
    $_roles = $wp_roles->get_names();
    $sup_admin_users = get_users(array('role' => 'sub-admin'));
    ?>
    <div class="row-wrap">
      <div id="group-role">
        <div class="role">
          <label for="role">権限選択: </label>
          <select name="role" id="role">
            <?php foreach ($roles as $role) : ?>
              <option value="<?php echo $role; ?>"><?php echo $_roles[$role]; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div id="sup-admin-users">
          <label for="user_id">サブ管理者を選択: </label>
          <select name="user_id" id="user_id">
            <option value="">--SELECT USER--</option>
            <?php foreach ($sup_admin_users as $user) : ?>
              <option value="<?php echo $user->ID; ?>"><?php echo $user->user_nicename; ?> - <?php echo $user->display_name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="action">
          <button id="get-data" class="button button-primary">Get data</button>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <h2>1/ 年 : <span id="total-year">0</span>件</h2>
  <label>
    年を選択:
    <select name="year" id="year">
      <?php foreach ($years as  $year) : ?>
        <option value="<?php echo $year['year']; ?>"><?php echo $year['year_name']; ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <div class="chart-wrap">
    <canvas id="year-chart"></canvas>
  </div>

  <h2>2/ 週 : <span id="total-week">0</span>件</h2>
  <div class="chart-wrap">
    <canvas id="week-chart"></canvas>
  </div>

  <h2>3/ 日々: <span id="total-month">0</span>件</h2>
  <label>
    月を選択してください:
    <select name="month" id="month">
      <?php foreach ($months as  $month) : ?>
        <option value="<?php echo $month['month']; ?>"><?php echo $month['month_name']; ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <div class="chart-wrap">
    <canvas id="month-chart"></canvas>
  </div>
<?php
}
