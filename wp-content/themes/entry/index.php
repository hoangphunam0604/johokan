<? exit(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <?php wp_head(); ?>
</head>

<body>
  <h2>Check Company</h2>
  <form action="" method="POST">

    <input type="hidden" name="action" value="get_list_sub_admin" />
    <input type="hidden" name="entry_client" value="mumbai-central" />
    <div class="form-group" bis_skin_checked="1">
      <label>①</label>
      <select name="business_type" class="require background">
        <option value="">あなたの事業種別を選択</option>
        <option value="法人" selected>法人</option>
        <option value="個人事業">個人事業</option>
      </select>
      <div class="error" bis_skin_checked="1">事業種別を選択してください</div>
    </div>
    <div class="form-group" bis_skin_checked="1">
      <label>②</label>
      <select name="location" class="require">
        <option value="">あなたの事業所がある都道府県を選択</option>
        <option value="北海道" selected>北海道</option>
        <option value="青森県">青森県</option>
        <option value="岩手県">岩手県</option>
        <option value="宮城県">宮城県</option>
        <option value="秋田県">秋田県</option>
        <option value="山形県">山形県</option>
        <option value="福島県">福島県</option>
        <option value="茨城県">茨城県</option>
        <option value="栃木県">栃木県</option>
        <option value="群馬県">群馬県</option>
        <option value="埼玉県">埼玉県</option>
        <option value="千葉県">千葉県</option>
        <option value="東京都">東京都</option>
        <option value="神奈川県">神奈川県</option>
        <option value="新潟県">新潟県</option>
        <option value="富山県">富山県</option>
        <option value="石川県">石川県</option>
        <option value="福井県">福井県</option>
        <option value="山梨県">山梨県</option>
        <option value="長野県">長野県</option>
        <option value="岐阜県">岐阜県</option>
        <option value="静岡県">静岡県</option>
        <option value="愛知県">愛知県</option>
        <option value="三重県">三重県</option>
        <option value="滋賀県">滋賀県</option>
        <option value="京都府">京都府</option>
        <option value="大阪府">大阪府</option>
        <option value="兵庫県">兵庫県</option>
        <option value="奈良県">奈良県</option>
        <option value="和歌山県">和歌山県</option>
        <option value="鳥取県">鳥取県</option>
        <option value="島根県">島根県</option>
        <option value="岡山県">岡山県</option>
        <option value="広島県">広島県</option>
        <option value="山口県">山口県</option>
        <option value="徳島県">徳島県</option>
        <option value="香川県">香川県</option>
        <option value="愛媛県">愛媛県</option>
        <option value="高知県">高知県</option>
        <option value="福岡県">福岡県</option>
        <option value="佐賀県">佐賀県</option>
        <option value="長崎県">長崎県</option>
        <option value="熊本県">熊本県</option>
        <option value="大分県">大分県</option>
        <option value="宮崎県">宮崎県</option>
        <option value="鹿児島県">鹿児島県</option>
        <option value="沖縄県">沖縄県</option>
      </select>
      <div class="error" bis_skin_checked="1">都道府県を選択してください</div>
    </div>
    <div class="entry-form-step-body" bis_skin_checked="1">
      <div class="question" bis_skin_checked="1">Q1. お取引先企業（売掛先）の事業種別</div>
      <div class="answer-list" bis_skin_checked="1">
        <input type="radio" id="accounts_receivable-0" name="accounts_receivable" value="法人" checked>
        <label for="accounts_receivable-0">
          <span>法人</span>
        </label>
        <input type="radio" id="accounts_receivable-1" name="accounts_receivable" value="個人事業">
        <label for="accounts_receivable-1">
          <span>個人事業</span>
        </label>
      </div>
    </div>
    <div class="entry-form-step-body" bis_skin_checked="1">
      <div class="question" bis_skin_checked="1">Q2. お取引先企業（売掛先）の事業種別②</div>
      <div class="answer-list" bis_skin_checked="1">
        <input type="radio" id="company_account-0" name="company_account" value="上場企業" checked>
        <label for="company_account-0">
          <span>上場企業</span>
        </label>
        <input type="radio" id="company_account-1" name="company_account" value="非上場企業">
        <label for="company_account-1">
          <span>非上場企業</span>
        </label>
      </div>
    </div>
    <div class="entry-form-step-body" bis_skin_checked="1">
      <div class="question" bis_skin_checked="1">Q3. お取引先企業（売掛先）への通知</div>
      <div class="answer-list" bis_skin_checked="1">
        <input type="radio" id="notification-0" name="notification" value="ＯＫ" checked>
        <label for="notification-0">
          <span>ＯＫ</span>
        </label>
        <input type="radio" id="notification-1" name="notification" value="ＮＧ">
        <label for="notification-1">
          <span>ＮＧ</span>
        </label>
      </div>
    </div>
    <div class="entry-form-step-body" bis_skin_checked="1">
      <div class="question" bis_skin_checked="1">Q4. ファクタリングのご利用経験</div>
      <div class="answer-list" bis_skin_checked="1">
        <input type="radio" id="experience-0" name="experience" value="有り" checked>
        <label for="experience-0">
          <span>有り</span>
        </label>
        <input type="radio" id="experience-1" name="experience" value="無し">
        <label for="experience-1">
          <span>無し</span>
        </label>
      </div>
    </div>
    <div class="entry-form-step-body" bis_skin_checked="1">
      <div class="question" bis_skin_checked="1">Q5. あなたの事業の年商を選択</div>
      <div class="answer-list" bis_skin_checked="1">
        <input type="radio" id="yearly_quotient-0" name="yearly_quotient" value="1000万円未満" checked> 
        <label for="yearly_quotient-0">
          <span>1000万円未満</span>
        </label>
        <input type="radio" id="yearly_quotient-1" name="yearly_quotient" value="1000万円以上">
        <label for="yearly_quotient-1">
          <span>1000万円以上</span>
        </label>
        <input type="radio" id="yearly_quotient-2" name="yearly_quotient" value="5000万円以上">
        <label for="yearly_quotient-2">
          <span>5000万円以上</span>
        </label>
        <input type="radio" id="yearly_quotient-3" name="yearly_quotient" value="1億円以上">
        <label for="yearly_quotient-3">
          <span>1億円以上</span>
        </label>
      </div>
    </div>
    <div class="entry-form-step-body" bis_skin_checked="1">
      <div class="question" bis_skin_checked="1">Q6. あなたの創業年数を選択</div>
      <div class="answer-list" bis_skin_checked="1">
        <input type="radio" id="establishment-0" name="establishment" value="1年未満" checked>
        <label for="establishment-0">
          <span>1年未満</span>
        </label>
        <input type="radio" id="establishment-1" name="establishment" value="1年以上">
        <label for="establishment-1">
          <span>1年以上</span>
        </label>
        <input type="radio" id="establishment-2" name="establishment" value="5年以上">
        <label for="establishment-2">
          <span>5年以上</span>
        </label>
      </div>
    </div>

    <button name="submit">Gửi</button>
  </form>

  <hr>
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

    <style type="text/css">
      .entry_form {
        border-collapse: collapse;
        width: 100%;
      }

      .entry_form th {
        text-align: left;
        vertical-align: top;
      }

      .entry_form th,
      .entry_form td {
        padding: 5px 10px;
      }

      .entry_form select,
      .entry_form input,
      .entry_form textarea {
        min-width: 500px;
        height: 36px;
      }

      .entry_form textarea {
        height: 100px;
      }
    </style>
    <table class="entry_form">
      <?php foreach ($entry_form_fields as $key => $field) :
        $value = get_post_meta($post->ID, $key, true);
      ?>
        <input type="hidden" name="accept" value="accept" />
        <input type="hidden" name="entry_client" value="mumbai-central" />
        <tr>
          <th style="width: 250px"><?php echo $field["name"]; ?></th>
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