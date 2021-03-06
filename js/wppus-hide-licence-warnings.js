// var BNDTLS_SLUG = 'band-tools';
// var BNDTLS_DATA_SLUG = BNDTLS_SLUG; // calculated from plugin name, might be different from slug
// var BNDTLS_DATA_PLUGIN = 'band-tools/band-tools.php';
// var BNDTLS_TXDOM = BNDTLS_SLUG; // translation text domain, might be different from slug
// var BNDTLS_REGISTER_TEXT = 'Register'; // translation text domain, might be different from slug

// var today = new Date();
// alert('BNDTLS_SLUG = ' + BNDTLS_SLUG + "\n" + today);

const { __, _x, _n, _nx } = wp.i18n;

jQuery(function($) {
  // Set same values as PHP constants defined in admin/init.php
  if ($('body').hasClass('wppus-license-form-alter-done-' + BNDTLS_SLUG )) return;

  // var buttonText = __( 'Show/Hide License key', BNDTLS_TXDOM );

  var installRow = $( "[data-plugin='" + BNDTLS_DATA_PLUGIN + "']");
  var licenseRow = $( ".plugin-update-tr:has([data-package_slug='" + BNDTLS_SLUG + "'])" );

  if(! installRow) return;

  $(".wrap-license[data-package_slug='" + BNDTLS_SLUG + "']").each( function( index, element ) {
    element = $(element);

    if (element.find('.current-license').html().length) {
      licenseRow.hide();
      installRow.find('div.row-actions').append('<span> | <a class="wppus-license-switch ' + BNDTLS_SLUG + '" href="#">' + BNDTLS_SHOW_HIDE + '</a></span>');
    } else {
      licenseRow.show();
      licenseRow.find('.wrap-license').append( "<p class='getlicense'>" + BNDTLS_REGISTER_TEXT + "</p>" );
    }
  });

  $('.wppus-license-switch.' + BNDTLS_SLUG).on('click', function(e) {
    e.preventDefault();
    licenseRow.toggle();
  });

  $('body').addClass('wppus-license-form-alter-done-' + BNDTLS_SLUG);
});
