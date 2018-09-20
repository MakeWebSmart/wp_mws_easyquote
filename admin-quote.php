<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$option_mws_models = 'mws_easyquote_items';
global $wp;
$upload_dir = wp_upload_dir();
$adminActionUrl = admin_url( "admin.php?page=".$_GET["page"].'&action=' );
$image_root = $upload_dir['basedir'] . '\easy-quote\images';
$image_home = $upload_dir['baseurl'] . '/easy-quote/images/';
$defaultImage = plugins_url('images/iPhone.png',__FILE__ );

if(!is_dir($image_root)){
    mkdir($image_root, 0755,true);
}

if ( isset($_POST)) {
    if ( current_user_can( 'manage_options' ) ) {
        /* A user with admin privileges */  
        if (isset($_POST['modeladdform'])) {
            if ( check_admin_referer( 'add_model' ) ) {
                $jsonContent = get_option($option_mws_models); 
                $postIntItems = ['issue1price','issue2price','issue3price'];
                $removeItems = ['modeladdform'];
                if($jsonContent !== false){
                    $data = json_decode($jsonContent, true);
                    $data["models"] = array_values($data["models"]);
                    array_push($data["models"], mws_sanitize_items($_POST, $postIntItems,$removeItems));
                    update_option($option_mws_models, json_encode($data));
                }else{
                    add_option($option_mws_models, json_encode(array('models' => array(mws_sanitize_items($_POST, $postIntItems,$removeItems)))));
                }
            }
        }
            
        if (isset($_POST['modelitemdel'])) {
            if ( check_admin_referer( 'del_item' ) ) {
                $indx = isset($_POST['delid']) ? intval($_POST['delid']) : false;
                $jsonContent = get_option($option_mws_models); 
                $data = json_decode($jsonContent, true);
                $jsonList = $data["models"];
                
                if(isset($jsonList[$indx])){
                    unset($jsonList[$indx]);
                    $newData = array_values($jsonList);
                    update_option($option_mws_models, json_encode(array('models' => $newData)));
                }
            }
        }
        /**
         * Delete all options at once
         */
        if (isset($_POST['modeldelform'])) {
            if ( check_admin_referer( 'del_models' ) ) {
                delete_option($option_mws_models);
            }
        }
    } else {
        echo "You dont have sufficient privilege to perform any action!";
    } // current_user_can method END
    // } // Token Validation END
} // $_POST end
$jsonContent = get_option($option_mws_models);
$retContent = json_decode($jsonContent);
if($jsonContent !== false){
    $retData = json_decode($jsonContent, true);
} else {
    echo 'Data NOT FOUND';
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
        ?>
        <h3>Add new model/Category</h3>

        <form method="post">
            <label for="modelname">Model/Category Name</label> <input type="text" class="form-control" name="modelname" value="" /> 
            <br />
            <label for="imagefile">Image File Name</label> <input type="text" class="form-control" name="imagefile"  placeholder="" value="" /> 
            <br />
            <div class="info">
                Please upload image to: "<?=$image_root ?>" folder and make sure that image is accessible from "<?=$image_home?>your-image-file" URL.
                <br /> 
                By default, system using "<?=$defaultImage?>", if no valid image name provided.
            </div>
            <br />
            <label for="issue1name">Issue/Item 1 Name</label> <input type="text" class="form-control" name="issue1name"  value="" /> 
            <br />
            <label for="issue1price">Issue/Item 1 Price</label> <input type="text" class="form-control" name="issue1price"  value="" /> 
            <br />
            <label for="issue2name">Issue/Item 2 Name</label> <input type="text" class="form-control" name="issue2name"  value="" /> 
            <br />
            <label for="issue2price">Issue/Item 2 Price</label> <input type="text" class="form-control" name="issue2price"  value="" /> 
            <br />
            <label for="issue3name">Issue/Item 3 Name</label> <input type="text" class="form-control" name="issue3name"  value="" /> 
            <br />
            <label for="issue3price">Issue/Item 3 Price</label> <input type="text" class="form-control" name="issue3price"  value="" /> 
            <br />
            <?php wp_nonce_field( 'add_model');?>
            <input type="submit" name="modeladdform" value="Submit" />
        </form>
        <?php
        }
        ?>
    
    <h3>Model/category Lists</h3>
            <?php 
            if( $jsonContent && isset($retContent->models)){
            ?>
    <div class="table-responsive">
    <table align="center" class="table table-striped table-hover table-bordered">
        <tr>
            <th>Model/Category Name</th>
            <th>ImageFile</th>
            <th>Issue/Item 1 Name</th>
            <th>Issue/Item 1 price</th>
            <th>Issue/Item 2 Name</th>
            <th>Issue/Item 2 price</th>
            <th>Issue/Item 3 Name</th>
            <th>Issue/Item 3 price</th>
            <!-- <th>Description of Video</th> -->
            <th>Action</th>
        </tr>
        <tbody>
<?php
           
            foreach ($retContent->models as $index => $obj): ?>
                <tr>
                    <td><?php echo esc_html( $obj->modelname); ?></td>
                    <td><?php echo esc_html( $obj->imagefile); ?></td>
                    <td><?php echo esc_html( $obj->issue1name); ?></td>
                    <td><?php echo esc_html( $obj->issue1price); ?></td>
                    <td><?php echo esc_html( $obj->issue2name); ?></td>
                    <td><?php echo esc_html( $obj->issue2price); ?></td>
                    <td><?php echo esc_html( $obj->issue3name); ?></td>
                    <td><?php echo esc_html( $obj->issue3price); ?></td>
                    <td>
                        <?php 
                        if ( current_user_can( 'manage_options' ) ) {
                        ?>
                        <form method="post">
                            <input type="hidden" name="delid" value="<?php echo $index; ?>" />
                            <?php wp_nonce_field( 'del_item');?>
                            <input type="submit" name="modelitemdel" class="btn btn-danger" value="Delete" />
                        </form>
                        <?php
                        } else {
                            ?>
                            You dont have permission to perform any action.
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
            <?php 
            } else {
                echo '<h4>Data NOT Found in the System!</h4>';
            }
            ?>
<br />
<br />
<br />
<a href="<?php echo admin_url( 'admin.php?page=mws_easyquote_list' );?>" class="btn btn-info">Re-order Model/category List</a>
<br />
<br />
<br />
     <form method="post">
        <?php wp_nonce_field( 'del_models');?>
        <input type="submit" name="modeldelform" class="btn btn-danger" value="Delete All Models" />
    </form>
       <br />
       <br />
       <br />
       <div><?=mws_helpline();?></div>
    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
</div><!-- bootstrap iso -->