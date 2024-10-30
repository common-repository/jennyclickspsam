<?php
session_start();
include("../../../wp-blog-header.php");
?>
<?php
global $wpdb;
$sql1 = "UPDATE wp_jennyclicksproductdata SET pid = '$_POST[pid]'";
$wpdb->query($sql1);

$blogurl = get_bloginfo ( 'wpurl' );

$redirecturl = $blogurl."/wp-admin/admin.php?page=jennyclicks_topmenuslug&processrun=complete";

header( 'Location: '.$redirecturl ) ;

?>