<?php
/*
Plugin Name: JennyClicks Product Sales & Affiliate Management (PSAM)
Plugin URI: http://www.jennyclicks.com
Description: Increase your product online sales, setup your own instant commission affiliate program which pays instantly to both you and your affiliate for every sale. Also track each and every sale through your JennyClicks control panel. Powered by Paypal approved JennyClicks Instant Commission Affiliate Network.
Version: 1.0
Author: JennyClicks Inc.
Author URI: http://jennyclicks.com
License: GPL2
*/
/*  Copyright 2011  JennyClicks Inc.  (email : support@jennyclicks.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

session_start();

$_SESSION[blogurl] = get_bloginfo ( 'wpurl' );

$_SESSION[processurl] = $_SESSION[blogurl]."/wp-content/plugins/jennyclickspsam";

global $wpdb;


add_action('admin_menu', 'jennyclicks_top_menu');

function jennyclicks_top_menu() {
add_menu_page('JennyClicks Product Sales & Affiliate Management', 'JennyClicks PSAM Settings', 'read', 'jennyclicks_topmenuslug', 'jennyclicks_product_settings_page');
}

function jennyclicks_product_settings_page() {
global $wpdb;
$myrow21 = $wpdb->get_row( "SELECT * FROM wp_jennyclicksproductdata" );
?>
<div>
<p align="center"><img src="http://jennyclicks.com/wphead.jpg"></p>
<h2 align="center">JennyClicks Product Sales & Affiliate Management (PSAM) Main Settings Page</h2>
<?php
if($_GET[processrun]=="complete")
{
?>
<font color="red">
Thank you for updating the product settings :) Now you can use the below short codes!<br><br>
</font>
<?php
}
?>
<font face="calibri" size="3">
Thank you for installing JennyClicks PSAM Plugin. Now next step is to list your product for sale at JennyClicks.com which is absolutely FREE & once you get the 
product ID, you can update it here & then use the following short codes for buy now links, buy now buttons & affiliate page signup link:
<br><br>
<b><u>Your product buy now link:</b></u><br> Just use [jennyclicksbuynowlink] on your blog post or pages & it will automatically link to the buy now page for your product!
<br><br>
<b><u>Your product buy now button:</b></u><br> Just use [jennyclicksbuynowbutton] on your blog post or pages & it will automatically show the buy now button linked to 
the buy now page for your product!
<br><br>
<b><u>Your product add to cart button:</b></u><br> Just use [jennyclicksaddtocartbutton] on your blog post or pages & it will automatically show the add to cart button linked to 
the buy now page for your product!
<br><br>
<b><u>Your product affiliate signup page:</b></u><br> Just use [jennyclicksaffiliatesignup] on your blog post or pages & it will automatically link to the affiliate 
page for your product. This means, affiliates will be able to promote your product for instant commissions!
<br><br>
To list your product for FREE & get the product ID, just <a href="http://jennyclicks.com/portal/?utm_source=wordpress&utm_medium=plugin&utm_campaign=Wordpress_Plugin_Admin_Page" target="_blank">click here</a>. <br>If you need any 
help anytime (installation, after installation or anything) then please open a support ticket by <a href="http://jennyclicks.com/support" target="_blank">clicking here</a>.
<br><br>Please fill the form below & click on save my product settings. After you update the settings below then you can use the above short codes: <br>
<br><form action="<?php echo($_SESSION[processurl]); ?>/updateproductsettings.php" method="post">
<strong>Set a product ID</strong> (This is the JennyClicks.com product ID for your product, it shows in your Paypal account & shows on Paypal payment page also)<br><input type="text" name="pid" value="<?php echo($myrow21->pid); ?>"><br><br>
<input type="submit" value="Save My Product Settings">
</form>
<h2 align="center">Sell your products online for FREE! <br><br>OR <br><br>Promote high quality products for instant Paypal & Alertpay commissions!<br><br> Signup for FREE at 
<a href="http://jennyclicks.com/portal/?utm_source=wordpress&utm_medium=plugin&utm_campaign=Wordpress_Plugin_Admin_Page" target="_blank">www.jennyclicks.com</a>
</h2>
</div>
<?php
}


function jennyclicks_aff_form($content) {
global $wpdb;
$myrow22 = $wpdb->get_row( "SELECT * FROM wp_jennyclicksproductdata" );

$jcaform = '<br><a href="http://jennyclicks.com/plus/buy.php?pid='.$myrow22->pid.'" target="_blank">Click here to buy now!</a><br>';
$content = str_replace('[jennyclicksbuynowlink]',$jcaform,$content);

$jcaform = '<br><a href="http://jennyclicks.com/plus/buy.php?pid='.$myrow22->pid.'" target="_blank"><img src="http://jennyclicks.com/plus/images/buynow'.$myrow22->pid.'.jpg" border="0"></a><br>';
$content = str_replace('[jennyclicksbuynowbutton]',$jcaform,$content);

$jcaform = '<br><a href="http://jennyclicks.com/plus/buy.php?pid='.$myrow22->pid.'" target="_blank"><img src="http://jennyclicks.com/plus/images/addtocart'.$myrow22->pid.'.jpg" border="0"></a><br>';
$content = str_replace('[jennyclicksaddtocartbutton]',$jcaform,$content);

$jcaform = '<br><a href="http://jennyclicks.com/plus/myaffiliates.php?pid='.$myrow22->pid.'" target="_blank">Click here to signup as affiliate to promote this product!</a><br>';
$content = str_replace('[jennyclicksaffiliatesignup]',$jcaform,$content);

return($content);
}

add_filter('the_content', 'jennyclicks_aff_form');


function jennyclicks_create_set_tables()
{
global $wpdb;

$sql1  = " CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."jennyclicksproductdata (";
	$sql1 .= "   `datanumber` varchar(100),";
	$sql1 .= "   `pid` varchar(255),";
$sql1 .= "   PRIMARY KEY  (`datanumber`)";
	$sql1 .= " ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";


$wpdb->query($sql1);

$sql2 = "INSERT INTO wp_jennyclicksproductdata (datanumber) VALUES ('1')";

$wpdb->query($sql2);

}

register_activation_hook( __FILE__, 'jennyclicks_create_set_tables' );

?>