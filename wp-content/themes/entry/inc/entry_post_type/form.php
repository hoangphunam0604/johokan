<?php
add_action('admin_init', 'disable_autosave');
function disable_autosave()
{
  wp_deregister_script('autosave');
}

function remove_bulk_actions($actions, $post)
{

  if ($post->post_type == "entry") :
    unset($actions['inline hide-if-no-js']);
    unset($actions['view']);
    $title            = _draft_or_post_title($post);
    $actions['edit'] = sprintf(
      '<a href="%s" aria-label="%s">%s</a>',
      get_edit_post_link($post->ID),
      /* translators: %s: Post title. */
      esc_attr(sprintf(__('View &#8220;%s&#8221;'), $title)),
      __('View')
    );
  endif;  //($post->post_type =="entry"):
  return $actions;
}
add_filter('post_row_actions', 'remove_bulk_actions', 20, 2);


function entry_form_meta_boxes()
{
  add_meta_box('entry-info', __('Entry Content', 'entry_form'), 'entry_form_meta_box', 'entry');
}


function entry_form_meta_box($post)
{
  $data = json_decode($post->post_content, true);
?>
<style>
 #poststuff .entry-box .entry-table-title{
    font-size: 1.6em;
    font-weight: bold;
    margin-top: 20px;
  }
</style>
  <div class="entry-box <?php echo is_super_admin() ? "sub-admin" : ""; ?>">
    <table>
      <tr>
        <th>あなたの事業形態を選択</th>
        <td><?php echo isset($data['business_type'])?$data['business_type']:""; ?></td>
      </tr>
      <tr>
        <th>所在地を選択</th>
        <td><?php echo isset($data['location'])?$data['location']:""; ?></td>
      </tr>
      <tr>
        <th>売掛先の事業形態</th>
        <td><?php echo isset($data['business_form'])?$data['business_form']:""; ?></td>
      </tr>
      <tr>
        <th>ファクタリングのご利用経験</th>
        <td><?php echo isset($data['experience'])?$data['experience']:""; ?></td>
      </tr>
    </table>
    <h2 class="entry-table-title">【売掛先の情報】</h2>
    <table>
      <tr>
        <th>売掛債権の金額</th>
        <td><?php echo isset($data['receivable_amount'])?$data['receivable_amount']:""; ?></td>
      </tr>
      <tr>
        <th>ご希望の買取金額</th>
        <td><?php echo isset($data['receivable_quantity'])?$data['receivable_quantity']:""; ?></td>
      </tr>
      <tr>
        <th>売掛金の入金予定日</th>
        <td><?php echo isset($data['receivable_date'])?$data['receivable_date']:""; ?></td>
      </tr>
      <tr>
        <th>売掛先への債権譲渡通知は可能ですか？</th>
        <td><?php echo isset($data['receivable_notify'])?$data['receivable_notify']:""; ?></td>
      </tr>
      <tr>
        <th>売掛先の会社名</th>
        <td><?php echo isset($data['receivable_company_name'])?$data['receivable_company_name']:""; ?></td>
      </tr>
      <tr>
        <th>売掛先の所在地</th>
        <td><?php echo isset($data['receivable_company_address'])?$data['receivable_company_address']:""; ?></td>
      </tr>
      <tr>
        <th>取引年数</th>
        <td><?php echo isset($data['receivable_company_year'])?$data['receivable_company_year']:""; ?></td>
      </tr>
      <tr>
        <th>年間の取引金額</th>
        <td><?php echo isset($data['receivable_company_annual'])?$data['receivable_company_annual']:""; ?></td>
      </tr>
    </table>
    <h2 class="entry-table-title">【ご利用者の情報】</h2>
    <table>
      <tr>
        <th>会社名・事業者名</th>
        <td><?php echo isset($data['info_company_name'])?$data['info_company_name']:""; ?></td>
      </tr>
      <tr>
        <th>ファクタリングをご希望の時期</th>
        <td><?php echo isset($data['info_duration'])?$data['info_duration']:""; ?></td>
      </tr>
      <tr>
        <th>創業年数</th>
        <td><?php echo isset($data['info_founding_year'])?$data['info_founding_year']:""; ?></td>
      </tr>
      <tr>
        <th>年商を選択</th>
        <td><?php echo isset($data['info_annual_turnover'])?$data['info_annual_turnover']:""; ?></td>
      </tr>
      <tr>
        <th>業種</th>
        <td><?php echo isset($data['info_industry'])?$data['info_industry']:""; ?></td>
      </tr>
      <tr>
        <th>ご担当者の氏名</th>
        <td><?php echo isset($data['info_fullname'])?$data['info_fullname']:""; ?></td>
      </tr>
      <tr>
        <th>ご担当者のふりがな</th>
        <td><?php echo isset($data['info_furiname'])?$data['info_furiname']:""; ?></td>
      </tr>
      <tr>
        <th>Email</th>
        <td><?php echo isset($data['info_email'])?$data['info_email']:""; ?></td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td><?php echo isset($data['info_phone'])?$data['info_phone']:""; ?></td>
      </tr>
      <tr>
        <th>ご希望の連絡日時</th>
        <td>
          <?php echo isset($data['info_preferred_contact_date'])?$data['info_preferred_contact_date']:""; ?><br>
          <?php echo isset($data['info_preferred_contact_type'])?$data['info_preferred_contact_type']:""; ?><br>
      </td>
      </tr>
      <tr>
        <th>ご要望など</th>
        <td><?php echo isset($data['info_other'])?nl2br($data['info_other']):""; ?></td>
      </tr>
    </table>
  </div>
  <script type="text/javascript">
    jQuery(function($) {
      $("input[name='post_title']").prop("disabled", true);
    });
  </script>
<?php
}
