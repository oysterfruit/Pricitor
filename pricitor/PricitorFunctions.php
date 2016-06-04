<?php

  //Load the jquery datepicker
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
  //wp_enqueue_style('jquery-style', get_template_directory_uri() . '/pricitor/css/jquery-ui-1.10.4.min.css');


  //load the jQuery validator
  //wp_enqueue_script('jquery-ui-validtaor', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js' );

  // Load the bootstrap stylesheet
	//wp_enqueue_style( 'PriceComparator-bootstrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' );
  wp_enqueue_style( 'PriceComparator-bootstrap', get_template_directory_uri() . '/pricitor/css/cerulean/bootstrap.min.css' );
  //wp_enqueue_style( 'PriceComparator-bootstrap', get_template_directory_uri() . '/pricitor/css/lavish-bootstrap/css' );
  wp_style_add_data( 'PriceComparator-bootstrap', 'title', 'bootstrap' );

   // Load the animate stylesheet
  //wp_enqueue_style( 'PriceComparator-Animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css' );
  wp_enqueue_style( 'PriceComparator-Animate', get_template_directory_uri() . '/pricitor/css/animate.css' );

 // wp_enqueue_style( 'PriceComparator-bootstrapthemestyle', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css'  );
  wp_enqueue_style( 'PriceComparator-bootstrapthemestyle', '/pricitor/css/bootstrap-theme.min.css'  );
  //wp_style_add_data( 'PriceComparator-bootstrapthemestyle', 'title2', 'bootstraptheme' );

//load font-awesome stylesheet
 wp_enqueue_style( 'PriceComparator-fontawesomestyle', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');

  // Load the PriceCompare Stylesheet
	wp_enqueue_style( 'PriceComparator-style', get_template_directory_uri() . '/pricitor/css/pricetable.css', array(), null, 'screen' );
	//wp_style_add_data( 'PriceComparator-style', 'title3', 'pricetable' );


  if (!is_admin()) {
		wp_enqueue_script('jquery');
    wp_enqueue_script('javascript');
    //wp_enqueue_script( 'PriceCompartator-bootstrapscript', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array(), true );
	}

//Load the PriceCompare js file
  wp_enqueue_script( 'twentysixteen-PricitorPagescript', get_template_directory_uri() . '/pricitor/js/PricitorPage.js');


//PHP function get current year season start date
function getSeasonStartDate() {
    $date = DateTime::createFromFormat("Y-m-d", Date("Y-m-d"));
    $date = $date->format("Y");
    $date_str = $date . "-06-01";
    return $date_str;
}
//get current year season end date
function getSeasonEndDate() {
    $date = DateTime::createFromFormat("Y-m-d", Date("Y-m-d"));
    $date = $date->format("Y");
    $date_str = $date . "-09-30";
    return $date_str;
}

?>
