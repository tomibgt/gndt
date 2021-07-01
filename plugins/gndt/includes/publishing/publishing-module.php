<?php
function gndt_register_cpt_publishing() { /* Register custom post types for the publishing module */
    register_post_type('gndt_research',
        array(
            'labels'      => array(
                'name'          => __('Research', 'textdomain'),
                'singular_name' => __('Research', 'textdomain'),
            ),
          'public'      => true,
          'has_archive' => true,
		  		'show_in_rest' => true,
          'supports' => ['editor'],  /* allow gutenberg editor for this post type */
          'capability_type' => 'gndt_researchposttype',
			  	'capabilities' => array(
					  'publish_posts' => 'gndt_publish_researchposttypes',
					  'edit_posts' => 'gndt_edit_researchposttypes',
					  'edit_others_posts' => 'gndt_edit_others_researchposttypes',
					  'read_private_posts' => 'gndt_read_private_researchposttypes',
					  'edit_post' => 'gndt_edit_researchposttype',
					  'delete_post' => 'gndt_delete_researchposttype',
					  'read_post' => 'gndt_read_researchposttype',
				  ),
        )
    );

	add_post_type_support( 'gndt_research', 'author' ); //add author support to custom post type 
}

add_action('init', 'gndt_register_cpt_publishing'); /* Register custom post types. */
?>
