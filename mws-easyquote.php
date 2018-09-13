<?php
/*
Plugin Name: Easy Quote
Plugin URI:  https://github.com/MakeWebSmart/wp_mws_easyquote
Description: A simple WordPress OnePage Quote plugin by MakeWebSmart(mws)
Version: 1.3
Author: Azraf Anam
Author URI: http://azraf.me
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_action('wp_enqueue_scripts', 'mwseq_callback_scripts');
function mwseq_callback_scripts() 
{
    wp_register_style( 'mwseq_formcss',  plugins_url('assets/form.css?t='.time(),__FILE__ ) );
    wp_enqueue_style( 'mwseq_formcss' );
    wp_enqueue_script( 'mwseq_jqueryeasinhg',  plugins_url('assets/jquery.easing.min.js',__FILE__ ), array( 'jquery' ) );
    wp_enqueue_script( 'mwseq_formjs',  plugins_url('assets/form.js',__FILE__ ), array( 'jquery' ) );
    wp_enqueue_script( 'mwseq_formprocess',  plugins_url('assets/form-process-front.js',__FILE__ ), array( 'jquery' ) );
}


function mws_easy_quote_adminscripts() 
{
    wp_register_style('mwseq_bootstrapiso', plugins_url('assets/bootstrap-iso.css',__FILE__ ));
    wp_enqueue_style('mwseq_bootstrapiso');
    wp_enqueue_script( 'mwseq_jquerysortable',  plugins_url('assets/jquery-sortable-min.js',__FILE__ ), array( 'jquery' ) );
    wp_enqueue_script( 'mwseq_formprogress',  plugins_url('assets/form-process.js',__FILE__ ), array( 'jquery' ) );
}
add_action( 'admin_init','mws_easy_quote_adminscripts');


function mws_easyquote_init()
{
    if(is_page('easy-quote')){	
        mws_easyquote_frontpage();
    }
}

function mws_easyquote_frontpage()
{
    $dir = plugin_dir_path( __FILE__ );
    include($dir."easy.php");
    die();
}


add_action( 'wp', 'mws_easyquote_init' );
add_shortcode('MWS_EASYQUOTE', 'mws_easyquote_frontpage');
add_action('admin_menu', 'mws_easy_quote_menu');
function mws_easy_quote_menu()
{
    add_menu_page(__('EasyQuote', 'easyquote'), __('EasyQuote', 'easyquote'), 'manage_options', 'mws_easyquote_admin', 'mws_easyquote_admin_page',plugins_url('easyquote.ico',__FILE__ ));
    add_submenu_page('mws_easyquote_admin', 'List Models', 'Reorder Model List', 'manage_options', 'mws_easyquote_list', 'mws_easyquote_list_page');
    add_submenu_page('mws_easyquote_admin', 'Options', 'EasyQuote Options', 'manage_options', 'mws_easyquote_options', 'mws_easyquote_options_page');
}

function mws_easyquote_admin_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    include_once dirname(__FILE__) . '/admin-quote.php';
}

function mws_easyquote_list_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    include_once dirname(__FILE__) . '/quote-list.php';
    die();
}

function mws_easyquote_options_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    include_once dirname(__FILE__) . '/options-page.php';
}

if(!function_exists('mws_helpline')){
    function mws_helpline()
    {
        echo '
        <br /><br />
        <div class="container">
          <h4>Get in touch  &nbsp; <span class="glyphicon glyphicon-send"></span> c.azraf@gmail.com</h4>
          Send mail using: 
          <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to=c.azraf@gmail.com&amp;su=WP EasyQuote plugin help">Gmail</a> /
          <a target="_blank" href="http://webmail.aol.com/Mail/ComposeMessage.aspx?to=c.azraf@gmail.com&amp;subject=WP EasyQuote plugin help">AOL</a> /
          <a target="_blank" href="http://compose.mail.yahoo.com/?to=c.azraf@gmail.com&amp;subject=WP EasyQuote plugin help">Yahoo</a> /
          <a target="_blank" href="http://mail.live.com/mail/EditMessageLight.aspx?n=&amp;to=c.azraf@gmail.com&amp;subject=WP EasyQuote plugin help">Outlook</a>
          <br />
          <a href="http://azraf.me">Profile</a> | <a href="http://fb.com/webazraf">FaceBook</a>
    </div>';
    }
}

/**
 * Function for dump array or variables
 * 
 * Only for testing purpose
 */
// if(!function_exists('mws_d')){
//     function mws_d($var, $str = '')
//     {
//         if (!empty($str)) {
//             echo '<br />' . $str . '<br />';
//         } 
//         echo '<pre>';
//         print_r($var);
//         echo '</pre>';
//     }
// }