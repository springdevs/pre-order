<?php
// phpcs:ignoreFile
?>
<div class="wrap">
	<?php settings_errors(); ?>
	<h1><?php _e( 'Pre-Order Settings', 'sdevs_preorder' ); ?></h1>
	<p><?php _e( 'Customize pre-order options', 'sdevs_preorder' ); ?></p>
	<form method="post" action="options.php">
		<?php settings_fields( 'preorder_settings' ); ?>
		<?php do_settings_sections( 'preorder_settings' ); ?>
		<?php
			$button_positions = array(
				'default'                  => __( 'Default', 'sdevs_preorder' ),
				'after_product_image'      => __( 'After Product Image', 'sdevs_preorder' ),
				'after_product_title'      => __( 'After Product Title', 'sdevs_preorder' ),
				'before_product_title'     => __( 'Before Product Title', 'sdevs_preorder' ),
				'after_add_to_cart_button' => __( 'After Add To Cart Button', 'sdevs_preorder' ),
				'inside_description'       => __( 'Inside Description', 'sdevs_preorder' ),
			);
		?>
		<table class="form-table">
			<tbody>
				<tr>
						<th scope="row">
							<label for="preorder_label_position">
								<?php esc_html_e( 'Label position', 'sdevs_preorder' ); ?>
							</label>
						</th>
						<td>
							<select name="preorder_label_position" id="preorder_label_position" style="width: 100%;">
								<?php foreach ( $button_positions as $button_position_key => $button_position_value ) : ?>
									<option value="<?php echo $button_position_key; ?>" <?php if ( get_option( 'preorder_label_position', 'default' ) === $button_position_key ) { echo 'selected';}?>>
										<?php echo $button_position_value; ?>
									</option>
								<?php endforeach; ?>
							</select>
							<p class="description"><?php esc_html_e( 'No Date & Release Date label position', 'sdevs_preorder' ); ?></p>
						</td>
					</tr>
				<tr>
					<th scope="row">
						<label for="preorder_default_add_to_cart_txt">
							<?php esc_html_e( 'Default Add to Cart text', 'sdevs_preorder' ); ?>
						</label>
					</th>
					<td>
						<input type="text" id="preorder_default_add_to_cart_txt" name="preorder_default_add_to_cart_txt" value="<?php echo esc_html( get_option( 'preorder_default_add_to_cart_txt', 'Pre-order Now' ) ); ?>" />
						<p class="description"><?php _e( "This text will be replaced on 'Add to Cart' button. By leaving it blank.", 'sdevs_preorder' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="preorder_no_date_label_color">
							<?php esc_html_e( 'No Date Label Color', 'sdevs_preorder' ); ?>
						</label>
					</th>
					<td>
						<input id="preorder_no_date_label_color" class="sdevs-color-field" type="text" value="<?php echo get_option( 'preorder_no_date_label_color', '#47aeea' ); ?>" name="preorder_no_date_label_color" data-default-color="#47aeea" />
						<p class="description"><?php echo sprintf( __( 'Text color for No Date Label. Default %s.', 'sdevs_preorder' ), '<code>#47aeea</code>' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="preorder_rels_date_label_color">
							<?php esc_html_e( 'Release Date Label Color', 'sdevs_preorder' ); ?>
						</label>
					</th>
					<td>
						<input id="preorder_rels_date_label_color" class="sdevs-color-field" type="text" value="<?php echo get_option( 'preorder_rels_date_label_color', '#000000' ); ?>" name="preorder_rels_date_label_color" data-default-color="#000000" />
						<p class="description"><?php echo sprintf( __( 'Text color for Release Date Label Color. Default %s.', 'sdevs_preorder' ), '<code>#000000</code>' ); ?></p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="preorder_order_item_marker_txt">
							<?php esc_html_e( 'Order item marker Text', 'sdevs_preorder' ); ?>
						</label>
					</th>
					<td>
						<input type="text" id="preorder_order_item_marker_txt" name="preorder_order_item_marker_txt" value="<?php echo esc_html( get_option( 'preorder_order_item_marker_txt', 'Pre-Order product' ) ); ?>" />
					</td>
				</tr>

				<?php do_action( 'sdevs_preorder_setting_fields' ); ?>
			</tbody>
		</table>

		<?php submit_button(); ?>

	</form>
</div>
