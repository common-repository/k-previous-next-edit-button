<?php
/*
    Plugin Name: K - Previous/Next edit button
    Plugin URI: https://abakode.com/it/sviluppo/wordpress/plugin/previous-next-edit-button
    Description: Adding a previous or next button to navigate in edit post pages.
    Version: 1.0.0
    Author: {abakode}
    Author URI: https://abakode.com/
    Requires PHP: 5.6
    License: GPLv3
    License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

define('K_PREV_NEXT_EDIT_BUTTON_VERSION', '1.0');
define('K_PREV_NEXT_EDIT_BUTTON_PATH', plugin_dir_path(__FILE__));
define('K_PREV_NEXT_EDIT_BUTTON_URL', plugin_dir_url(__FILE__));

function k_prev_next_edit_button_activate_plugin() {	
}
register_activation_hook(__FILE__, 'k_prev_next_edit_button_activate_plugin');

function k_prev_next_edit_button_deactivate_plugin() {
}
register_deactivation_hook(__FILE__, 'k_prev_next_edit_button_deactivate_plugin');

function k_prev_next_edit_button_plugin_row_meta($meta, $file) {
	if ( strpos( $file, basename(__FILE__) ) !== false ) {
		$meta[] = '<a href="https://abakode.com/it/donazione" target="_blank">' . __('Donate', 'abakode') . '</a>';
	}
	return $meta;
}
add_filter('plugin_row_meta', 'k_prev_next_edit_button_plugin_row_meta', 10, 2);

function k_prev_next_edit_button() {
	global $pagenow, $current_screen;
    $supported_types = array('page', 'post', 'product') + get_post_types(array('public' => true, '_builtin' => false), 'names', 'and');
	if ($pagenow == 'post.php' && $current_screen->action != 'edit' && in_array($current_screen->post_type, $supported_types)) {
		$post_prev = get_next_post();
		$post_next = get_previous_post();
		?>
		<style>
			#k-action { background: #f6f7f7; border-top: 1px solid #dcdcde; padding: 10px 5px; } 
			#k-action > div { display: inline-flex; width: 100%; } 
			#k-action a { width: 50%; margin: 0 5px; } 
			#k-action a:last-child { text-align: right !important; } 
			#k-action a span { overflow: hidden; max-width: calc(100% - 10px); display: inline-flex; }
		</style>
        <div id="k-action">
        	<div>
			<?php if (!empty($post_prev)) { ?>
				<a href="<?php echo get_edit_post_link($post_prev->ID); ?>" class="button-primary" id="prev" name="prev">
					< <span><?php echo esc_html(get_the_title($post_prev->ID)); ?></span>
				</a>
			<?php } else { ?>
				<a href="#" disabled class="button-primary" id="prev" name="prev">
					|< <span><?php echo __("I'm first", 'abakode'); ?></span>
				</a>
			<?php } if (!empty($post_next)) { ?>
				<a href="<?php echo get_edit_post_link($post_next->ID); ?>" class="button-primary" id="next" name="next">
					<span><?php echo esc_html(get_the_title($post_next->ID)); ?></span> >
				</a>
			<?php } else { ?>
				<a href="#" disabled class="button-primary" id="next" name="next">
					<span><?php echo __("I'm  last", 'abakode'); ?></span> >|
				</a>
			<?php } ?>
			</div>
        </div>
		<?php 
	}
}
add_action( 'post_submitbox_misc_actions', 'k_prev_next_edit_button', 50 );

?>