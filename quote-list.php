<?php
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

if (isset($_POST['updateorder'])) {
    $newArr = [];
    foreach($_POST['modelorder'] as $k=>$v){
        $newArr[$k] = $retData['models'][$v];
    }
    update_option($option_mws_models, json_encode(array('models' => $newArr)));
    $jsonContent = get_option($option_mws_models);
    $retContent = json_decode($jsonContent);
    if($jsonContent !== false){
        $retData = json_decode($jsonContent, true);
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
    <h3>Reorder Model Lists</h3>
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
        <input type="submit" name="updateorder" class="btn btn-danger" value="Submit New Order" />
    </form>
    <?php } else {
    ?>
    <p>No Data Found! You should save some data first.</p>
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