<?php
global $wpdb;
$table_name = $wpdb->prefix . "popup";
$info = (isset($_REQUEST["info"])) ? $_REQUEST["info"] : '';

if ($info == "saved") {
    echo "<div class='updated' id='message'><p><strong>PopUp Added</strong>.</p></div>";
}

if ($info == "update") {
    echo "<div class='updated' id='message'><p><strong>Record Updated</strong>.</p></div>";
}

if ($info == "del") {
    $delid = $_GET["did"];
    $wpdb->query("delete from " . $table_name . " where id=" . $delid);
    echo "<div class='updated' id='message'><p><strong>Record Deleted.</strong>.</p></div>";
}
?>
<script type="text/javascript">
    /* <![CDATA[ */
    jQuery(document).ready(function () {
        jQuery('#popuplist').dataTable();
    });
    /* ]]> */

</script>

<div class="wrap">
  <h2>List of Records</h2>
  <a href="admin.php?page=popup_add&act=add">
  <?php submit_button('Add New'); ?>
  </a>
  <table class="wp-list-table widefat fixed " id="popuplist">
    <thead>
      <tr>
        <th><u>Shortcode</u></th>
        <th><u>Title</u></th>
        <th><u>Content</u></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
            $result = $wpdb->get_results("SELECT * FROM " . $table_name . " order by id asc");
            if ($result) {
                ?>
      <script type="text/javascript">
                /* <![CDATA[ */
                jQuery(document).ready(function () {
                    jQuery('#mytable').dataTable();
                });
                /* ]]> */
            </script>
      <?php
            foreach ($result as $key => $value) {
                $id = $value->id;
                $title = $value->title;
              //$content = $value->content;
                $cont = $value->content;
                $cont = strip_tags($cont);
                $content = substr($cont, 0, 20);
                ?>
      <tr>
        <td><?php echo "[popup id=$id]"; ?></td>
        <td><?php echo $title; ?></td>
        <td><?php echo $content; ?></td>
        <td><u><a href="admin.php?page=popup_add&act=update&id=<?php echo $id; ?>">Edit</a></u></td>
        <td><u><a href="admin.php?page=popup&info=del&did=<?php echo $id; ?>">Delete</a></u></td>
      </tr>
      <?php
            }
        } else {
            ?>
      <tr>
        <td>No Record Found!</td>
      <tr>
        <?php } ?>
    </tbody>
  </table>
</div>
