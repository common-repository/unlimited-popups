<?php
require_once("popupclass.php");
$objPopup = new popupClass();
$addmep = (isset($_REQUEST["addmep"])) ? $_REQUEST["addmep"] : '';
global $wpdb;
$table_name = $wpdb->prefix . "popup";
if ($addmep == 2) {
    $objPopup->updPopup($table_name, $_POST);
    header("Location:admin.php?page=popup&info=update");
    exit;
}
$act = (isset($_REQUEST["act"])) ? $_REQUEST["act"] : '';
if ($act == "update") {
    $recid = $_REQUEST["id"];
    $result = $wpdb->get_row("SELECT * FROM $table_name WHERE id=$recid");

    if ($result){
        $id = $result->id;
        $title = $result->title;
		$popup_width = $result->popup_width;
		$bg_color = $result->bg_color;
		$border_color = $result->border_color;
		$border_width = $result->border_width;
		$border_radius = $result->border_radius;
		$popup_margin_top = $result->popup_margin_top;
		$popup_margin_left = $result->popup_margin_left;
		$popup_top = $result->popup_top;
		$popup_left = $result->popup_left;
		$popup_position = $result->popup_position;
		$popup_zindex = $result->popup_zindex;
		$popup_heading_color =$result->popup_heading_color;
		$popup_paragraph_color =$result->popup_paragraph_color;
		$popup_paragraph_size =$result->popup_paragraph_size;
		$popup_heading_size =$result->popup_heading_size;
		$popup_text_alignment=$result->popup_text_alignment;
        $content = $result->content;
        $btn = "Update Popup";
        $hidval = 2;
    }
} else {
    $btn = "Add New Popup";
    $id = "";
    $title = "";
	$popup_width = "";
	$bg_color = "";
	$border_color = "";
	$border_width = "";
	$border_radius = "";
	$popup_margin_top = "";
	$popup_margin_left = "";
	$popup_top ="";
	$popup_left ="";
	$popup_position = "";
	$popup_zindex ="";
	$popup_heading_color  ="";
	$popup_paragraph_color  ="";
	$popup_paragraph_size  ="";
	$popup_heading_size ="";
	$popup_text_alignment="";
    $content = "";
    $hidval = 1;
}
?>
<?php
$settings = array(
    'textarea_name' => 'content',
    'media_buttons' => true,
    'tinymce' => array(
        'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
        'bullist,blockquote,|,justifyleft,justifycenter' .
        ',justifyright,justifyfull,|,link,unlink,|' .
        ',spellchecker,wp_fullscreen,wp_adv'
    )
);
?>
<div class="wrap nosubsub">
  <h2>Popup <span>Shortcode: <?php echo "[popup id=$id]"; ?></span></h2>
  <p>&nbsp;</p>
  <form class="popup-validate" action="admin.php?page=popup_add" method="post" id="addtag">
    <ul>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Title: </label>
            <input  placeholder="Title" type='text' name='title' value="<?php echo $title; ?>" />
          </li>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup width: </label>
            <input type='text' placeholder="662"  name='popup_width' value="<?php echo $popup_width; ?>"/><div class="popup-wp-px"><span>px</span></div>
          </li>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup border width: </label>
            <input type='text' placeholder="5" name='border_width' value="<?php echo $border_width; ?>"/><div class="popup-wp-px"><span>px</span></div>
          </li>
        </div>
      </div>
      <div class="hr-new"></div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup margin top: </label>
            <input type='text'  placeholder="150" name='popup_margin_top' value="<?php echo $popup_margin_top; ?>"/><div class="popup-wp-px"><span>px</span></div>
          </li>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup margin left: </label>
            <input type='text'  placeholder="331" name='popup_margin_left' value="<?php echo $popup_margin_left; ?>"/><div class="popup-wp-px"><span>px</span></div>
          </li>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup top position: </label>
            <input type='text'  placeholder="50" name='popup_top' value="<?php echo $popup_top; ?>"/><div class="popup-wp-px"><span>%</span></div>
          </li>
        </div>
      </div>
       <div class="hr-new"></div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup left position: </label>
            <input type='text'  placeholder="50" name='popup_left' value="<?php echo $popup_left; ?>"/><div class="popup-wp-px"><span>%</span></div>
          </li>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup zindex: </label>
            <input type='text' placeholder="999999" name='popup_zindex' value="<?php echo $popup_zindex; ?>"/>
          </li>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup paragraph size: </label>
            <input type='text' placeholder="13"  name='popup_paragraph_size' value="<?php echo $popup_paragraph_size; ?>"/><div class="popup-wp-px"><span>px</span></div>
          </li> 
        </div>
      </div>
     <div class="hr-new"></div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup background color:</label>
            <input type='text' placeholder="#eeeeee" class="wp-color-picker-field" name='bg_color' value="<?php echo $bg_color; ?>"/>
          </li>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup border color: </label>
            <input type='text' placeholder="#eeeeee" class="wp-color-picker-field" name='border_color' value="<?php echo $border_color; ?>"/>
          </li>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup paragraph color: </label>
            <input type='text'  placeholder="#000000" class="wp-color-picker-field" name='popup_paragraph_color' value="<?php echo $popup_paragraph_color; ?>"/>
          </li> 
        </div>
      </div>
       <div class="hr-new"></div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup heading color: </label>
            <input type='text' placeholder="#000000" class="wp-color-picker-field" name='popup_heading_color' value="<?php echo $popup_heading_color; ?>"/>
          </li> 
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup position:</label>
            <select name='popup_position'>
              <option value="absolute">absolute</option>
              <option value="fixed">fixed</option>
              <option value="static">static</option>
              <option value="relative">relative</option>
            </select>
          </li>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup text alignment: </label>
             <select name='popup_text_alignment'>
                <option value="center ">center</option>
              <option value="right">right</option>
           
              <option value="left">left</option>
            </select>
           
          </li> 
        </div>
      </div>
      
       <div class="hr-new"></div>
     <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup heading size: </label>
            <input type='text' placeholder="20"  name='popup_heading_size' value="<?php echo $popup_heading_size; ?>"/><div class="popup-wp-px"><span>px</span></div>
          </li> 
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <li>
            <label style="display: block;">Popup border radius: </label>
            <input type='text'  placeholder="10" name='border_radius' value="<?php echo $border_radius; ?>"/><div class="popup-wp-px"><span>px</span></div>
          </li>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
         <p style="color:red; margin-top:12px;"><span >*</span>Half of total width add in Popup margin left<br/>
			<span >*</span>Half of total height add in Popup margin top</p>
        </div>
      </div>
        <div class="hr-new"></div>
        
     <p>&nbsp;</p>
      <div class="col-md-12">
        <div class="row">
          <li> <?php echo wp_editor(stripslashes($content), 'content', $settings); ?> </li>
        </div>
      </div>
    </ul>
    <div class="col-md-12">
      <div class="row">
        <?php submit_button($btn); ?>
      </div>
      <input type="hidden" name="addmep" value="<?php echo $hidval; ?>" />
    </div>
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <script type="text/javascript">
   		jQuery(document).ready(function($) {  
 		$('.wp-color-picker-field').wpColorPicker();
    });             
    </script>
  </form>
</div>
