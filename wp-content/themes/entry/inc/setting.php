<?php 
global $locations;
global $entry_form_fields;
$locations = array(
	"北海道",
	"青森県",
	"岩手県",
	"宮城県",
	"秋田県",
	"山形県",
	"福島県",
	"茨城県",
	"栃木県",
	"群馬県",
	"埼玉県",
	"千葉県",
	"東京都",
	"神奈川県",
	"新潟県",
	"富山県",
	"石川県",
	"福井県",
	"山梨県",
	"長野県",
	"岐阜県",
	"静岡県",
	"愛知県",
	"三重県",
	"滋賀県",
	"京都府",
	"大阪府",
	"兵庫県",
	"奈良県",
	"和歌山県",
	"鳥取県",
	"島根県",
	"岡山県",
	"広島県",
	"山口県",
	"徳島県",
	"香川県",
	"愛媛県",
	"高知県",
	"福岡県",
	"佐賀県",
	"長崎県",
	"熊本県",
	"大分県",
	"宮崎県",
	"鹿児島県",
	"沖縄県",
);
$entry_form_fields = array(
  "business_type"    =>  array(
      "name" =>  "あなたの事業種別を選択",
      "options"   =>  array("法人","個人事業"),
      "filter"	=>	true,
  ),
  "location"    =>  array(
      "name" =>  "あなたの事業所がある都道府県を選択",
      "options"   => $locations,
      "filter"	=>	true,
  ),
   "accounts_receivable"    =>  array(
      "name" =>  "お取引先企業（売掛先）の事業種別",
      "options"   =>  array("法人","個人事業"),
      "filter"	=>	true,
  ),
  "company_account"    =>  array(
      "name" =>  "お取引先企業（売掛先）の事業種別②",
      "options"   =>  array("上場企業","非上場企業"),
      "filter"	=>	true,
  ),
  "notification"    =>  array(
      "name" =>  "お取引先企業（売掛先）への通知",
      "options"   =>  array("ＯＫ","ＮＧ"),
      "filter"	=>	true,
  ),
  "experience"    =>  array(
      "name" =>  "ファクタリングのご利用経験",
      "options"   =>  array("有り","無し"),
      "filter"	=>	true,
  ),
  "yearly_quotient"    =>  array(
      "name" =>  "あなたの事業の年商を選択",
      "options"   =>  array("1000万円未満","1000万円以上","5000万円以上","1億円以上")
  ),
  "establishment"	=>	array(
    "name"	=>	"あなたの創業年数を選択",
    "options"	=>	array("1年未満","1年以上","5年以上")
  ),
  "amount_of_accounts"	=>	array(
    "name"	=>	"ファクタリング査定をご希望される売掛債権の金額",
    "type"	=>	"input"
  ),
  "payment_date"	=>	array(
    "name"	=>	"売掛金のご入金予定日",
    "options"	=>	array("1ヶ月以内","2ヶ月以内","3ヶ月以内","それ以上")
  ),
  "factoring"	=>	array(
    "name"	=>	"ファクタリングご利用の予定時期",
    "options"	=>	array("急ぎで必要","今月中旬","今月末","来月以降")
  ),
  "company_name"	=>	array(
    "name"	=>	"あなたの会社名・事業者名",
    "type"	=>	"input"
  ),
  "industry"	=>	array(
    "name"	=>	"あなたの業種を選択",
    "options"	=>	array("建設業","医療・介護事業","ＩＴ事業","卸売・小売業","運送業","不動産業","その他")
  ),
  "contact_name"	=>	array(
    "name"	=>	"ご担当者名",
    "type"	=>	"input"
  ),
  "email"	=>	array(
    "name"	=>	"E-mail",
    "type"	=>	"input"
  ),
  "phone_number"	=>	array(
    "name"	=>	"会社（事業所）電話番号",
    "type"	=>	"input"
  ),
  "mobile_number"  =>  array(
      "name"  =>  "携帯電話番号",
      "type"  =>  "input"
  ),
  "other"	=>	array(
    "name"	=>	"ご質問・ご要望など",
    "type"	=>	"textarea"
  )
);