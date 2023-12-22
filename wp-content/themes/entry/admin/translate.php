<?php
add_filter('admin_body_class', 'custom_admin_body_class');
function custom_admin_body_class($classes)
{
  if (current_user_can('sub-admin'))
    $classes .= ' sub_admin';
  return $classes;
}
add_filter('gettext', 'custom_test', 100, 2);
function custom_test($translation, $text)
{
  switch ($text) {
    case "Howdy, %s":
      return "会社名： %s";
    case "Username or Email Address":
      if (isset($_GET['action']) && $_GET['action'] == "lostpassword")
        return "ログイン用のメールアドレス";
      return "ログインID";

    case "Remember Me":
      return  "次回から入力を省略する";
    case "Log In":
      return "ログインする";
    case "Log in":
      return "ログインへ戻る";
    case "Lost your password?":
      return "パスワードを忘れた場合";
    case "Please enter your username or email address. You will receive an email message with instructions on how to reset your password.":
      return "ログイン用のメールアドレスを入力してください。<br>パスワードの変更手続きのメールが送信されます。";
    case "Get New Password":
      return "パスワード用のメールを送信";
  }
  return $translation;
}
