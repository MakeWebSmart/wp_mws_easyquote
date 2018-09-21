<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$jsonFile = 'models.json';
$option_mws_models = 'mws_easyquote_items';
global $wp;
$retData = false;
$adminActionUrl = admin_url( "admin.php?page=".$_GET["page"].'&action=' );

$jsonContent = get_option($option_mws_models);
$retContent = json_decode($jsonContent);
if($jsonContent !== false){
    $retData = json_decode($jsonContent, true);
}
if ( isset($_POST)) {
    if ( current_user_can( 'manage_options' ) ) {
        if (isset($_POST['updateorder']) && check_admin_referer( 'order_models' )) {
            $newArr = [];
            foreach($_POST['modelorder'] as $k=>$v){
                $newArr[intval($k)] = $retData['models'][intval($v)];
            }
            update_option($option_mws_models, json_encode(array('models' => $newArr)));
            $jsonContent = get_option($option_mws_models);
            $retContent = json_decode($jsonContent);
            if($jsonContent !== false){
                $retData = json_decode($jsonContent, true);
            }
        }
    } else {
        echo "You dont have sufficient privilege to perform any action!";
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
        ?>
    <h3>Reorder Model/Category Lists</h3>
    <?php if($retData){
        ?>
    <p>Drag any item up/down to reorder its position.</p>
    <form method="post">
        <ol class="reordering-list list">
            <?php foreach ($retContent->models as $index => $obj): ?>
            <li class="list-group-item list-group-item-info">
                <?php echo ($index + 1) . '. ' . $obj->modelname; ?>
                <input type="hidden" name="modelorder[]" value="<?php echo $index; ?>">
            </li>
            <?php endforeach; ?>
        </ol>
        <?php
        if ( current_user_can( 'manage_options' ) ) {
        ?>
        <?php wp_nonce_field( 'order_models');?>
        <input type="submit" name="updateorder" class="btn btn-danger" value="Submit New Order" />
        <?php
        } else {
            echo "You dont have sufficient privilege to save new order of the list!";
        }
        ?>
    </form>
    <?php } else {
    ?>
    <p>No Data Found! Please save some data first.</p>
        <?php 
    } 
    ?>
    
       <br />
       <br />
       <br />
       <div><?=mws_helpline();?></div>
    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
</div><!-- bootstrap iso -->