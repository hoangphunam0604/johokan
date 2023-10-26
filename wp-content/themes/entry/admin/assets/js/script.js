jQuery(function ($) {
  $("#wp-admin-bar-my-account>a").attr('href', 'javascript:void(0);');
  $("#screen-meta-links,#screen-met,.user-rich-editing-wrap,  .user-syntax-highlighting-wrap,  .user-admin-color-wrap,  .user-comment-shortcuts-wrap,  .show-admin-bar.user-admin-bar-front-wrap,  .user-language-wrap,").remove();
})