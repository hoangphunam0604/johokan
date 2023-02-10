<?php 
add_action( 'admin_menu', "admin_menu" );

function admin_menu() {
  add_submenu_page("edit.php?post_type=entry",__('送信フォーム設定Setting entry form',"luxeritas"), __('設定',"luxeritas"), 'administrator', 'entry-form-setting', 'admin_page');
}
function admin_page() {
/* 
  $admin_role_set = get_role( 'administrator' )->capabilities;
  var_dump($admin_role_set);
  echo "<br />";
  $admin_role_set = get_role( 'sub-admin' )->capabilities;
  var_dump($admin_role_set);
 */
    if ($_POST) {
        if ( ! wp_verify_nonce( trim( $_POST['entry_form__nonce'] ), 'entry_form__nonce' ) ) {
            wp_die('Security check not passed!');
        }
        $option = array();

        $option["from_email"] = sanitize_email( trim( $_POST['from_email'] ) );
        $option["from_name"] = sanitize_text_field( trim( $_POST['from_name'] ) );

        $option["admin_to"] = sanitize_email( trim( $_POST['admin_to'] ) );
        $option["admin_bcc"] = sanitize_email( trim( $_POST['admin_bcc'] ) );

        $option["admin_subject"] = sanitize_text_field( trim( $_POST['admin_subject'] ) );

        $option["subadmin_subject"] = sanitize_text_field( trim( $_POST['subadmin_subject'] ) );
        $option["admin_message"] = sanitize_textarea_field(  trim($_POST['admin_message']  ));

        $option["customer_subject"] = sanitize_text_field( trim( $_POST['customer_subject'] ) );
        $option["customer_message"] = sanitize_textarea_field(  trim($_POST['customer_message']  ));

        update_option("entry_form_options", $option);
        echo '<div id="message" class="updated fade"><p><strong>'.__("Saved setting!","luxeritas").'</strong></p></div>';
    }
    $ws_nonce = wp_create_nonce('entry_form__nonce');
    $sfOption = get_option( 'entry_form_options' );
  ?>  
    <h2>送信フォーム設定</h2>
    <div>
        <form action="" method="post" enctype="multipart/form-data" name="entry_form__form">
        <h3><?php _e("FROM");?></h3>
	        <table class="form-table">
	            <tr valign="top">
	                <th scope="row">
	                   <?php _e("FROM email","luxeritas");?>
	                </th>
	                <td>
	                    <label>
	                        <input type="email" name="from_email" value="<?php echo $sfOption['from_email'];?>" size="43" style="width:400px;height:36px;" required />
	                    </label>
	                </td>
	            </tr>
              <tr valign="top">
	                <th scope="row">
	                   <?php _e("FROM Name","luxeritas");?>
	                </th>
	                <td>
                      <label>
	                        <input type="text" name="from_name" value="<?php echo $sfOption['from_name'];?>" size="43" style="width:400px;height:36px;" required />
	                    </label>
	                </td>
	            </tr>
          </table>
        	<h3><?php _e("管理者のメールアドレス設定","luxeritas");?></h3>
	        <table class="form-table">
	            <tr valign="top">
	                <th scope="row">
	                   <?php _e("送信先","luxeritas");?>
	                </th>
	                <td>
	                    <label>
	                        <input type="email" name="admin_to" value="<?php echo $sfOption['admin_to'];?>" size="43" style="width:400px;height:36px;" required />
	                    </label>
	                </td>
	            </tr>
              <tr valign="top">
	                <th scope="row">
	                   <?php _e("送信先BCC","luxeritas");?>
	                </th>
	                <td>
                      <label>
	                        <input type="email" name="admin_bcc" value="<?php echo $sfOption['admin_bcc'];?>" size="43" style="width:400px;height:36px;" required />
	                    </label>
	                </td>
	            </tr>
	            <tr valign="top">
	                <th scope="row">
	                	<?php _e("通信メールタイトル","luxeritas");?>
	                </th>
	                <td>
	                    <label>
	                        <input type="text" name="admin_subject" value="<?php echo $sfOption['admin_subject'];?>" size="43" style="width:400px;height:36px;" required />
	                    </label>
	                </td>
	            </tr>
	            <tr valign="top">
	                <th scope="row">
	                	<?php _e("副管理者用通信メールタイトル","luxeritas");?>
	                </th>
	                <td>
	                    <label>
	                        <input type="text" name="subadmin_subject" value="<?php echo $sfOption['subadmin_subject'];?>" size="43" style="width:400px;height:36px;" required />
	                    </label>
	                </td>
	            </tr>
	            <tr valign="top">
	                <th scope="row">
	                	<?php _e("通信メール内容","luxeritas");?>
	                </th>
	                <td>
	                    <label>
	                        <textarea type="text" name="admin_message" value="" cols="45" rows="3"
	                                  style="width:400px;height:200px;" required><?php echo $sfOption['admin_message'];?></textarea>
	                        <p>
	                        	<?php _e("{content} is a substitute for input","luxeritas");?>
	                        </p>
	                    </label>
	                </td>
	            </tr>
	        </table>
	        <h3><?php _e("お客様側の通信メール設定","luxeritas");?></h3>
	        <table class="form-table">
	            <tr valign="top">
	                <th scope="row">
	                	<?php _e("通信メールタイトル","luxeritas");?>
	                </th>
	                <td>
	                    <label>
	                        <input type="text" name="customer_subject" value="<?php echo $sfOption['customer_subject'];?>" size="43" style="width:400px;height:36px;" required />
	                    </label>
	                </td>
	            </tr>
	            <tr valign="top">
	                <th scope="row">
	                	<?php _e("通信メール内容","luxeritas");?>
	                </th>
	                <td>
	                    <label>
	                        <textarea type="text" name="customer_message" value="" cols="45" rows="3"
	                                  style="width:400px;height:200px;" required><?php echo $sfOption['customer_message'];?></textarea>
	                        <p>
	                        	<?php _e("{content} is a substitute for input","luxeritas");?>
	                        </p>
	                    </label>
	                </td>
	            </tr>
	        </table>
        <p class="submit">
            <input type="hidden" name="entry_form__nonce" value="<?php echo $ws_nonce; ?>"/>
            <input type="submit" class="button-primary" value="<?php _e('更新', 'wp-smtp'); ?>"/>
        </p>
        </form>
    </div>
  <?php
}
