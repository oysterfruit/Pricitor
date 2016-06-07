<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

    if($_POST['pricecomp_hidden'] == 'Y') {
        //Form data sent
       $dbhost = $_POST['pricecomp_dbhost'];
        update_option('pricecomp_dbhost', $dbhost);

        $dbname = $_POST['pricecomp_dbname'];
        update_option('pricecomp_dbname', $dbname);

        $dbuser = $_POST['pricecomp_dbuser'];
        update_option('pricecomp_dbuser', $dbuser);

        $dbpwd = $_POST['pricecomp_dbpwd'];
        update_option('pricecomp_dbpwd', $dbpwd);

       /* $prod_img_folder = $_POST['pricecomp_img_folder'];
        update_option('pricecomp_img_folder', $img_folder);

        $store_url = $_POST['oscimp_store_url'];
        update_option('oscimp_store_url', $store_url);*/
        ?>
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
        <?php

    } else {
        //Normal page display
        $dbhost = get_option('pricecomp_dbhost');
        $dbname = get_option('pricecomp_dbname');
        $dbuser = get_option('pricecomp_dbuser');
        $dbpwd = get_option('pricecomp_dbpwd');
        /*$img_folder = get_option('pricecomp_img_folder');
        $store_url = get_option('oscimp_store_url');*/

    }
?>

<div class="wrap">
    <?php    echo "<h2>" . __( 'Oysterfruit Price Comparison Engine', 'pricecomp_trdom' ) . "</h2>"; ?>

    <form name="pricecomp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="pricecomp_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Price Comparison Engine Database Settings', 'pricecomp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Database host: " ); ?><input type="text" name="pricecomp_dbhost" value="<?php echo $dbhost; ?>" size="20"><?php _e(" ex: localhost" ); ?></p>
        <p><?php _e("Database name: " ); ?><input type="text" name="pricecomp_dbname" value="<?php echo $dbname; ?>" size="20"><?php _e(" ex: pricetable" ); ?></p>
        <p><?php _e("Database user: " ); ?><input type="text" name="pricecomp_dbuser" value="<?php echo $dbuser; ?>" size="20"><?php _e(" ex: root" ); ?></p>
        <p><?php _e("Database password: " ); ?><input type="text" name="pricecomp_dbpwd" value="<?php echo $dbpwd; ?>" size="20"><?php _e(" ex: secretpassword" ); ?></p>
        <hr />
        <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Update Options', 'pricecomp_trdom' ) ?>" />
        </p>
    </form>
</div>
