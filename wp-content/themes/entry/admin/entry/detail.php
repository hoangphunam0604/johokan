<?php

add_action('admin_init', 'disable_autosave');
function disable_autosave()
{
  wp_deregister_script('autosave');
}


add_action('admin_menu', "entry_detail_menu");

function entry_detail_menu()
{
  add_submenu_page(null, __('送信フォーム設定Setting entry form', "luxeritas"), __('設定', "luxeritas"), 'edit_entry', 'entry-detail', 'entry_detail');
}
function entry_detail()
{
  $post_ID = $_GET['post'];
  $entry_id =  get_post_meta($post_ID, 'entry_id', true);
  $business_type =  get_post_meta($post_ID, 'business_type', true);
  $location =  get_post_meta($post_ID, 'location', true);
  $business_form =  get_post_meta($post_ID, 'business_form', true);
  $experience =  get_post_meta($post_ID, 'experience', true);
  $receivable_amount =  get_post_meta($post_ID, 'receivable_amount', true);
  $receivable_quantity =  get_post_meta($post_ID, 'receivable_quantity', true);
  $receivable_date =  get_post_meta($post_ID, 'receivable_date', true);
  $receivable_notify =  get_post_meta($post_ID, 'receivable_notify', true);
  $receivable_company_name =  get_post_meta($post_ID, 'receivable_company_name', true);
  $receivable_company_address =  get_post_meta($post_ID, 'receivable_company_address', true);
  $receivable_company_year =  get_post_meta($post_ID, 'receivable_company_year', true);
  $receivable_company_annual =  get_post_meta($post_ID, 'receivable_company_annual', true);
  $info_company_name =  get_post_meta($post_ID, 'info_company_name', true);
  $info_duration =  get_post_meta($post_ID, 'info_duration', true);
  $info_founding_year =  get_post_meta($post_ID, 'info_founding_year', true);
  $info_annual_turnover =  get_post_meta($post_ID, 'info_annual_turnover', true);
  $info_industry =  get_post_meta($post_ID, 'info_industry', true);
  $info_fullname =  get_post_meta($post_ID, 'info_fullname', true);
  $info_furigana_name =  get_post_meta($post_ID, 'info_furigana_name', true);
  $info_email =  get_post_meta($post_ID, 'info_email', true);
  $info_phone =  get_post_meta($post_ID, 'info_phone', true);
  $info_preferred_contact_date =  get_post_meta($post_ID, 'info_preferred_contact_date', true);
  $info_preferred_contact_type =  get_post_meta($post_ID, 'info_preferred_contact_type', true);
  $other =  get_post_meta($post_ID, 'other', true);

  if ($receivable_date) :
    $receivable_date_create = date_create($receivable_date);
    $receivable_date = date_format($receivable_date_create, "Y年m月d日");
  endif;

  if ($info_preferred_contact_date) :
    $info_preferred_contact_date_create = date_create($info_preferred_contact_date);
    $info_preferred_contact_date = date_format($info_preferred_contact_date_create, "Y年m月d日 H:i");
  endif;

?> <style>
    #poststuff .entry-box .entry-table-title {
      font-size: 1.6em;
      font-weight: bold;
      margin-top: 20px;
    }
  </style>
  <div class="wrap" style="margin-top: 20px;">
    <h1 class="wp-heading-inline"><?php echo get_the_title($post_ID); ?></h1>
    <hr class="wp-header-end">

    <div id="poststuff">
      <div id="post-body" class="metabox-holder columns-2">
        <div id="postbox-container-1" class="postbox-container">
        </div>
        <div id="postbox-container-2" class="postbox-container">
          <div id="normal-sortables" class="meta-box-sortables ui-sortable">
            <div id="entry-info" class="postbox ">
              <div class="postbox-header">
                <h2 class="hndle ui-sortable-handle">Entry Content</h2>
              </div>
              <div class="inside">
                <style>
                  #poststuff .entry-box .entry-table-title {
                    font-size: 1.6em;
                    font-weight: bold;
                    margin-top: 20px;
                  }
                </style>
                <div class="entry-box <?php echo is_super_admin() ? "sub-admin" : ""; ?>">
                  <table>
                    <tr>
                      <th>■お客様ナンバー:</th>
                      <td><strong style="font-size: 1.3em;"><?php echo $entry_id; ?></strong></td>
                    </tr>
                    <tr>
                      <th>■申込者の事業形態:</th>
                      <td><?php echo $business_type; ?></td>
                    </tr>
                    <tr>
                      <th>■申込者の所在地:</th>
                      <td><?php echo $location; ?></td>
                    </tr>
                    <tr>
                      <th>■ファクタリングのご利用経験:</th>
                      <td><?php echo $experience; ?></td>
                    </tr>
                  </table>
                  <h2 class="entry-table-title">【売掛先の情報】</h2>
                  <table>
                    <tr>
                      <th>■売掛先の事業形態:</th>
                      <td><?php echo $business_form; ?></td>
                    </tr>
                    <tr>
                      <th>■対応可能な売掛債権額:</th>
                      <td><?php echo $receivable_amount; ?>万円</td>
                    </tr>
                    <tr>
                      <th>■ご希望の買取金額:</th>
                      <td><?php echo $receivable_quantity; ?>万円</td>
                    </tr>
                    <tr>
                      <th>■売掛金の入金予定日:</th>
                      <td><?php echo $receivable_date; ?> </td>
                    </tr>
                    <tr>
                      <th>■債権譲渡通知の可否:</th>
                      <td><?php echo $receivable_notify; ?></td>
                    </tr>
                    <tr>
                      <th>■売掛先の会社名:</th>
                      <td><?php echo $receivable_company_name; ?></td>
                    </tr>
                    <tr>
                      <th>■売掛先の所在地:</th>
                      <td><?php echo $receivable_company_address; ?></td>
                    </tr>
                    <tr>
                      <th>■取引年数:</th>
                      <td><?php echo $receivable_company_year; ?></td>
                    </tr>
                    <tr>
                      <th>■年間の取引金額:</th>
                      <td><?php echo $receivable_company_annual; ?></td>
                    </tr>
                  </table>
                  <h2 class="entry-table-title">【ご利用者の情報】</h2>
                  <table>
                    <tr>
                      <th>■会社名・事業者名:</th>
                      <td><?php echo $info_company_name; ?></td>
                    </tr>
                    <tr>
                      <th>■ファクタリングをご希望の時期:</th>
                      <td><?php echo $info_duration; ?></td>
                    </tr>
                    <tr>
                      <th>■創業年数:</th>
                      <td><?php echo $info_founding_year; ?></td>
                    </tr>
                    <tr>
                      <th>■年商を選択:</th>
                      <td><?php echo $info_annual_turnover; ?></td>
                    </tr>
                    <tr>
                      <th>■業種:</th>
                      <td><?php echo $info_industry; ?></td>
                    </tr>
                    <tr>
                      <th>■ご担当者の氏名:</th>
                      <td><?php echo $info_fullname; ?></td>
                    </tr>
                    <tr>
                      <th>■ご担当者のフリガナ:</th>
                      <td><?php echo $info_furigana_name; ?></td>
                    </tr>
                    <tr>
                      <th>■Email:</th>
                      <td><?php echo $info_email; ?></td>
                    </tr>
                    <tr>
                      <th>■電話番号:</th>
                      <td><?php echo $info_phone; ?></td>
                    </tr>
                    <tr>
                      <th>■ご希望の連絡日時:</th>
                      <td><?php echo $info_preferred_contact_date; ?>（<?php echo $info_preferred_contact_type; ?>）</td>
                    </tr>
                    <tr>
                      <th>■ご要望など:</th>
                      <td><?php echo $other; ?></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /post-body -->
      <br class="clear">
    </div><!-- /poststuff -->
  </div>
<?php
}
