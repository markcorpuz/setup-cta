<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * Add a block category for "Setup" if it doesn't exist already.
 *
 * @ param array $categories Array of block categories.
 *
 * @ return array
 */
add_filter( 'block_categories', 'setup_block_categories_fn_acf' );
function setup_block_categories_fn_acf( $categories ) {

    $category_slugs = wp_list_pluck( $categories, 'slug' );

    return in_array( 'setup', $category_slugs, TRUE ) ? $categories : array_merge(
        array(
            array(
                'slug'  => 'setup',
                'title' => __( 'Setup', 'mydomain' ),
                'icon'  => null,
            ),
        ),
        $categories
    );

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
    
	foreach( $blocks as $block ) {
		acf_register_block_type( $block );
	}
  
}


/**
 * Auto fill LAYOUT Select options
 *
 */
add_filter( 'acf/load_field/name=cta_layout', 'setup_cta_view_list_fn' );
function setup_cta_view_list_fn( $field ) {

    // get all files found in VIEWS folder
    $view_dir = plugin_dir_path( __FILE__ ).'partials/views/';

    $data_from_database = setup_pull_view_files( $view_dir );

    // set array
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
 * Auto fill BUTTON Select options
 *
 */
add_filter( 'acf/load_field/name=cta_button', 'setup_cta_btn_list_fn' );
function setup_cta_btn_list_fn( $field ) {
    
    // get all files found in VIEWS folder
    $view_dir = plugin_dir_path( __FILE__ ).'partials/images/';

    $data_from_database = setup_pull_view_files( $view_dir );

    // set array
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

	function setup_acfx_pull_view_template( $layout ) {

	    $layout_file = plugin_dir_path( __FILE__ ).'partials/views/'.$layout;
	    
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


// pull all files found in $directory but get rid of the dots that scandir() picks up in Linux environments
if( !function_exists( 'setup_pull_view_files' ) ) {

    function setup_pull_view_files( $directory ) {

        $out = array();
        
        // get all files inside the directory but remove unnecessary directories
        $ss_plug_dir = array_diff( scandir( $directory ), array( '..', '.' ) );
        
        foreach ($ss_plug_dir as $value) {
            
            // combine directory and filename
            $file = basename( $directory.$value, ".php" );

            // filter files to include
            if( $file ) {
                $out[ $value ] = $file;
            }

        }

        // Return an array of files (without the directory)
        return $out;

    }
    
}