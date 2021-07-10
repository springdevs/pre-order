<?php

/**
 * Settings for PayLater Standard Gateway.
 */

defined('ABSPATH') || exit;

return array(
	'title'           => array(
		'title'       => __('Title', 'sdevs_preorder'),
		'type'        => 'text',
		'description' => __('This controls the title which the user sees during checkout.', 'sdevs_preorder'),
		'default'     => __('Pay Later', 'sdevs_preorder'),
		'desc_tip'    => true,
	),
	'description'     => array(
		'title'       => __('Description', 'sdevs_preorder'),
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => __('This controls the description which the user sees during checkout.', 'sdevs_preorder'),
		'default'     => __("When product is confirmed then You need to Pay.", 'sdevs_preorder'),
	),
);
