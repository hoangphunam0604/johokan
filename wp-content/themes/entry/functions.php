<?php
//Xóa link khôi phục mật khẩu
//add_filter('lost_password_html_link', '__return_false');

//Xóa link về trang chủ
add_filter('login_site_html_link', '__return_false');
//Xóa đổi language
add_filter('login_display_language_dropdown', '__return_false');

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
  show_admin_bar(false);
}
function autoloadLoad($dir = __DIR__)
{
  $files = array_diff(scandir($dir, 1), array('..', '.'));
  foreach ($files as $file) {
    if (is_dir("$dir/{$file}")) {
      autoloadLoad("$dir/{$file}");
    } else if (substr($file, -4) === '.php') {
      require_once $dir . "/{$file}";
    }
  }
}
global $locations;
$locations = array(
  "北海道",
  "青森県",
  "岩手県",
  "宮城県",
  "秋田県",
  "山形県",
  "福島県",
  "茨城県",
  "栃木県",
  "群馬県",
  "埼玉県",
  "千葉県",
  "東京都",
  "神奈川県",
  "新潟県",
  "富山県",
  "石川県",
  "福井県",
  "山梨県",
  "長野県",
  "岐阜県",
  "静岡県",
  "愛知県",
  "三重県",
  "滋賀県",
  "京都府",
  "大阪府",
  "兵庫県",
  "奈良県",
  "和歌山県",
  "鳥取県",
  "島根県",
  "岡山県",
  "広島県",
  "山口県",
  "徳島県",
  "香川県",
  "愛媛県",
  "高知県",
  "福岡県",
  "佐賀県",
  "長崎県",
  "熊本県",
  "大分県",
  "宮崎県",
  "鹿児島県",
  "沖縄県",
);
autoloadLoad(__DIR__ . "/api");
autoloadLoad(__DIR__ . "/admin");
