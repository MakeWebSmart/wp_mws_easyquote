<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$option_mws_models = 'mws_easyquote_items';
global $wp;

$adminActionUrl = admin_url( "admin.php?page=".$_GET["page"].'&action=' );

$image_root = dirname(dirname(dirname(dirname(__FILE__)))).'/model_images/';
$image_home = home_url('model_images/');
$defaultImage = plugins_url('images/iPhone.png',__FILE__ );

if ( isset($_POST)) {
    if ( current_user_can( 'manage_options' ) ) {
        /* A user with admin privileges */
        
        if (isset($_POST['modeladdform'])) {
            $jsonContent = get_option($option_mws_models); 
            if($jsonContent !== false){
                $data = json_decode($jsonContent, true);
                unset($_POST["modeladdform"]);
                $data["models"] = array_values($data["models"]);
                array_push($data["models"], $_POST);
                update_option($option_mws_models, json_encode($data));
                // _d('Data',$data);
            }else{
                unset($_POST["modeladdform"]);
                add_option($option_mws_models, json_encode(array('models' => array($_POST))));
            }
        }
        
        if (isset($_POST['modelitemdel'])) {
            // _d($_POST,'POST');
            $indx = isset($_POST['delid']) ? $_POST['delid'] : false;
            // _d($indx,'indx');
            
            $jsonContent = get_option($option_mws_models); 
            $data = json_decode($jsonContent, true);
            $jsonList = $data["models"];

            if(isset($jsonList[$indx])){
                
                unset($jsonList[$indx]);
                
                $newData = array_values($jsonList);
                
                // _d($newData,'newData');
                update_option($option_mws_models, json_encode(array('models' => $newData)));
            }
        }
        /**
         * Delete all options at once
         */
        if (isset($_POST['modeldelform'])) {
            delete_option($option_mws_models);
        }
        
        
        
        // if ( get_option( $option_mws_models ) !== false ) {
            $jsonContent = get_option($option_mws_models);
            $retContent = json_decode($jsonContent);
            if($jsonContent !== false){
                $retData = json_decode($jsonContent, true);
                // _d($retData,'Models');
            } else {
                _d('Data NOT FOUND');
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
        if ( current_user_can( 'manage_options' ) ) {
        ?>
        <h3>Add new model</h3>

        <form method="post">
            <!-- <input type="hidden" name="modeladdform" value="ok"/> -->
            <!-- <span class="label">Model Name</span> <input type="text" name="id" value="" />  -->
            <label for="modelname">Model Name</label> <input type="text" class="form-control" name="modelname" value="" /> 
            <br />
            <label for="imagefile">Image File Name</label> <input type="text" class="form-control" name="imagefile"  placeholder="" value="" /> 
            <br />
            <div class="info">
                Please upload image to: "<?=$image_root ?>" folder and make sure that image is accessible from "<?=$image_home?>your-image-file" URL.
                <br /> 
                By default, system using "<?=$defaultImage?>", if no valid image name provided.
            </div>
            <br />
            <label for="issue1name">Item 1 Name</label> <input type="text" class="form-control" name="issue1name"  value="" /> 
            <br />
            <label for="issue1price">Item 1 Price</label> <input type="text" class="form-control" name="issue1price"  value="" /> 
            <br />
            <label for="issue2name">Item 2 Name</label> <input type="text" class="form-control" name="issue2name"  value="" /> 
            <br />
            <label for="issue2price">Item 2 Price</label> <input type="text" class="form-control" name="issue2price"  value="" /> 
            <br />
            <label for="issue3name">Item 3 Name</label> <input type="text" class="form-control" name="issue3name"  value="" /> 
            <br />
            <label for="issue3price">Item 3 Price</label> <input type="text" class="form-control" name="issue3price"  value="" /> 
            <br />
            <input type="submit" name="modeladdform" value="Submit" />
        </form>
        <?php
        }
        ?>
    
    <h3>Model Lists</h3>
            <?php 
            if( $jsonContent && isset($retContent->models)){
            ?>
    <div class="table-responsive">
    <table align="center" class="table table-striped table-hover table-bordered">
        <tr>
            <th>Model Name</th>
            <th>ImageFile</th>
            <th>Item 1 Name</th>
            <th>Item 1 price</th>
            <th>Item 2 Name</th>
            <th>Item 2 price</th>
            <th>Item 3 Name</th>
            <th>Item 3 price</th>
            <!-- <th>Description of Video</th> -->
            <th>Action</th>
        </tr>
        <tbody>
<?php
           
            foreach ($retContent->models as $index => $obj): ?>
                <tr>
                    <td><?php echo $obj->modelname; ?></td>
                    <td><?php echo $obj->imagefile; ?></td>
                    <td><?php echo $obj->issue1name; ?></td>
                    <td><?php echo $obj->issue1price; ?></td>
                    <td><?php echo $obj->issue2name; ?></td>
                    <td><?php echo $obj->issue2price; ?></td>
                    <td><?php echo $obj->issue3name; ?></td>
                    <td><?php echo $obj->issue3price; ?></td>
                    <!-- <td><?php // echo $obj->description; ?></td> -->
                    <td>
                        <!-- <a href="<?php // echo $adminActionUrl . 'edit&id=' . $index; ?>">Edit</a> -->
                        <!-- <a href="<?php //echo $adminActionUrl . 'delete&id=' . $index; ?>">Delete</a> -->
                        <?php 
                        if ( current_user_can( 'manage_options' ) ) {
                        ?>
                        <form method="post">
                            <input type="hidden" name="delid" value="<?php echo $index; ?>" />

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
<a href="<?php echo admin_url( 'admin.php?page=mws_easyquote_list' );?>" class="btn btn-info">Reorder Model List</a>
<br />
<br />
<br />
     <form method="post">
        <input type="submit" name="modeldelform" class="btn btn-danger" value="Delete All Models" />
    </form>
       <br />
       <br />
       <br />
       <div><?=mws_helpline();?></div>
    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
</div><!-- bootstrap iso -->