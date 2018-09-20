<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wp;
// $homeUrl =  home_url();
$currentUrl =  home_url( $wp->request );

$option_mws_models = 'mws_easyquote_items';
$easyquote_options = 'mws_easyquote_options';
$mwsEQdataObj = false;
$optionObj = false;
$shortcodeForm = false;
$firstStepName = 'Post Code';
$bafckbuttons = '<a class="btn button" href="'.$currentUrl.'">Back To Form</a> &nbsp; <a class="btn button" href="'.home_url().'">Back To Home</a>';

$jsonContent = get_option($option_mws_models); 
if($jsonContent !== false){
	$mwsEQdataObj = json_decode($jsonContent);
}

$jsonOptions = get_option($easyquote_options );
if($jsonOptions !== false){
	$optionObj = json_decode($jsonOptions);
	if(isset($optionObj->options->shortcode) && !empty($optionObj->options->shortcode)){
		$shortcodeForm = str_replace(array('\\','\''),array('','"'),$optionObj->options->shortcode);
	}
	if(isset($optionObj->options->firstStepName)){
		$firstStepNameCheck = trim($optionObj->options->firstStepName);
		if(!empty($firstStepNameCheck)){
			$firstStepName = $firstStepNameCheck;
		}
	}
}

function mwseq_setModelImage($filename=''){
	$image_root = $upload_dir['basedir'] . '/easy-quote/images';
	$image_home = $upload_dir['baseurl'] . '/easy-quote/images/';
	$defaultImage = plugins_url('/images/iPhone.png',__FILE__ );
	$filename = trim($filename);
	$is_image = false;
	if(!empty($filename)){
		if(is_file($image_root.$filename)){
			$is_image = true;
		}
	}
	return ($is_image) ? $image_home.$filename : $defaultImage;
}
?>
<?php
get_header();
echo '<script type="text/javascript">
	var mwsEQdataObj = '. $jsonContent.';
	</script>';
?>
	<div id="mws-multistepform-container">
		<ul id="multistepform-progressbar">
			<li class="active"><?=$firstStepName?></li>
			<li>Select Cateogry</li>
			<li>Issue/Item</li>
			<li>Cost</li>
			<?php
			if($shortcodeForm){
			?>
				<li>Personal Details</li>
			<?php
			}
			?>
		</ul>
		<div class="form">
			<form id="mwseq_form_1" action="">
				<h2 class="fs-title">We'll Come To You</h2>
				<h3 class="fs-subtitle">Tell Us your <?=$firstStepName?></h3>
				<input type="text" name="postcode" placeholder="<?=$firstStepName?>">
				<input type="button" name="next" class="next button" value="Next">
			</form>
		</div>
		<div  id="mwseq_form_2" class="form">
			<form action="">
				<h2 class="fs-title">Select Category</h2>
				<h3 class="fs-subtitle">Your preferred category</h3>
				<div class="fields">
					<div id="modelname" class="wpir_section_heading">Choose Your category</div>
					<ul class="wpir_field_group list-boxed has-image single-select" data-field_name="model_id">
						<input type="hidden" name="modelid" id="modelid" value=""  />
						<?php 
						$modelFound = false;
						foreach ($mwsEQdataObj->models as $index => $obj): ?>
							<?php 
							if(!empty($obj->modelname)){
								$modelFound = true;
							}
							?>
						<li class="wpir_select_field wpir_field_wrap" data-field_value="<?php echo $index;?>">
							<label class="wpir_field_input" for="<?php echo $index;?>">
								<a href="#/" class="modelselect" title="<?php echo $obj->modelname;?>" id="model-<?php echo $index;?>">
									<img class="item-image" src="<?php echo mwseq_setModelImage($obj->imagefile);?>">
									<div class="item-label"><?php echo esc_html($obj->modelname);?></div>
								</a>
							</label>
						</li>
						<?php endforeach; 
						if($modelFound == false){
							?>
							<div class="error">
								No Item is available right now! Please try after sometime.
							</div>
							<?php
						}
						?>
					</ul>
				</div>
				<input type="button" name="previous" class="previous button" value="Previous">
				<input type="button" name="next" class="next button" value="Next" disabled="disabled">
			</form>
		</div>
		<div id="mwseq_form_3" class="form">
			<form action="">
				<h2 class="fs-title">Issue</h2>
				<h4 id="modelname2">Please select a category first</h4>
				<h3 class="fs-subtitle">Select your problem/issue/items</h3>
				<div id="issue1" class="hidden">
					<input type="checkbox" name="issue1" id="inputissue1" class="issueprice" value="" /> <span class="labelissue1"></span> (cost $ <span id="priceissue1"></span> )
				</div>
				<div id="issue2" class="hidden">
					<input type="checkbox" name="issue2" id="inputissue2" class="issueprice" value="" /> <span class="labelissue2"></span> (cost $ <span id="priceissue2"></span> )
				</div>
				<div id="issue3" class="hidden">
					<input type="checkbox" name="issue3" id="inputissue3" class="issueprice" value="" /> <span class="labelissue3"></span> (cost $ <span id="priceissue3"></span> )
				</div>
				<br />
				<input type="button" name="previous" class="previous button" value="Previous" />
				<input type="button" name="next" class="next button" value="Next" disabled="disabled">
			</form>
		</div>
		<div id="mwseq_form_4" class="form">
			<form action="">
				<h2 class="fs-title">Total Cost</h2>
				<h3 class="fs-subtitle">Review your order detail</h3>
				<h4 id="modelname3" class="wpir_section_heading">Please select a category first</h4>
				    <div id="issuename1"></div>
				    <div id="issuename2"></div>
				    <div id="issuename3"></div>

				<h5 id="totalcost" class=""></h3>
				<br />
				<input type="button" name="previous" class="previous button" value="Previous" />
				<?php
				if($shortcodeForm){

					?>
				<input type="button" name="next" class="next button" value="Next">
				<?php
				} else {
					echo $bafckbuttons;
				}
				?>
			</form>
		</div>
		<?php
		if($shortcodeForm){
		?>
			<div id="mwseq_form_5"class="form">
					<?php
					$formShortCode	= str_replace('\\','', $optionObj->options->shortcode);
					echo do_shortcode( $formShortCode );
					echo '<br />'.$bafckbuttons;
					?>
			</div>
		<?php
			} // else {
				?>
				<!-- <a href="<?=$currentUrl;?>">Back To Form</a> | <a href="<?=home_url();?>">Back To Home</a> -->
				<?php
		//	}
		?>
	</div>
<?php
get_footer();
die();
?>