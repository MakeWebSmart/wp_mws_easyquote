<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$easyquote_options = 'mws_easyquote_options';
global $wp;
$shortcode = '';
$firstStepName = '';
$adminActionUrl = admin_url( "admin.php?page=".$_GET["page"].'&action=' );
$options_mws_easyquote = false;

if (isset($_POST['optionform'])) {
    if ( current_user_can( 'manage_options' ) && ( check_admin_referer( 'model_options' ) ) ) {
        $newArr = [];
        
        if ($_POST['shortcode']) {
            // $newArr['shortcode'] = str_replace('"', '\'', $_POST['shortcode']);
            $newArr['shortcode'] = sanitize_text_field($_POST['shortcode']);
            
        }
        if ($_POST['firstStepName']) {
            // $newArr['firstStepName'] = $_POST['firstStepName'];
            $newArr['firstStepName'] = sanitize_text_field($_POST['firstStepName']);
        }
        $updateData = json_encode(array('options' => $newArr));
        // mws_d($newArr,'$newArr');
        // mws_d($newArr2,'$newArr-2');
        // exit();
        update_option($easyquote_options , $updateData);
        // $jsonContent = get_option($easyquote_options );
        // $retContent = json_decode($jsonContent);
        // if($jsonContent !== false){
        //     $retData = json_decode($jsonContent, true);
        // } else {
        //     _d('Models NOT FOUND');
        // }
    } else {
        echo "You dont have sufficient privilege to perform any action!";
    }
}

$jsonContent = get_option($easyquote_options );
if($jsonContent !== false){
    $retContent = json_decode($jsonContent );
    $retData = json_decode($jsonContent, true);
    $options_mws_easyquote = true;
    if (isset($retContent->options->shortcode)){
        $shortcode = str_replace('\\','',$retContent->options->shortcode);
    }
    if (isset($retContent->options->firstStepName)){
        $firstStepName = $retContent->options->firstStepName;
    }
}
?>

<br />
<div class="bootstrap-iso">
    <div id="primary" class="content-area">
        <div id="content" class="container" role="main">
            <?php
            if(isset($msg)){
                echo "<h4>$msg</h4>";
            }
            if ( current_user_can( 'manage_options' ) ) {
                if($options_mws_easyquote){
                ?>
                <h3>EasyQuote Option Page</h3>
                <br />
                <br />
                <form method="post">
                    <ol class="reordering-list list">
                        <label for="modelname">EasyQuote Last step [Form] ShortCode</label> <input type="text" class="form-control" name="shortcode" value="<?php echo esc_html($shortcode) ?>" /> 
                        <br />
                        <label for="firstStepName">First step field name</label> <input type="text" class="form-control" name="firstStepName" id="firstStepName" value="<?php echo esc_html($firstStepName) ?>" /> 
                        <br />
                    </ol>
                    <?php wp_nonce_field( 'model_options');?>
                    <input type="submit" name="optionform" class="btn btn-danger" value="Submit" />
                </form>
                <?php 
                } else {
                    ?>
                    <form method="post">
                        <label for="firstStepName">First step field name</label> <input type="text" class="form-control" name="firstStepName" id="firstStepName" value="" /> 
                        <label for="shortcode">EasyQuote Last step [Form] ShortCode</label> <input type="text" class="form-control" name="shortcode" id="shortcode" value="" /> 
                        <br />
                        <?php wp_nonce_field( 'model_options');?>
                        <input type="submit" name="optionform" value="Submit" />
                    </form>
                    <?php
                }
            }
        ?>
        <br />
        <br />
        <br />
        <div><?=mws_helpline();?></div>
        </div><!-- #content .site-content -->
    </div><!-- #primary .content-area -->
</div><!-- bootstrap iso -->