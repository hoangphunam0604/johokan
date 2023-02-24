<?php
add_action('admin_menu', "admin_menu");

function admin_menu()
{
  add_submenu_page("edit.php?post_type=entry", __('送信フォーム設定Setting entry form', "luxeritas"), __('設定', "luxeritas"), 'administrator', 'entry-form-setting', 'admin_page');
}
function admin_page()
{
  /* 
  $admin_role_set = get_role( 'administrator' )->capabilities;
  var_dump($admin_role_set);
  echo "<br />";
  $admin_role_set = get_role( 'sub-admin' )->capabilities;
  var_dump($admin_role_set);
 */
  if ($_POST) {
    if (!wp_verify_nonce(trim($_POST['entry_form__nonce']), 'entry_form__nonce')) {
      wp_die('Security check not passed!');
    }
    $option = array();

    $option["from_email"] = sanitize_email(trim($_POST['from_email']));
    $option["from_name"] = sanitize_text_field(trim($_POST['from_name']));

    $option["admin_to"] = sanitize_email(trim($_POST['admin_to']));
    $option["admin_bcc"] = sanitize_email(trim($_POST['admin_bcc']));

    $option["admin_subject"] = sanitize_text_field(trim($_POST['admin_subject']));

    $option["subadmin_subject"] = sanitize_text_field(trim($_POST['subadmin_subject']));
    $option["admin_message"] = sanitize_textarea_field(trim($_POST['admin_message']));

    $option["customer_subject"] = sanitize_text_field(trim($_POST['customer_subject']));
    $option["customer_message"] = sanitize_textarea_field(trim($_POST['customer_message']));

    update_option("entry_form_options", $option);
    echo '<div id="message" class="updated fade"><p><strong>' . __("Saved setting!", "luxeritas") . '</strong></p></div>';
  }
  $ws_nonce = wp_create_nonce('entry_form__nonce');
  $sfOption = get_option('entry_form_options');
?>
  <style>
    #entry_setting .form-table th {
      width: 400px;
    }
  </style>
  <h2>送信フォーム設定</h2>
  <div>
    <form id="entry_setting" action="" method="post" enctype="multipart/form-data" name="entry_form__form">
      <h3><?php _e("FROM"); ?></h3>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">
            <?php _e("FROM email", "luxeritas"); ?>
          </th>
          <td>
            <label>
              <input type="email" name="from_email" value="<?php echo $sfOption['from_email']; ?>" size="43" style="width:400px;height:36px;" required />
            </label>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <?php _e("FROM Name", "luxeritas"); ?>
          </th>
          <td>
            <label>
              <input type="text" name="from_name" value="<?php echo $sfOption['from_name']; ?>" size="43" style="width:400px;height:36px;" required />
            </label>
          </td>
        </tr>
      </table>
      <h3><?php _e("管理者のメールアドレス設定", "luxeritas"); ?></h3>

      <table class="form-table">
        <tr valign="top">
          <th scope="row">
            <?php _e("送信先", "luxeritas"); ?>
          </th>
          <td>
            <label>
              <input type="email" name="admin_to" value="<?php echo $sfOption['admin_to']; ?>" size="43" style="width:400px;height:36px;" required />
            </label>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <?php _e("送信先BCC", "luxeritas"); ?>
          </th>
          <td>
            <label>
              <input type="email" name="admin_bcc" value="<?php echo $sfOption['admin_bcc']; ?>" size="43" style="width:400px;height:36px;" required />
            </label>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <?php _e("通信メールタイトル", "luxeritas"); ?>
          </th>
          <td>
            <label>
              <input type="text" name="admin_subject" value="<?php echo $sfOption['admin_subject']; ?>" size="43" style="width:400px;height:36px;" required />
            </label>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <?php _e("副管理者用通信メールタイトル", "luxeritas"); ?>
          </th>
          <td>
            <label>
              <input type="text" name="subadmin_subject" value="<?php echo $sfOption['subadmin_subject']; ?>" size="43" style="width:400px;height:36px;" required />
            </label>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            通信メール内容
            <p style="font-weight:normal;">
              あなたの事業形態を選択:[business_type]<br>
              所在地を選択:[location]<br>
              売掛先の事業形態:[business_form]<br>
              ファクタリングのご利用経験:[experience]<br>
              <strong>【売掛先の情報】</strong><br>
              売掛債権の金額: [receivable_amount]万円<br>
              ご希望の買取金額: [receivable_quantity]万円<br>
              売掛金の入金予定日: [receivable_date]<br>
              売掛先への債権譲渡通知は可能ですか？: [receivable_notify]<br>
              売掛先の会社名: [receivable_company_name]<br>
              売掛先の所在地: [receivable_company_address]<br>
              取引年数: [receivable_company_year]<br>
              年間の取引金額: [receivable_company_annual]<br><br>
              <strong>【ご利用者の情報】</strong><br>
              会社名・事業者名: [info_company_name]<br>
              ファクタリングをご希望の時期: [info_duration]<br>
              創業年数: [info_founding_year]<br>
              年商を選択: [info_annual_turnover]<br>
              業種: [info_industry]<br>
              ご担当者の氏名: [info_fullname]<br>
              ご担当者のフリガナ: [info_furigana_name]<br>
              Email: [info_email]<br>
              電話番号: [info_phone]<br>
              ご希望の連絡日時: [info_preferred_contact_date]<br>
              　　　　　　　　　[info_preferred_contact_type]<br>
              ご要望など: [other]
            </p>
          </th>
          <td>
            <textarea type="text" name="admin_message" value="" cols="45" rows="30" style="width:400px;" required><?php echo $sfOption['admin_message']; ?></textarea>
          </td>
        </tr>
      </table>
      <h3><?php _e("お客様側の通信メール設定", "luxeritas"); ?></h3>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">
            <?php _e("通信メールタイトル", "luxeritas"); ?>
          </th>
          <td>
            <label>
              <input type="text" name="customer_subject" value="<?php echo $sfOption['customer_subject']; ?>" size="43" style="width:400px;height:36px;" required />
            </label>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            通信メール内容
            <p style="font-weight:normal;">
              あなたの事業形態を選択:[business_type]<br>
              所在地を選択:[location]<br>
              売掛先の事業形態:[business_form]<br>
              ファクタリングのご利用経験:[experience]<br>
              <strong>【売掛先の情報】</strong><br>
              売掛債権の金額: [receivable_amount]万円<br>
              ご希望の買取金額: [receivable_quantity]万円<br>
              売掛金の入金予定日: [receivable_date]<br>
              売掛先への債権譲渡通知は可能ですか？: [receivable_notify]<br>
              売掛先の会社名: [receivable_company_name]<br>
              売掛先の所在地: [receivable_company_address]<br>
              取引年数: [receivable_company_year]<br>
              年間の取引金額: [receivable_company_annual]<br><br>
              <strong>【ご利用者の情報】</strong><br>
              会社名・事業者名: [info_company_name]<br>
              ファクタリングをご希望の時期: [info_duration]<br>
              創業年数: [info_founding_year]<br>
              年商を選択: [info_annual_turnover]<br>
              業種: [info_industry]<br>
              ご担当者の氏名: [info_fullname]<br>
              ご担当者のフリガナ: [info_furigana_name]<br>
              Email: [info_email]<br>
              電話番号: [info_phone]<br>
              ご希望の連絡日時: [info_preferred_contact_date]<br>
              　　　　　　　　　[info_preferred_contact_type]<br>
              ご要望など: [other]
            </p>
          </th>
          <td>
            <textarea type="text" name="customer_message" value="" cols="45" rows="30" style="width:400px;" required><?php echo $sfOption['customer_message']; ?></textarea>
          </td>
        </tr>
      </table>
      <p class="submit">
        <input type="hidden" name="entry_form__nonce" value="<?php echo $ws_nonce; ?>" />
        <input type="submit" class="button-primary" value="<?php _e('更新', 'wp-smtp'); ?>" />
      </p>
    </form>
  </div>
<?php
}
