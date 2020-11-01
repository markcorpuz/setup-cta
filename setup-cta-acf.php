<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


add_filter( 'block_categories', 'setup_cta_block_cats_fn', 10, 2 );
function setup_cta_block_cats_fn( $categories ) {

    foreach( $categories as $key => $value) {
    	
    	if( in_array( 'setup', $value) ) {
    		$foundit = TRUE;
    		break;
    	}

    }

    // category not found - add new
    if( $foundit === FALSE ) {

	    return array_merge(
	        array(
	            array(
	                'slug' => 'setup',
	                'title' => __( 'Setup', 'mydomain' ),
	                //'icon'  => 'wordpress',
	            ),
	        ),
	        $categories
	    );

    }
}

/**
 * Register Custom Blocks
 * 
 */
add_action( 'acf/init', 'setup_cta_block_acf_init_fn' );
function setup_cta_block_acf_init_fn() {

    $blocks = array(
        
        'setup_cta' => array(
            'name'                  => 'cta',
            'title'                 => __('Call to Action'),
            'render_template'       => plugin_dir_path( __FILE__ ).'partials/blocks/setup-cta-flex.php',
            'category'              => 'setup',
            'icon'                  => 'admin-links',
            'mode'                  => 'edit',
            'keywords'              => array( 'call to action', 'link', 'button' ),
            'supports'              => [
                'align'             => false,
                'anchor'            => true,
                'customClassName'   => true,
                'jsx'               => true,
            ],
        ),

    );

    // Bail out if function doesn’t exist or no blocks available to register.
    if ( !function_exists( 'acf_register_block_type' ) && !$blocks ) {
        return;
    }
    
    // this loop is broken, how do we register multiple blocks in one go?
    // Register all available blocks.
/*    $user = wp_get_current_user();

    $allowed_roles = array( 'administrator' ); // can also be array( 'editor', 'administrator', 'author' );

    if( array_intersect( $allowed_roles, $user->roles ) ) {
*/
        foreach( $blocks as $block ) {
            acf_register_block_type( $block );
        }

//    }
  
}


/**
 * Auto fill LAYOUT Select options
 *
 */
add_filter( 'acf/load_field/name=cta_layout', 'setup_cta_view_list_fn' );
function setup_cta_view_list_fn( $field ) {
    
    // get all files found in VIEWS folder
    $view_dir = plugin_dir_path( __FILE__ ).'partials/views/';
/*    $files = scandir($path);
    $choices = array_diff(scandir($path), array('.', '..'));
    var_dump($choices);
  */

    $data_from_database = setup_pull_view_files( $view_dir );

    //Change this to whatever data you are using.
    /*$data_from_database = array(
        'key1' => 'value1',
        'key2' => 'value2'
    );*/

    $field['choices'] = array();

    //Loop through whatever data you are using, and assign a key/value
    if( is_array( $data_from_database ) ) {

        foreach( $data_from_database as $field_key => $field_value ) {
            $field['choices'][$field_key] = $field_value;
        }

        return $field;

    }
    
}


/**
 * Auto fill LAYOUT Select options
 *
 */
add_filter( 'acf/load_field/name=cta_button', 'setup_cta_btn_list_fn' );
function setup_cta_btn_list_fn( $field ) {
    
    // get all files found in VIEWS folder
    $view_dir = plugin_dir_path( __FILE__ ).'partials/images/';
/*    $files = scandir($path);
    $choices = array_diff(scandir($path), array('.', '..'));
    var_dump($choices);
  */

    $data_from_database = setup_pull_view_files( $view_dir );

    //Change this to whatever data you are using.
    /*$data_from_database = array(
        'key1' => 'value1',
        'key2' => 'value2'
    );*/

    $field['choices'] = array();

    //Loop through whatever data you are using, and assign a key/value
    if( is_array( $data_from_database ) ) {

        foreach( $data_from_database as $field_key => $field_value ) {
            $field['choices'][$field_key] = $field_value;
        }

        return $field;

    }
    
}


/**
 * Get VIEW template | this function is called by SETUP-LOG-FLEX.PHP found in PARTIALS/BLOCKS folder
 */
if( !function_exists( 'setup_acfx_pull_view_template' ) ) {

	function setup_acfx_pull_view_template( $layout, $args = FALSE ) {

	    $layout_file = plugin_dir_path( __FILE__ ).'partials/views/'.$layout;
	    
	    if( $args ) {

	        if( array_key_exists( 'id', $args ) ) {

	            global $pid;

	            $pid = $args[ 'id' ];

	        }
	        
	    }
	    
	    if( is_file( $layout_file ) ) {

	        ob_start();

	        include $layout_file;

	        $new_output = ob_get_clean();
	            
	        if( !empty( $new_output ) )
	            $output = $new_output;

	    } else {

	        $output = FALSE;

	    }

	    return $output;

	}

}