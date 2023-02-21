<?php
add_action("user_new_form", "custom_filter_sub_admin_role");
add_action('edit_user_profile', 'custom_filter_sub_admin_role', 3);
add_action('show_user_profile', 'custom_filter_sub_admin_role');

function custom_filter_sub_admin_role($user)
{

  if (!did_action('wp_enqueue_media')) {
    wp_enqueue_media();
  }

  $empty_location = "全県";
  if (current_user_can('sub-admin')) {
?>
    <style type="text/css">
      .user-profile-picture,
      #application-passwords-section,
      #password {
        display: none;
      }

      .wp-core-ui select.disabled,
      .wp-core-ui select:disabled {
        background-image: none;
        color: inherit;
        border-color: #dcdcde;
        background-color: #ffffff;
      }

      input.disabled,
      input:disabled,
      select.disabled,
      select:disabled,
      textarea.disabled,
      textarea:disabled {
        color: #000;
        background: #FFF;
        opacity: 1;
      }

      input[type=checkbox].disabled,
      input[type=checkbox].disabled:checked:before,
      input[type=checkbox]:disabled,
      input[type=checkbox]:disabled:checked:before,
      input[type=radio].disabled,
      input[type=radio].disabled:checked:before,
      input[type=radio]:disabled,
      input[type=radio]:disabled:checked:before {
        opacity: 1;
      }

      .submit {
        display: none;
      }
    </style>
    <script type="text/javascript">
      jQuery(function($) {
        $("input, select, textarea").prop("disabled", true);
        $("#_wpnonce").remove();
        $("p.submit").remove();
      });
    </script>
  <?php
  }
  // if(!is_super_admin()   ) return;
  if (current_user_can('sub-admin') || current_user_can('administrator')) {
    global $locations;


    $roles = (array) $user->roles;
    $display = in_array("sub-admin", $roles) ? "block" : "none";

  ?>
    <style type="text/css">
      #your-profile > *:nth-child(11),
      #your-profile *:nth-child(12){
        display: none;
      }
      .application-passwords{
        display: none;
      }
      #company-logo-preview img {
        max-width: 200px;
        max-height: 200px;
      }

      #sub-admin-filter select {
        width: 200px;
      }

      #list_location {
        display: none;
      }

      #list_location.checked {
        display: block;
      }

      .form-table tr th {
        width: 250px;
      }

      #list_location .group-all {
        display: block;
        margin: 5px
      }

      #list_location .location {
        height: 30px;
        width: 100px;
        float: left;
        margin-right: 20px;
      }

      #list_location .location label {
        margin-left: 5px;
      }

      label input[name="radio_location"] {
        margin-left: 10px;
        margin-right: 0 !important;
      }
    </style>
    <script type="text/javascript">
      jQuery(function($) {
        $("#role").change(function() {
          if ($(this).val() == "sub-admin") {
            $("#sub-admin-filter").show();
          } else {
            $("#sub-admin-filter").hide();
          }
        })
        $("input[name='radio_location']").change(function() {
          $('#list_location').slideToggle()
        })
        $("#checkall").change(function() {
          $('#list_location input:checkbox').not(this).prop('checked', this.checked);
        })

        $('body').on('click', '.company_logo_upload_image_button', function(e) {
          e.preventDefault();
          aw_uploader = wp.media({
              title: '会社ロゴ',
              multiple: false
            }).on('select', function() {
              var attachment = aw_uploader.state().get('selection').first().toJSON();
              $('#company-logo').val(attachment.url);
              $('#company-logo').trigger('change');
            })
            .open();
        });
        $('#company-logo').on('change', function() {
          $('#company-logo-preview img').attr('src', $(this).val());
        })
      })
    </script>
    <div id="sub-admin-filter" style="display: <?php echo $display; ?>">

      <h2>＜不動産情報の登録項目＞</h2>
      <table class="form-table">
        <tr>
          <th>優先させる業者（有料版）</th>
          <td>
            <?php
            $company_priority = get_the_author_meta("company_priority", $user->ID);
            ?>
            <label class="switch-button r">
              <input type="checkbox" class="checkbox" name="company_priority" <?php echo $company_priority == 1 ? "checked" : ""; ?> />
              <div class="knobs"></div>
              <div class="layer"></div>
            </label>
          </td>
        </tr>
        <tr>
          <th>会社ロゴ</th>
          <td>
            <?php $src =  get_the_author_meta('company_logo', $user->ID) ?: get_stylesheet_directory_uri() . '/assets/img/default-logo.png'; ?>
            <div class="company-logo">
              <div id="company-logo-preview">
                <img src="<?php echo $src; ?>" alt="" />
              </div>
              <div class="company-logo-change">
                <a href="#" class="company_logo_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a>
              </div>
              <input class="regular-text " type="url" id="company-logo" name="company_logo" value="<?php echo $src; ?>">
            </div>
          </td>
        </tr>
        <tr>
          <th>会社名</th>
          <td>
            <input class="regular-text " type="text" id="company-business-name" name="company_business_name" value="<?php echo get_the_author_meta("company_business_name", $user->ID); ?>">
          </td>
        </tr>
        <tr>
          <th>説明文</th>
          <td>
            <textarea class="regular-text " rows="4" id="company-description" name="company_description"><?php echo get_the_author_meta("company_description", $user->ID); ?></textarea>
          </td>
        </tr>
      </table>

      <hr>
      <h2><?php _e('副管理者情報 '); ?></h2>
      <table class="form-table">
        <tr>
          <th>あなたの事業形態を選択</th>
          <td>
            <?php $business_type = get_the_author_meta('business_type', $user->ID); ?>
            <select name="business_type" class="require background">
              <option value="">あなたの事業形態を選択</option>
              <option value="法人" <?php get_selected("法人", $business_type); ?>>法人</option>
              <option value="個人事業主" <?php get_selected("個人事業主", $business_type); ?>>個人事業主</option>
              <option value="フリーランス" <?php get_selected("フリーランス", $business_type); ?>>フリーランス</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>所在地を選択</th>
          <td>
            <?php
            $location = get_the_author_meta('location', $user->ID);
            if (!is_array($location))
              $location = [];
            $checkall = "checked";
            $other_checked = "";
            if (!empty($location) && $location[0] != "全県") :
              $checkall = "";
              $other_checked = "checked";
            endif;
            ?>
            <label>
              <input type="radio" name="radio_location" value="1" id="all_location" <?php echo $checkall; ?> />
              <?php echo $empty_location; ?>
            </label>

            <label>
              <input type="radio" name="radio_location" value="0" id="another_location" <?php echo $other_checked; ?> />
              各都道府県
            </label>


            <div id="list_location" class="<?php echo $other_checked; ?>" style="background-color: #ddd;min-height:200px;overflow:hidden;margin-top: 15px">
              <div class="group-all">
                <label><input type="checkbox" id="checkall"> すべて選択</label>
              </div>
              <hr />
              <?php foreach ($locations as  $option) : ?>
                <div class="location">
                  <label>
                    <input type="checkbox" name="location[]" value="<?php echo $option; ?>" <?php check_checked_array($option, $location); ?> />
                    <?php echo $option; ?>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
          </td>
        </tr>
        <tr>
          <th>売掛先の事業形態</th>
          <td>
            <?php $business_form = get_the_author_meta('business_form', $user->ID); ?>
            <select name="business_form" class="require background">
              <option value="">あなたの事業形態を選択</option>
              <option value="法人" <?php get_selected("法人", $business_form); ?>>法人</option>
              <option value="個人事業主" <?php get_selected("個人事業主", $business_form); ?>>個人事業主</option>
              <option value="その他" <?php get_selected("その他", $business_form); ?>>その他</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>ファクタリングのご利用経験</th>
          <td>
            <?php $experience = get_the_author_meta('experience', $user->ID); ?>
            <select name="experience" class="require background">
              <option value="">あなたの事業形態を選択</option>
              <option value="有り" <?php get_selected("有り", $experience); ?>>有り</option>
              <option value="無し" <?php get_selected("無し", $experience); ?>>無し</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>売掛債権の金額</th>
          <td>
            <?php $receivable_amount_from = get_the_author_meta('receivable_amount_from', $user->ID); ?>
            <?php $receivable_amount_to = get_the_author_meta('receivable_amount_to', $user->ID); ?>
            <input class="regular-text " type="tel" id="company-business-name" name="receivable_amount_from" value="<?php echo $receivable_amount_from; ?>">万円
            <br>-<br>
            <input class="regular-text " type="tel" id="company-business-name" name="receivable_amount_to" value="<?php echo $receivable_amount_to; ?>">万円
          </td>
        </tr>
        <tr>
          <th>売掛先への債権譲渡通知は可能ですか？</th>
          <td>
            <?php $receivable_notify = get_the_author_meta('receivable_notify', $user->ID); ?>
            <label>
              <input type="radio" name="receivable_notify" value="可能（三社間取引）" <?php check_checked_array($receivable_notify, ["可能（三社間取引）"],); ?> />
              可能（三社間取引）
            </label>
            <label>
              <input type="radio" name="receivable_notify" value="不可（二社間取引）" <?php check_checked_array($receivable_notify, ["不可（二社間取引）"]); ?> />
              不可（二社間取引）
            </label>
          </td>
        </tr>
      </table>
    </div>
<?php
  } else  return;
}

function get_selected($option, $value)
{
  echo $option == $value ? "selected" : "";
}

function disabled_with_sub_admin()
{
  echo current_user_can('sub-admin') ? "disabled" : "";
}

function check_checked_array($option, $array)
{
  echo in_array($option, $array) ? "checked" : "";
}
