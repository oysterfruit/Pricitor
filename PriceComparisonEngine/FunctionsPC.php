function reg_scripts() {
    wp_enqueue_style( 'bootstrapstyle', get_template_directory_uri() . '/css/bootstrap.min.css' );
    wp_enqueue_style( 'bootstrapthemestyle', get_template_directory_uri() . '/css/bootstrap-theme.min.css' );
    wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array(), true );

  if (!is_admin()) {
		wp_enqueue_script('jquery');
    wp_enqueue_script('javascript');
	}
}
add_action('init', 'reg_scripts');
