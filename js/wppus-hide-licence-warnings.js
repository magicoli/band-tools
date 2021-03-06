const { __, _x, _n, _nx } = wp.i18n;

jQuery(function($) {
  // Set same values as PHP constants defined in admin/init.php
  var BNDTLS_SLUG = 'band-tools';
  var BNDTLS_DATA_SLUG = BNDTLS_SLUG; // calculated from plugin name, might be different from slug
  var BNDTLS_TXDOM = BNDTLS_SLUG; // translation text domain, might be different from slug

  var buttonText = __( 'Show/Hide License key', BNDTLS_TXDOM );

  // __( '__', BNDTLS_TXDOM );
  // _x( '_x', '_x_context', BNDTLS_TXDOM );
  // _n( '_n_single', '_n_plural', number, BNDTLS_TXDOM );
  // _nx( '_nx_single', '_nx_plural', number, '_nx_context', BNDTLS_TXDOM );

  var licenseRow = $( ".plugin-update-tr:has([data-package_slug='" + BNDTLS_SLUG + "'])" );
  var installRow = $( "[data-slug='" + BNDTLS_DATA_SLUG + "']");
  // installRow.hide();

  if ($('body').hasClass('wppus-license-form-alter-done-' + BNDTLS_SLUG )) {
    return;
  }

  if(! installRow) return;

  $(".wrap-license[data-package_slug='" + BNDTLS_SLUG + "']").each( function( index, element ) {
    element = $(element);

    if (element.find('.current-license').html().length) {
      // var buttonText = 'License key';

      licenseRow.hide();
      // installRow.hide();
      installRow.find('div.row-actions').append('<span> | <a class="wppus-license-switch ' + BNDTLS_SLUG + '" href="#">' + buttonText + '</a></span>');
      // licenseRow.find('.wrap-license').append(' <span> | <a class="wppus-license-switch ' + BNDTLS_SLUG + '" href="#">' + buttonText + '</a></span>' + " debug " + "[data-slug='" + BNDTLS_DATA_SLUG + "']");
    } else {
      licenseRow.show();
      licenseRow.find('.wrap-license').append( "<p class='getlicense'><?=bndtls_REGISTER_TEXT?></p>" );
    }
  });

  $('.wppus-license-switch.' + BNDTLS_SLUG).on('click', function(e) {
    e.preventDefault();
    licenseRow.toggle();
  });

  $('body').addClass('wppus-license-form-alter-done-' + BNDTLS_SLUG);
});
