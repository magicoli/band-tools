<div class="wrap">
	<h1><?php echo sprintf(__('%s settings', 'band-tools'), 'Band Tools'); ?></h1>
	<!-- <h1>OpenSimulator</h1> -->
  <?php screen_icon(); ?>
	<form method="post" action="options.php">
		<?php settings_fields( 'band_tools' ); ?>
		<table class=form-table>
<?php
			// $export_url = esc_url( add_query_arg(
			//   $export_url
			// ));
			if(!get_option('bndtls_token')) {
				update_option('bndtls_token', substr(md5(openssl_random_pseudo_bytes(20)),-20));
			}

			if(get_option('bndtls_licence_key') !="" && get_option('bndtls_token') !="") {
				$export_url_csv = esc_url( add_query_arg(
					array(
						'page' => 'band-tools-talents',
						'hash' => hash("md5", get_option('bndtls_licence_key').get_option('bndtls_token')),
						'export' => 'csv',
					),
					get_admin_url() . "admin.php"
				));
				$export_url_vcf = esc_url( add_query_arg(
					array(
						'page' => 'band-tools-talents',
						'hash' => hash("md5", get_option('bndtls_licence_key').get_option('bndtls_token')),
						'export' => 'vcf',
					),
					get_admin_url() . "admin.php"
				));
				update_option('bndtls_export_vcf', $export_url_vcf);
			}
			update_option('bndtls_export_url', $export_url_csv);

			foreach ($CastingDirectorOptions as $category => $options) {
				do_settings_sections( 'bndtls_sections' );
?>
      <!-- Menu Categories section -->
<?php		if($category!='default') { ?>
					<tr><th colspan=2>
						<h2><?php _e($category);?></h2>
					</th></tr>
<?php
				}
				foreach ($options as $option => $args) {
					$before="";
					$after="";
					$scripts="";
					// $type=($type=='boolean') ? 'checkbox' : $type;
					$default=$args['default'];
					$name=$args['name'];
					$checked=get_option($option) ? "checked" : "";
					$value=get_option($option);
					$value=$value ? $value : $default;
					$label=($args['label']) ? $args['label'] : $name;
					$label="<label for='$option'>" . __("$label", 'band-tools') . "</label>";
					$type=$args['type'];
					$description=($args['description']) ? "<p id='$option-description' class=description>{$args['description']}</p>" : "";
					$readonly=($args['readonly']) ? "readonly" : "";
					if($args['copylink']) {
						$scripts.="jQuery('[id*=\"$option\"]')[0].select();document.execCommand('copy');";
						$class.=" copylink";
					}
					switch ($type) {
						case 'boolean':
							$type='checkbox';
							if($args['label']) {
								$before=$name;
								$after=$label;
							} else {
								unset($before);
								$after=$label;
							}
							if($readonly) $onclick="onclick='return false;'";
							// $before=$name;
							$input="<input id='$option' name='$option' type='$type' $checked $readonly $onclick />";
							// $after=$label;
							break;

						case 'showlink':
						  $before=$name;
							$input="<a href='$value'>$value</a>";
							break;

						case 'string';
						case '';
						case NULL;
							$type='text';
						default:
						  $class.="regular-text $class";
							$input="<input id='$option' name='$option' type='$type' class='$class' value='$value' $onclick $readonly/>";
							$before=$label;
							break;
					}
					if($scripts) $scripts="<script type='text/javascript'>$scripts</script>";
					echo "
					<tr valign='top'>
						<th scope='row'>$before</th>
						<td>
						$input$after
						$description
						$scripts
						</td>
					</tr>";
 				};
			};
?>
		</table>
		<?php
		if ( current_user_can( 'manage_options' ) ) {
			submit_button();
		}
		?>
	</form>
</div>
