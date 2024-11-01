<?php
/**
 * Plugin Name: Unlimited PopUps.
 * Plugin URI: https://wordpress.org/plugins/unlimited-popups/
 * Description: Graphica Branding develop a simple, attractive and extremely fast popup  for your WordPress site.
 * Version: 4.5.3 
 * Author: Samina Naz
 * Author URI: http://graphicabranding.com/
 * License: A "Slug" license GPL13
 */
require_once("popupclass.php");
$objPopup = new popupClass();

$table_name = $wpdb->prefix . "popup";
$addmep = (isset($_REQUEST["addmep"])) ? $_REQUEST["addmep"] : '';

function popupplug() {

    global $wpdb;

    $table_name = $wpdb->prefix . "popup";

    $MSQL = "show tables like '$table_name'";

    if ($wpdb->get_var($MSQL) != $table_name) {

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				title VARCHAR(200) NOT NULL,
				popup_width TEXT,
				bg_color TEXT,
				border_color  TEXT,
				border_width  TEXT,
				border_radius  TEXT,
				popup_margin_top  TEXT,
				popup_margin_left  TEXT,
				popup_top  TEXT,
				popup_left  TEXT,
				popup_position  TEXT,
				popup_zindex  TEXT,
				popup_heading_color  TEXT,
				popup_paragraph_color  TEXT,
				popup_paragraph_size  TEXT,
				popup_heading_size TEXT,
				popup_text_alignment TEXT,
				content longtext NOT NULL,
				UNIQUE KEY id (id)
				) ";

        require_once(ABSPATH . "wp-admin/includes/upgrade.php");
        dbDelta($sql);
    }
}

/* Hook Plugin */
register_activation_hook(__FILE__, 'popupplug');

// Delete table when deactivate
function poup_table_remove() {
    global $wpdb;
    $table_name = $wpdb->prefix . "popup";
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");
}

register_deactivation_hook(__FILE__, 'poup_table_remove');
/* Creating Menus */

function popup_admin_menu() {

    /* Adding  Menus */
	add_menu_page('Popup List', 'Popup List', 'edit_pages', 'popup', 'popup_list', 'dashicons-admin-page', null);
    add_submenu_page('popup', 'Add Popup', 'Add Popup', 'edit_pages', 'popup_add', 'popup_add');
    /* For Pagination */
    wp_register_style('poup_table.css', plugin_dir_url(__FILE__) . 'css/poup_table.css');
    wp_enqueue_style('poup_table.css');
    wp_enqueue_style('wp-color-picker');
	wp_register_style('popupstyle.css', plugin_dir_url(__FILE__) . 'css/popupstyle.css');
    wp_enqueue_style('popupstyle.css');

    wp_register_script('jquery.dataTables.js', plugin_dir_url(__FILE__) . 'js/jquery.dataTables.js', array('jquery'));
    wp_enqueue_script('jquery.dataTables.js');
    wp_enqueue_script('wp-color-picker');
}

add_action('admin_menu', 'popup_admin_menu');

/*  View  Recored */

function popup_list() {
    include "popuplist.php";
}
/*  Add  Recored */
function popup_add() {
    include "popup-new.php";
}


/*  Save and update Record on button submission */
if (isset($_POST["submit"])) {
    if ($_POST["addmep"] == "1") {
        $objPopup->addNewPopup($table_name = $wpdb->prefix . "popup", $_POST);
        header("Location:admin.php?page=popup&info=saved");
    } else if ($_POST["addmep"] == "2") {
        $objPopup->updPopup($table_name = $wpdb->prefix . "popup", $_POST);
        header("Location:admin.php?page=popup&info=update");
        exit;
    }
}

/* For Short code */

