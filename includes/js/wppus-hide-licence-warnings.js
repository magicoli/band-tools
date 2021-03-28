jQuery(function($) {
  // Constants must be defined before via php or here
  //
  // BNDTLS_SLUG  your plugin slug (aka directory name)
  // BNDTLS_DATA_PLUGIN the plugin file, usually BNDTLS_SLUG/BNDTLS_SLUG.php
  // BNDTLS_SHOW_HIDE the show/hide link text, eg "Show/Hide License Key"
  // BNDTLS_REGISTER_TEXT the line added below empty license field, eg "Register your plugin at https://example.com"

  if ($('body').hasClass('wppus-license-form-alter-done-' + BNDTLS_SLUG )) return;

  var installRow = $( "[data-plugin='" + BNDTLS_DATA_PLUGIN + "']");
  var licenseRow = $( ".plugin-update-tr:has([data-package_slug='" + BNDTLS_SLUG + "'])" );
  var switchClass = BNDTLS_SLUG + '-license-switch';

  if(! installRow) return;

  $(".wrap-license[data-package_slug='" + BNDTLS_SLUG + "']").each( function( index, element ) {
    element = $(element);

    if (element.find('.current-license').html().length) {
      licenseRow.hide();
      installRow.find('div.row-actions').append('<span> | <a class="'  + switchClass + '" href="#">' + BNDTLS_SHOW_HIDE + '</a></span>');
    } else {
      licenseRow.show();
      licenseRow.find('.wrap-license').append( "<p class='getlicense'>" + BNDTLS_REGISTER_TEXT + "</p>" );
    }
  });

  $( '.' + switchClass ).on('click', function(e) {
    e.preventDefault();
    licenseRow.toggle();
  });

  $('body').addClass('wppus-license-form-alter-done-' + BNDTLS_SLUG);
});
