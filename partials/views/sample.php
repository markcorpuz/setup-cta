<?php

echo get_field( 'cta_label' );

$this_btn = setup_cta_this_dir().'partials/images/'.get_field( 'cta_button' );

$rel_cta_entries = get_field( 'cta_link' );
if( is_array( $rel_cta_entries ) ) {

	if( count( $rel_cta_entries ) > 1 ) {

		echo 'CTA Link should only have 1 entry.';

	} else {

		foreach( get_field( 'cta_link' ) as $val ) {
			echo '<a href="'.get_the_permalink( $val ).'"><img src="'.$this_btn.'" border="0" /></a>';
		}

	}

}

echo get_field( 'cta_link_label' );
