<?php global $locations; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <?php wp_head(); ?>
  <style>
    input[type="text"],
    input[type="date"],
    input[type="datetime-local"],
    input[type="time"],
    input[type="email"],
    input[type="tel"],
    textarea,
    select {
      box-sizing: border-box;
      min-width: 500px;
      font-size: 18px;
      border: 2px solid #da6e02;
      line-height: 1em;
      height: 46px;
      padding: 7px 15px;
      background-color: #f7f7f7;
    }

    .entry_form {
      border-collapse: collapse;
      width: 100%;
    }

    .entry_form th {
      text-align: left;
      vertical-align: top;
      width: 300px;
    }

    .entry_form th,
    .entry_form td {
      padding: 5px 10px;
    }

    .entry_form textarea {
      height: 100px;
    }
  </style>
</head>

<body>
  <h2>Check Company</h2>
  <form action="" method="POST">

    <input type="hidden" name="entry_action" value="get_companies" />
    <input type="hidden" name="entry_client" value="johokan" />
    <table class="entry_form">
      <tr>
        <th>あなたの事業形態を選択</th>
        <td>
          <select name="business_type" required>
            <option value="法人">法人</option>
            <option value="個人事業主">個人事業主</option>
            <option value="フリーランス">フリーランス</option>
          </select>
        </td>
      </tr>
      <tr>
        <th>
          所在地を選択
        </th>
        <td>
          <select name="location" class="require">
            <?php foreach ($locations as $location) : ?>
              <option value="<?php echo $location; ?>"><?php echo $location; ?></option>
            <?php endforeach; ?>
          </select>
          </div>
        </td>
      </tr>
      <tr>
        <th>売掛先の事業形態</th>
        <td>
          <select name="business_form" required>
            <option value="法人">法人</option>
            <option value="個人事業主">個人事業主</option>
            <option value="その他">その他</option>
          </select>
        </td>
      </tr>
      <tr>
        <th>ファクタリングのご利用経験</th>
        <td>
          <select name="experience" required>
            <option value="有り">有り</option>
            <option value="無し">無し</option>
          </select>
        </td>
      </tr>
      <tr>
        <th colspan="2">
          <hr>
        </th>
      </tr>
      <tr>
        <th>売掛債権の金額</th>
        <td>
          <input value="10000" id="receivable_amount" inputmode="numeric" name="receivable_amount" type="text" data-error="#error_receivable_amount" required placeholder=" 「例：100」">
          <span class="unit">万円</span>
        </td>
      </tr>
      <tr>
        <th>売掛先への債権譲渡通知は可能ですか？</th>
        <td>
          <div class="radio-wrap">
            <label>
              <input type="radio" name="receivable_notify" value="可能（三社間取引）" checked>
              <span>可能（三社間取引）</span>
            </label>
            <label>
              <input type="radio" name="receivable_notify" value="不可（二社間取引）">
              <span>不可（二社間取引）</span>
            </label>
          </div>
        </td>
      </tr>
    </table>

    <button name="submit">Gửi</button>
  </form>

  <hr>
  <br>
  <br>
  <br>
  <br>
  <br>
  <h2>CHECK INSERT</h2>
  <form action="" method="POST">
    <?php

    global $entry_form_fields;
    $data = [
      "accounts_receivable" => "法人",
      "company_account" => "非上場企業",
      "notification"  => "ＯＫ",
      "experience"  => "無し",
      "yearly_quotient" => "1000万円未満",
      "establishment" => "1年未満",
      "business_type" => "法人",
      "location"  => "千葉県",
      "amount_of_accounts"  => " 「例：100」",
      "payment_date"  => "2ヶ月以内",
      "factoring" => "来月以降",
      "company_name"  => "あなたの会社名・事業者名",
      "industry"  => "建設業",
      "contact_name"  => "ご担当者名",
      "email" => "hoangphu.nam0604@gmail.com",
      "phone_number"  => "0123456789",
      "mobile_number" => "0999969969",
      "accept"  => "accept",
      "entry_client"  => "mumbai-central",
      "other" =>  "ご質問・ご要望などご質問・ご要望などご質問\n・ご要望などご質問・ご要望などご質問・ご要望などご質問\n・ご要望などご質問\n・ご要望などご質問・ご要望など"
    ];

    ?>

    <table class="entry_form">
      <?php foreach ($entry_form_fields as $key => $field) :
        $value = get_post_meta($post->ID, $key, true);
      ?>
        <input type="hidden" name="accept" value="accept" />
        <input type="hidden" name="entry_client" value="mumbai-central" />
        <tr>
          <th><?php echo $field["name"]; ?></th>
          <td>
            <?php if (isset($field["type"])) : ?>
              <?php if ($field["type"] == "textarea") : ?>
                <textarea id="<?php echo $key; ?>" name="<?php echo $key; ?>"><?php echo $data[$key]; ?></textarea>
              <?php else : ?>
                <input id="<?php echo $key; ?>" name="<?php echo $key; ?>" type="text" value="<?php echo $data[$key]; ?>" />
              <?php endif; ?>
            <?php else : ?>
              <select id="<?php echo $key; ?>" name="<?php echo $key; ?>">
                <?php foreach ($field["options"] as  $option) : ?>
                  <option <?php get_selected($option, $value); ?> value="<?php echo $option; ?>"><?php echo $option; ?></option>
                <?php endforeach; ?>
              </select>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
    <button name="submit">Gửi</button>
  </form>
  <?php wp_footer(); ?>
</body>

</html>