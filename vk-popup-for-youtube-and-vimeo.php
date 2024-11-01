<?php
/*
Plugin Name: Responsive Popup for YouTube & Vimeo
Plugin URI: https://tech2vel.com/
Description: This plugin generates a hyperlink through the shortcode. When that link is clicked, the given video (depends upon configuration) will be displayed in a responsive popup dialog box.
Version: 1.0
Author: Velmurugan Kuberan
Author URI: https://tech2vel.com/
License: GPLv2 or later
Text Domain: vk-popup-for-youtube-and-vimeo
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Thanks to Appleple and Rohit Kumar for the popup code
Rohit Kumar // http://www.iamrohit.in/
Appleple // https://www.appleple.com
*/

function vk_videopopup_enqueue() {
    
    wp_register_script( 'vk-add-jquery-modal-js', plugin_dir_url( __FILE__ ) . '/js/jquery-modal-video.min.js', array('jquery'), '', true );
                
    wp_register_script( 'vk-add-trigger-moal', plugin_dir_url( __FILE__ ) . '/js/trigger.js', array('jquery'), '', true );
                
    wp_register_style( 'vk-modal-css', plugin_dir_url( __FILE__ ) . '/css/modal-video.min.css', '', '', 'screen' );
    
}

add_action( 'wp_enqueue_scripts', 'vk_videopopup_enqueue' );

function vk_videopopup_callback( $atts ) {
    
    $html = '';
    
    $atts = shortcode_atts( array(
        
		'src' => '',
        
		'id' => '',
        
        'text' => 'Click to Open Vimeo Video Play'
        
	), $atts, 'vk-videopopup' );
    
    if ( is_single() ) {
        
        $srcVideo = $atts['src'];
        
        $videoID = $atts['id'];
        
        $message = $atts['text'];
        
        if($srcVideo == 'youtube' || $srcVideo == 'vimeo') {
            
            if($videoID == '') {
                
                $html = 'ID (id) is empty. Please add youtube video id or vimeo video id to id attribute. <br />Example: [vk-videopopup src="youtube" id="EqPtz5qN7HM" text="Play hotel California"]';
                
            } else {
                
                //enqueue scripts and styles                                
                wp_enqueue_script( 'vk-add-jquery-modal-js' );
    
                wp_enqueue_script( 'vk-add-trigger-moal' );
    
                wp_enqueue_style( 'vk-modal-css' );
                
                if($srcVideo == 'youtube') $srcVideo = 'youtube-video-player';
                
                if($srcVideo == 'vimeo') $srcVideo = 'vimeo-video-player';
                
                $html = '<a href="#" class="' . $srcVideo . '" data-video-id="' . $videoID . '">' . $message . '</a>';
                
            }
            
        } else {
           
            $html = 'Source (src) is not valid. Please add youtube or vimeo to src attribute. <br />Example: [vk-videopopup src="vimeo" id="187625966" text="Click to Play Pharrell williams happy"]';
            
        }
        
    }
    
    return $html;	
    
}

add_shortcode( 'vk-videopopup', 'vk_videopopup_callback' );

