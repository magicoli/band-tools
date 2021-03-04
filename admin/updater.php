<?php

add_action( 'admin_head', 'bndtls_alter_license_notice', 99, 0 );
function bndtls_alter_license_notice() {
  global $wppus_alter_license_form;

  if ( $wppus_alter_license_form['band-tools'] ) {

    return;
  }

  ?>
  <style>
    /* .button.wppus-license-switch {
      margin-left: 5px;
      font-weight: normal;
    } */
    /* .hidden {
      display: none;
    }
    #wrap_license_band-tools* {
      display: none;
    } */
  </style>
  <script type="text/javascript">
    jQuery(function($) {

      if ($('body').hasClass('wppus-license-form-alter-done-band-tools')) {
        return;
      }

      var licenseRow = $( ".plugin-update-tr:has([data-package_slug='band-tools'])" );
      var installRow = $( "[data-slug='band-tools']");
      if(! installRow) return;

      $(".wrap-license[data-package_slug='band-tools']").each( function( index, element ) {
        element = $(element);

        if (element.find('.current-license').html().length) {
          var buttonText = "<?php echo esc_html_e( 'License key', 'band-tools' ); ?>";

          licenseRow.hide();
          installRow.find('div.row-actions').append(' <span> | <a class="wppus-license-switch band-tools" href="#">' + buttonText + '</a></span>');
        } else {
          licenseRow.show();
          var RegisterText = "<?php echo sprintf(__('Register on %s to get a license key', 'band-tools'), '<a href=https://magiiic.com/wordpress/plugins/band-tools-by-magiiic/>Magiiic.com</a>'); ?>";
          licenseRow.find('.wrap-license').append( "<p class='getlicense'>" + RegisterText + "</p>" );
        }
      });

      $('.wppus-license-switch.band-tools').on('click', function(e) {
        e.preventDefault();
        licenseRow.toggle();
      });

      $('body').addClass('wppus-license-form-alter-done-band-tools');
    });

  </script>
  <?php

  $wppus_alter_license_form['band-tools'] = true;
}
