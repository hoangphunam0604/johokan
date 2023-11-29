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
      })
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
      #your-profile>*:nth-child(11),
      #your-profile *:nth-child(12) {
        display: none;
      }

      .application-passwords {
        display: none;
      }

      #company-logo-preview img {
        max-width: 200px;
        max-height: 200px;
      }

      #sub-admin-filter select {
        width: 200px;
      }

      .list_location {
        display: none;
      }

      .list_location.checked {
        display: block;
      }

      .form-table tr th {
        width: 250px;
      }

      .list_location .group-all {
        display: block;
        margin: 5px
      }

      .list_location .location {
        height: 30px;
        width: 100px;
        float: left;
        margin-right: 20px;
      }

      .list_location .location label {
        margin-left: 5px;
      }

      label input[name="radio_location"] {
        margin-left: 10px;
        margin-right: 0 !important;
      }
    </style>
    <?php if (current_user_can('administrator')) : ?>
      <script type="text/javascript">
        jQuery(function($) {


          $("#your-profile input").on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
              e.preventDefault();
              return false;
            }
          });

          $("#role").change(function() {
            if ($(this).val() == "sub-admin") {
              $("#sub-admin-filter").show();
            } else {
              $("#sub-admin-filter").hide();
            }
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
          });

        })
      </script>
    <?php endif; ?>
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
              <?php if (current_user_can('administrator')) : ?>
                <div class="company-logo-change">
                  <a href="#" class="company_logo_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a>
                </div>
                <input class="regular-text " type="url" id="company-logo" name="company_logo" value="<?php echo $src; ?>">
              <?php endif; ?>
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
        <tr>
          <th>URL</th>
          <td>
            <input class="regular-text " type="text" id="company-detail_url" name="company_detail_url" value="<?php echo get_the_author_meta("company_detail_url", $user->ID); ?>">
          </td>
        </tr>
      </table>

      <hr>
      <h2><?php _e('副管理者情報 '); ?></h2>
      <table class="form-table">
        <tr>
          <th>条件設定</th>
          <td>
            <div id="rules">
              <?php
              $keyRule = 0;
              $rules = $user == "add-new-user" ? [] : get_the_author_meta('rules', $user->ID,  true);
              if (is_array($rules)) :
                foreach ($rules as  $rule) :
                  getRuleTemplate($keyRule, $rule);
                  $keyRule++;
                endforeach;
              endif;
              ?>

            </div>
            <?php if (current_user_can('administrator')) : ?>
              <button class="button button-primary add-rule" type="button">条件追加</button>
            <?php endif; ?>

          </td>
        </tr>
      </table>
    </div>
    <script>
      jQuery(function($) {
        const loading = $(`<div class="lds-facebook"><div></div><div></div><div></div></div>`);
        const rules = $("#rules");
        let key = <?php echo $keyRule; ?>;
        $("#rules").on('click', ".remove-rule", function() {
          if (confirm("追加した条件設定を消去しますか？")) {
            $(this).closest(".rule").slideUp(500, function() {
              $(this).remove();
            });
          }
        });

        $("#rules").on('click', '.rule-title .label, .rule-title .text', function() {
          const rule = $(this).closest('.rule');
          let business_type = [];
          let location = [];
          let business_form = [];
          let experience = [];
          let receivable_notify = [];


          $(rule).find('.business_type:checked').each(function(i) {
            business_type[i] = $(this).val();
          });

          if ($(rule).find('.radio_location:checked').val() == 1) {
            location = ["全県"];
          } else {
            $(rule).find('.location_input:checked').each(function(i) {
              location[i] = $(this).val();
            });
          }

          $(rule).find('.business_form:checked').each(function(i) {
            business_form[i] = $(this).val();
          });

          $(rule).find('.experience:checked').each(function(i) {
            experience[i] = $(this).val();
          });

          const receivable_amount_from = $(rule).find('.receivable_amount_from').val();
          const receivable_amount_to = $(rule).find('.receivable_amount_to').val();

          $(rule).find('.receivable_notify:checked').each(function(i) {
            receivable_notify[i] = $(this).val();
          });

          $(rule).find('.text-business_type').text(business_type);
          $(rule).find('.text-location').text(location);
          $(rule).find('.text-business_form').text(business_form);
          $(rule).find('.text-experience').text(experience);
          $(rule).find('.text-receivable_amount_from').text(receivable_amount_from);
          $(rule).find('.text-receivable_amount_to').text(receivable_amount_to);
          $(rule).find('.text-receivable_notify').text(receivable_notify);
          $(rule).closest('.rule').find(".rule-title .text").slideToggle();
          $(rule).closest('.rule').find(".rule-content").slideToggle();
        });

        $(".add-rule").click(function() {
          $.ajax({
            url: '<?php echo site_url() . '/wp-admin/admin-ajax.php'; ?>',
            data: {
              action: 'get_new_rule_template',
              key: key
            },
            type: 'POST',
            beforeSend: function() {
              loading.appendTo(rules);
            },
            success: function(ruleTemplate) {
              rules.append(ruleTemplate)
              key++;
            }
          }).always(() => {
            loading.remove();
          });
        });


        $("#rules").on('change', ".radio_location", function() {
          const val = $(this).val();
          const list_location = $(this).closest('td').find('.list_location');
          if (val == "1") {
            list_location.slideUp();
          } else {
            list_location.slideDown();
          }
        });

        $("#rules").on('click', ".checkall", function() {
          $(this).closest('td').find('.list_location input:checkbox').not(this).prop('checked', this.checked);
        })
      })
    </script>
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
  if (!is_array($array)) return;
  echo in_array($option, $array) ? "checked" : "";
}
