<?php

/**
 * Plugin Name: SPM Show Colors for Elementor
 * Plugin URI: https://www.simonpetermedia.com/plugins
 * Description: An easy way to display all global colors used in your Elementor website on the Elementor editor pages. By clicking a floating button, a banner will appear showing the global colors defined in your active Elementor Kit. Each color displayed on the banner can be clicked to copy its hex code directly to the clipboard.

 * Version: 1.0.2
 * Author: Simon Peter Media Ltd
 * Author URI: https://www.simonpetermedia.com
 * Text Domain: simonpetermedia
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Load in our CSS and JS
function spm_sce_enqueue_files() {
	wp_enqueue_style( 'sce-css', plugin_dir_url( __FILE__ ) . 'assets/css/sce.css', array(), time() );
	wp_enqueue_script( 'sce-js', plugin_dir_url( __FILE__ ) . 'assets/js/sce.js', array( 'jquery' ), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'spm_sce_enqueue_files' );
add_action( 'admin_enqueue_scripts', 'spm_sce_enqueue_files' );
add_action( 'elementor/editor/after_enqueue_scripts', 'spm_sce_enqueue_files' );


function spm_sce_add_banner () {;
	$kit = Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend();
    $system_colors = $kit->get_settings_for_display( 'system_colors' ); // get the system colors
    $custom_colors = $kit->get_settings_for_display( 'custom_colors' ); // get the custom colors
    $global_colors = array_merge( $system_colors, $custom_colors ); // merge the system and custom colors into one array to display
	
?>

    <div id="spm-sce-button">
        Show Colors
    </div>

    <div id="spm-sce-banner" style="display:none">
        <span class="spm-sce-close-button">&times;</span>
        <p>Global Colors (click to copy):</p>
        <?php if ( empty( $global_colors ) ) : ?>
            <p>No global colors defined</p>
        <?php else : ?>
            <ul>
                <?php foreach ( $global_colors as $color ) : ?>
                    <li style="background-color: <?php echo esc_attr( $color['color'] ); ?>; cursor: pointer;" onclick="spmCopyToClipboard('<?php echo ltrim(esc_attr( $color['color'] ),"#"); ?>')"><?php echo esc_html( $color['title'] ); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    
    <div id="snackbar">Color copied to clipboard.</div>
<?php
}
	
add_action( 'init', function() {
    if ( current_user_can('edit_posts')) {
        $page_file_name = sanitize_file_name(basename($_SERVER['PHP_SELF']));
        
        // add to theme editor
        if ( 'theme-editor.php' == $page_file_name ) {
            add_action( 'in_admin_footer', 'spm_sce_add_banner');
        }

        // add to post and page editors
        if ( 'post.php' == $page_file_name ) {
            add_action( 'admin_footer', 'spm_sce_add_banner');
        }
 
        // add to customizer
        if ( 'customize.php' == $page_file_name ) {
            add_action( 'admin_print_footer_scripts', 'spm_sce_add_banner');
        }

        // add to Elementor editor
        if ( 'post.php' == $page_file_name ) {
            add_action( 'elementor/editor/footer', 'spm_sce_add_banner');
        }
   
    }
});
	
