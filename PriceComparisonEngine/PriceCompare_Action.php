<?php
    /*
    Plugin Name: Price Compare by Oysterfruit
    Plugin URI: http://www.Oysterfruit.com
    Description: Plugin for comparing product packages
    Author: Oysterfruit
    Version: 1.0
    Author URI: http://www.oysterfruit.com
    */


function pricecomp_admin_actions() {

 add_options_page("Oysterfruit Price Comparison Engine", "Oysterfruit Price Comparison Engine", "manage_options", "Oysterfruit Price Comparison Engine", "pricecomp_admin");
}

function pricecomp_addtab() {

$retval= "<div><p><strong>What the hell???></strong></p></div>";
}

add_action('admin_menu', 'pricecomp_admin_actions');

add_action('init', 'pricecomp_addtab');


function pricecomp_admin() {
    include('pricecompare_admin.php');
}

function pricecomp_getpackages($package_cnt=1) {
    //Connect to the Price Comparison database
    $pricecompdb = new wpdb(get_option('pricecomp_dbuser'),get_option('pricecomp_dbpwd'), get_option('pricecomp_dbname'), get_option('pricecomp_dbhost'));

    $retval = '';
    for ($i=0; $i<$package_cnt; $i++) {
        //Get a random product
        $package_count = 0;
        while ($package_count == 0) {
            $package_id = rand(1,9);
            $package_count = $pricecompdb->get_var("SELECT COUNT(*) FROM package WHERE id=$package_id and active=1");
        }

        //name
       /* $product_image = $oscommercedb->get_var("SELECT products_image FROM products WHERE products_id=$product_id");*/
        $package_name = $pricecompdb->get_var("SELECT name FROM package WHERE id=$package_id");
        /*$store_url = get_option('oscimp_store_url');
        $image_folder = get_option('oscimp_prod_img_folder');*/

        //Build the HTML code
        $retval .= '<div class="prodcomp_product">';

       /* $retval .= '<a href="http://www.oysterfruit.com"><img src="' . $image_folder . $product_image .'"/></a><br />';*/

      $retval .= '<a href="/wp1/wp-content/plugins/pricecomparisonengine/table.html">' . $package_name . '</a>';
        $retval .= '</div>';

    }
    return $retval;

}



?>
