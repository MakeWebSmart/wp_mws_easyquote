<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$easyquote_options = 'mws_easyquote_options';
global $wp;
$shortcode = '';
$firstStepName = '';
$adminActionUrl = admin_url( "admin.php?page=".$_GET["page"].'&action=' );
$options_mws_easyquote = false;

if (isset($_POST['optionform'])) {
    if ( current_user_can( 'manage_options' ) ) {
        $newArr = [];

        if ($_POST['shortcode']) {
            $newArr['shortcode'] = str_replace('"', '\'', $_POST['shortcode']);
            $newArr['firstStepName'] = $_POST['firstStepName'];
        }
        if ($_POST['firstStepName']) {
            $newArr['firstStepName'] = $_POST['firstStepName'];
        }
        $updateData = json_encode(array('options' => $newArr));
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
                        <label for="modelname">EasyQuote Last step [Form] ShortCode</label> <input type="text" class="form-control" name="shortcode" value="<?php echo $shortcode ?>" /> 
                        <br />
                        <label for="firstStepName">First step field name</label> <input type="text" class="form-control" name="firstStepName" id="firstStepName" value="<?php echo $firstStepName ?>" /> 
                        <br />
                    </ol>
                    <input type="submit" name="optionform" class="btn btn-danger" value="Submit" />
                </form>
                <?php 
                } else {
                    ?>
                    <form method="post">
                        <label for="firstStepName">First step field name</label> <input type="text" class="form-control" name="firstStepName" id="firstStepName" value="" /> 
                        <label for="shortcode">EasyQuote Last step [Form] ShortCode</label> <input type="text" class="form-control" name="shortcode" id="shortcode" value="" /> 
                        <br />
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