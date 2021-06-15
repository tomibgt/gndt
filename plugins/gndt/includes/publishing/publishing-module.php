<?php
function gndt_publishing_menu(){ /* Adds Publishing section to the WordPress Administration page. */
  add_menu_page('GNDT Publishing', 'Publishing', 'manage_options', 'gndt_research', 'gndt_menu_research');
}

function gndt_menu_research(){ /* HTML code for the Publishing section. */
/* fill out stub with HTML output... */
}

/* Functions for the metabox. */
function gndt_research_post_metabox_markup(){ /* Code for the contents of the meta box -- Incomplete */
    wp_nonce_field(plugin_basename(__FILE__), 'gndt_attachment_nonce'); /* nonce is used to validate upload */

    $html = '<p class="description">';
    $html .= 'Upload your PDF here.';
    $html .= '</p>';
    $html .= '<input type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="" size="25" />';

    echo $html;
}

function gndt_research_post_metabox(){ /* Adds metabox to control panel */
    add_meta_box('gndt_research_post_metabox', 'Publish Research', 'gndt_research_post_metabox_markup', 'gndt_research', 'normal', 'default', null);
}

function gndt_register_cpt_publishing() { /* Register custom post types for the publishing module */
    register_post_type('gndt_research',
        array(
            'labels'      => array(
                'name'          => __('Research', 'textdomain'),
                'singular_name' => __('Research', 'textdomain'),
            ),
                'public'      => true,
                'has_archive' => true,
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
}

function gndt_register_taxonomy_publishing() { /* Register taxonomies for the publishing module */
      /* Add custom taxonomies */
      $tax_labels = array( /* Add labels for the taxonomies */
        'name'              => _x('Artifacts', 'taxonomy general name'),
        'singular name'     => _x('Artifact', 'taxonomy singular name'),
        'search_items'      => __('Artifacts'),
        'all_items'         => __('All Artifacts'),
        'parent_item'       => __('Parent Artifact'),
        'parent_item_colon' => __('Parent Artifact:'),
        'edit_item'         => __('Edit Artifact'),
        'update_item'       => __('Update Artifact'),
        'add_new_item'      => __('Add Artifact'),
        'new_item_name'     => __('New Artifact'),
        'menu_name'         => __('Artifacts'),
      );

      $tax_args = array(
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'artifact'],
      );

      register_taxonomy('gndt_artifact', ['gndt_research'], $tax_args);
}

function gndt_populate_taxonomy_terms() { /* Add terms to custom taxonomy */
  $tax_terms = array( /* taxonomy terms to add. left: taxonomy name, right: array of args */
    'Awaiting Informal Review'    => ['description' => 'Awaiting Informal Review', 'slug' => 'await_review'],
    'Awaiting Formal Review'      => ['description' => 'Awaiting Formal Review', 'slug' => 'await_formal_review'],
    'Approved by Formal Review'   => ['description' => 'Approved by Formal Review', 'slug' => 'approved_formal'],
    'Approved by Informal Review' => ['description' => 'Approved by Informal Review', 'slug' => 'approved_informal'],
    'Rejected'                    => ['description' => 'Rejected', 'slug' => 'rejected'],
  );

  foreach($tax_terms as $term => $term_args) { /* add taxonomy terms */
      if (!term_exists($term, 'gndt_artifact')) { /* if term doesn't already exist for taxonomy, add it */
        wp_insert_term($term, 'gndt_artifact', $term_args);
      }
  }
}

add_action('init', 'gndt_register_cpt_publishing'); /* Register custom post types. */
add_action('init', 'gndt_register_taxonomy_publishing'); /* Register taxonomies. */
add_action('init', 'gndt_populate_taxonomy_terms'); /* Populate taxonomies with terms. This must be called after the taxonomy is registered. */
add_action('admin_menu', 'gndt_publishing_menu'); /* Register Publishing settings menu in dashboard. */
add_action('add_meta_boxes', 'gndt_research_post_metabox'); /* Hook to add metabox code. */

add_action('admin_menu', 'gndt_populate_taxonomy_terms');
?>