function viewpopup_list($atts) {
    extract(shortcode_atts(array(
        'id' => ""
                    ), $atts));
    global $wpdb, $table_name;
    wp_deregister_script('jquery.min');
    wp_register_script('jquery.min', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js');
    wp_enqueue_script('jquery.min');
    wp_deregister_style('popupstyle');
    wp_register_style('popupstyle', plugins_url('css/popupstyle.php', __FILE__));
    wp_enqueue_style('popupstyle');
    $sSQL = "select * from $table_name WHERE id=$id";
    $arrresult = $wpdb->get_results($sSQL);
    ?>

<div class="my-popup-div">
  <?php
    if (count($arrresult) > 0) {
        foreach ($arrresult as $key => $val) {
            ?>
  <script type="text/javascript" charset="utf-8">
                    jQuery(document).ready(function () {
                        jQuery('#popup-id-<?php echo $val->id; ?>').click(function () {
                            jQuery('#popupid-<?php echo $val->id; ?>').fadeIn("slow");
                            jQuery(".overlay").fadeIn("slow");

                        });
                        jQuery('#close-btn-<?php echo $val->id; ?>').click(function () {
                            jQuery('#popupid-<?php echo $val->id; ?>').fadeOut("slow");
                            jQuery(".overlay").fadeOut("slow");
                        });
                    });
                </script>
  <style>

                    #popupid-<?php echo $val->id;
            ?> {
                        width:<?php if(empty($val->popup_width )){echo "662";}else{echo $val->popup_width;}?>px;
                        padding:20px;
                        background: <?php if(empty($val->bg_color )){echo "#eeeeee";}else{echo $val->bg_color;}?>;
                        border: <?php if(empty($val->border_width )){echo "5";}else{echo $val->border_width ;}?>px solid <?php if(empty($val->border_color)){echo "#000";}else{echo $val->border_color;}?>;
                        height: auto;
                        box-shadow: 0 0 10px 1px #666;
                        z-index:<?php if(empty($val->popup_zindex )){echo "999999";}else{echo $val->popup_zindex;}?>;
                        position: <?php if(empty($val->popup_position )){echo "relative";}else{echo $val->popup_position;}?>;
                        top: <?php if(empty($val->popup_top )){echo "50";}else{echo $val->popup_top;}?>%;
                        left: <?php if(empty($val->popup_left )){echo "50";}else{echo $val->popup_left;}?>%;
                        border-radius:<?php if(empty($val->border_radius )){echo "5";}else{echo $val->border_radius;}?>px;
                        margin: -<?php if(empty($val->popup_margin_top )){echo "161";}else{echo $val->popup_margin_top;}?>px 0 0 -<?php if(empty($val->popup_margin_top )){echo "331";}else{echo $val->popup_margin_top;}?>px; 
						text-align: <?php if(empty($val->popup_text_alignment )){echo "center";}else{echo $val->popup_text_alignment;}?>;
                    }
                    #popupid-<?php echo $val->id;
            ?> p {
                        font-size:<?php if(empty($val->popup_paragraph_size )){echo "13";}else{echo $val->popup_paragraph_size;}?>px;
                        font-family: Arial, Helvetica, sans-serif;
                        padding:0px;
						color:<?php if(empty($val->popup_paragraph_color )){echo "#000";}else{echo $val->popup_paragraph_color;}?> ;						text-align: <?php if(empty($val->popup_text_alignment )){echo "center";}else{echo $val->popup_text_alignment;}?>;
                        margin:0px 0px 0px 0px;
                        line-height:20px;
                    }
                    #popupid-<?php echo $val->id;
            ?> h1, h2, h3, {
                        font-size:<?php if(empty($val->popup_heading_size )){echo "20";}else{echo $val->popup_heading_size;}?>px;
                        font-family: Arial, Helvetica, sans-serif;
                        padding:0px;
						text-align: <?php if(empty($val->popup_text_alignment )){echo "center";}else{echo $val->popup_text_alignment;}?>;
						color:<?php if(empty($val->popup_heading_color )){echo "#000";}else{echo $val->popup_heading_color;}?>
                        margin:0px;
                        line-height:20px;
                    }
                    #close-btn-<?php echo $val->id; ?> {
                        background-color: transparent;
                        background-image: url(<?php echo plugins_url('images/fancy_close.png', __FILE__);
            ?> );
                        width: 28px;
                        height: 30px;
                        text-indent: -9999px;
                        position: absolute;
                        top: -10px;
                        right: -7px;
                    }
                    #close-btn-<?php echo $val->id; ?>:hover {
                        cursor: pointer;
                    }
					
                    .overlay {
                        background: #000;
                        opacity: 0.5;
                        width: 100%;
                        height: 100%;
                        display: none;
                        position: fixed;
                        left: 0;
                        top: 0;
                        z-index: 1000;
                        overflow: hidden;
                    }
                    @media (min-width: 320px) and (max-width: 420px){		

                        #popupid-<?php echo $val->id;
            ?> {
                            width:100%; left:100%; top:20%;
                        }
                    }
                    @media (min-width: 421px) and (max-width: 767px){	

                        #popupid-<?php echo $val->id;
            ?> {
                            width:100%; left:50%; top:20%;
                        }
                    }
                    @media (min-width: 768px) and (max-width: 991px){

                        #popupid-<?php echo $val->id;
            ?> {
                            width:100%; left:50%; top:20%;
                        }
                    }
                </style>
  <div class="overlay"></div>
  <a id="popup-id-<?php echo $val->id; ?>" href="#popupid-<?php echo $val->id; ?>"><?php echo $val->title; ?></a>
  <div id="popupid-<?php echo $val->id; ?>" style="display: none;">
    <div id="close-btn-<?php echo $val->id; ?>"></div>
    <?php echo do_shortcode($val->content); ?>
    <?php //echo $val->content; ?>
  </div>
  <?php
        }
    } else {
        ?>
  <p><strong>No Records</strong>
  <p>
    <?php
    }
    ?>
</div>
<?php
}

add_shortcode('popup', 'viewpopup_list');
?>
