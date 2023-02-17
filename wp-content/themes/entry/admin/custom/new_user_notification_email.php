<?php

add_filter("wp_new_user_notification_email", "custom_wp_new_user_notification_email", 20, 3);

function custom_wp_new_user_notification_email($wp_new_user_notification_email, $user, $blogname)
{
  $wp_new_user_notification_email['subject'] = __('[%s]  ユーザー情報を登録いたしました');

  $key = get_password_reset_key($user);

  $message  = sprintf(__('ユーザー名: %s'), $user->user_login) . "\r\n\r\n";
  $message  .= "ユーザー登録が完了いたしました。\r\n\r\n";
  $message  .= "==================================================\r\n";
  $message  .= "・パスワードを再設定するには以下のアドレスへ移動してください。\r\n";
  $message  .= "　　↓↓↓↓↓\r\n";
  $message  .= "「パスワード再設定ページ」\r\n";
  $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login') . "\r\n\r\n\r\n";
  $message  .= "・ログインの際は以下のページより、メールアドレスと設定したパスワードを入力しお進みください。\r\n";
  $message  .= "　　↓↓↓↓↓\r\n";
  $message  .= "「ログインページ」\r\n";
  $message .= wp_login_url() . "\r\n";
  $message  .= "==================================================\r\n\r\n";
  $message  .= "※本メールは自動送信メールです。\r\n";
  $message  .= "※ログインIDおよびパスワードは、大切に保管くださいませ。\r\n";
  $wp_new_user_notification_email['message'] = $message;

  return $wp_new_user_notification_email;
}
