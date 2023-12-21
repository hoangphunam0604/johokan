jQuery(function ($) {
  $("#wp-admin-bar-my-account>a").attr('href', 'javascript:void(0);');
  $("#screen-meta-links,#screen-met,.user-rich-editing-wrap,  .user-syntax-highlighting-wrap,  .user-admin-color-wrap,  .user-comment-shortcuts-wrap,  .show-admin-bar.user-admin-bar-front-wrap,  .user-language-wrap").remove();
  const alink = $("#wp-admin-bar-logout").html();
  console.log(alink);
  $("#wp-admin-bar-logout").clone().insertBefore("#collapse-menu").find("a").addClass('menu-top').html(`<div class="wp-menu-image dashicons-before dashicons-arrow-left" aria-hidden="true" "><br></div><div class="wp-menu-name" >ログアウト</div>`)

});