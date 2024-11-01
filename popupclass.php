<?php

class popupClass {

private $myFields = array("id", "title", "popup_width", "bg_color", "border_color", "border_width", "border_radius", "popup_margin_top", "popup_margin_left", "popup_top", "popup_left" , "popup_position" , "popup_zindex", "popup_heading_color", "popup_paragraph_color", "popup_paragraph_size", "popup_heading_size", "popup_text_alignment", "content");

    function addNewPopUp($tblname, $meminfo) {
        global $wpdb;
        $count = sizeof($meminfo);
        if ($count > 0) {
            $id = 0;
            $field = "";
            $vals = "";

            foreach ($this->myFields as $key) {
                if ($field == "") {
                    $field = "`" . $key . "`";
                    $vals = "'" . $meminfo[$key] . "'";
                } else {
                    $field = $field . ",`" . $key . "`";
                    $vals = $vals . ",'" . $meminfo[$key] . "'";
                }
            }

            $sSQL = "INSERT INTO " . $tblname . " ($field) values ($vals)";

            $wpdb->query($sSQL);
			//echo "<pre>";
			//print_r($wpdb);
			//exit(0);
            return true;
        } else {
            return false;
        }
    }

    function updPopup($tblname, $meminfo) {
        global $wpdb;
        $count = sizeof($meminfo);
        if ($count > 0) {
            $field = "";
            $vals = "";
            foreach ($this->myFields as $key) {
                if ($field == "" && $key != "id") {
                    $field = "`" . $key . "` = '" . $meminfo[$key] . "'";
                } else if ($key != "id") {
                    $field = $field . ",`" . $key . "` = '" . $meminfo[$key] . "'";
                }
            }

            $sSQL = "update " . $tblname . " set $field where id=" . $meminfo["id"];
            $wpdb->query($sSQL);
            return true;
        } else {
            return false;
        }
    }

}

?>