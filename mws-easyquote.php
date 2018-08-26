<?php
/*
Plugin Name: Easy Quote
Plugin URI: 
Description: A simple WordPress OnePage Quote plugin 
Version: 1.3
Author: Azraf Anam
Author URI: http://azraf.me
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');
function callback_for_setting_up_scripts() 
{
    wp_register_style( 'namespace',  plugins_url('assets/form.css?t='.time(),__FILE__ ) );
    wp_enqueue_style( 'namespace' );
    wp_enqueue_script( 'jqueryeasinhg1',  'http://thecodeplayer.com/uploads/js/jquery.easing.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'mwseasyquotejs',  plugins_url('assets/form.js',__FILE__ ), array( 'jquery' ) );
    wp_enqueue_script( 'mwsquoteformprocess',  plugins_url('assets/form-process-front.js',__FILE__ ), array( 'jquery' ) );
}


function easy_quote_adminscripts() 
{
    wp_register_style('mwsbootstrapiso', plugins_url('assets/bootstrap-iso.css',__FILE__ ));
    wp_enqueue_style('mwsbootstrapiso');
    wp_enqueue_script( 'mwsjquerysortable',  plugins_url('assets/jquery-sortable-min.js',__FILE__ ), array( 'jquery' ) );
    wp_enqueue_script( 'mwsformprogress',  plugins_url('assets/form-process.js',__FILE__ ), array( 'jquery' ) );
    wp_enqueue_script('your_namespace');
}
add_action( 'admin_init','easy_quote_adminscripts');


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
add_action('admin_menu', 'easy_quote_menu');
function easy_quote_menu()
{
    add_menu_page(__('EasyQuote', 'easyquote'), __('EasyQuote', 'easyquote'), 'manage_options', 'mws_easyquote_admin', 'easyquote_admin_page',plugins_url('easyquote.ico',__FILE__ ));
    add_submenu_page('mws_easyquote_admin', 'List Models', 'Reorder Model List', 'manage_options', 'mws_easyquote_list', 'easyquote_list_page');
    add_submenu_page('mws_easyquote_admin', 'Options', 'EasyQuote Options', 'manage_options', 'mws_easyquote_options', 'easyquote_options_page');
}

function easyquote_admin_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    include_once dirname(__FILE__) . '/admin-quote.php';
}

function easyquote_list_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    include_once dirname(__FILE__) . '/quote-list.php';
    die();
}

function easyquote_options_page()
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

if(!function_exists('_d')){
    function _d($var, $str = '')
    {
        if (!empty($str)) {
            echo '<br />' . $str . '<br />';
        } 
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}