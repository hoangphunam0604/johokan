<?php

add_action('wp_ajax_get_new_rule_template', 'ajax_get_new_rule_template');
add_action('wp_ajax_nopriv_get_new_rule_template', 'ajax_get_new_rule_template');

function ajax_get_new_rule_template()
{
  $key = $_POST['key'];
  getRuleTemplate($key, [], true);
  exit;
}


function getRuleTemplate($key, $rule = [], $open = false)
{
  $default = [
    'business_type' =>  '',
    'location' =>  [],
    'business_form' =>  '',
    'experience'  =>  '',
    'receivable_amount_from'  =>  '',
    'receivable_amount_to'  =>  '',
    'receivable_notify'  =>  '',
  ];
  global $locations;
  $rule = wp_parse_args($rule, $default);
  $business_type = $rule['business_type'];
  $location = $rule['location'];
  $business_form = $rule['business_form'];
  $experience = $rule['experience'];
  $receivable_amount_from = $rule['receivable_amount_from'];
  $receivable_amount_to = $rule['receivable_amount_to'];
  $receivable_notify = $rule['receivable_notify'];

  if (!is_array($location))
    $location = [];
  $checkall = "";
  $other_checked = "";
  if ($location == ["全県"])
    $checkall = "checked";
  if (!empty($location) && $location[0] != "全県") :
    $checkall = "";
    $other_checked = "checked";
  endif;
?>
  <div class="rule <?php echo $open ? "open" : ""; ?>">
    <div class="rule-title">
      <div class="label">条件設定</div>
      <div class="text">
        <p>■あなたの事業形態を選択: <strong class="text-business_type"><?php echo $business_type; ?></strong></p>
        <p>■所在地を選択: <strong class="text-location"><?php echo implode(",", $location); ?></strong></p>
        <p>■売掛先の事業形態: <strong class="text-business_form"><?php echo $business_form; ?></strong></p>
        <p>■ファクタリングのご利用経験: <strong class="text-experience"><?php echo $experience; ?></strong></p>
        <p>■売掛債権の金額:
          <strong class="text-receivable_amount_from"><?php echo $receivable_amount_from; ?></strong> -
          <strong class="text-receivable_amount_to"><?php echo $receivable_amount_to; ?></strong>
        </p>
        <p>■売掛先への債権譲渡通知は可能ですか？: <strong class="text-receivable_notify"><?php echo $receivable_notify; ?></strong></p>
      </div>
      <button type="button" class="remove-rule">消去</button>
    </div>
    <div class="rule-content">
      <table class="form-table">
        <tr>
          <th>あなたの事業形態を選択</th>
          <td>
            <select name="rules[<?php echo $key; ?>][business_type]" class="business_type">
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
            <label>
              <input type="radio" name="rules[<?php echo $key; ?>][radio_location]" value="1" class="radio_location" <?php echo $checkall; ?> />
              全県
            </label>
            <label>
              <input type="radio" name="rules[<?php echo $key; ?>][radio_location]" value="0" class="radio_location" <?php echo $other_checked; ?> />
              各都道府県
            </label>
            <div class="list_location <?php echo $other_checked; ?>" style="background-color: #ddd;min-height:200px;overflow:hidden;margin-top: 15px">
              <div class="group-all">
                <label><input type="checkbox" class="checkall"> すべて選択</label>
              </div>
              <hr />
              <?php foreach ($locations as  $option) : ?>
                <div class="location">
                  <label>
                    <input type="checkbox" class="location_input" name="rules[<?php echo $key; ?>][location][]" value="<?php echo $option; ?>" <?php check_checked_array($option, $location); ?> />
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
            <select name="rules[<?php echo $key; ?>][business_form]" class="business_form">
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
            <select name="rules[<?php echo $key; ?>][experience]" class="experience">
              <option value="">あなたの事業形態を選択</option>
              <option value="有り" <?php get_selected("有り", $experience); ?>>有り</option>
              <option value="無し" <?php get_selected("無し", $experience); ?>>無し</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>売掛債権の金額</th>
          <td>
            <input type="tel" class="receivable_amount_from regular-text" name="rules[<?php echo $key; ?>][receivable_amount_from]" value="<?php echo $receivable_amount_from; ?>">万円
            <br>-<br>
            <input type="tel" class="receivable_amount_to regular-text" name="rules[<?php echo $key; ?>][receivable_amount_to]" value="<?php echo $receivable_amount_to; ?>">万円
          </td>
        </tr>
        <tr>
          <th>売掛先への債権譲渡通知は可能ですか？</th>
          <td>
            <label>
              <input type="radio" class="receivable_notify" name="rules[<?php echo $key; ?>][receivable_notify]" value="可能（三社間取引）" <?php check_checked_array($receivable_notify, ["可能（三社間取引）"],); ?> />
              可能（三社間取引）
            </label>
            <label>
              <input type="radio" class="receivable_notify" name="rules[<?php echo $key; ?>][receivable_notify]" value="不可（二社間取引）" <?php check_checked_array($receivable_notify, ["不可（二社間取引）"]); ?> />
              不可（二社間取引）
            </label>
          </td>
        </tr>
      </table>
    </div>
  </div>
<?php
}
