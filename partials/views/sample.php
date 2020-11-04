<?php

// LABEL
echo '<p>'.get_field( 'cta_label' ).'</p>';


// TITLE
echo '<p>'.get_field( 'cta_title' ).'</p>';


// SUMMARY
echo '<p>'.get_field( 'cta_summary' ).'</p>';


// INFO
echo '<p>'.get_field( 'cta_info' ).'</p>';


// BUTTON
$this_btn = setup_cta_this_dir().'partials/images/'.get_field( 'cta_button' );


// LINK (EXTERNAL)
$link_ex = get_field( 'cta_link_external' );
echo '<p><a href="'.$link_ex.'"><img src="'.$this_btn.'" border="0" /></a></p>';


// LINK (INTERNAL)
$link_in = get_field( 'cta_link_internal' );
if( is_array( $link_in ) ) {

	if( count( $link_in ) > 1 ) {

		echo '<p>CTA Link should only have 1 entry.</p>';

	} else {

		foreach( $link_in as $val ) {
			echo '<p><a href="'.get_the_permalink( $val ).'"><img src="'.$this_btn.'" border="0" /></a></p>';
		}

	}

}