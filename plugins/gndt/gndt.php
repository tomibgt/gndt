<?php
/*
Plugin Name: GNDT Plugin
Version: 1.0.0
Author: GNDT Course Team
*/

require_once('includes/publishing/publishing-module.php');

function gndt_activate(){
  /* Add roles... it's important to add roles in the activation function because
  it inserts the roles into the database. Otherwise, you are trying to insert the roles
  every time a page loads. */
  add_role('gndt_user', 'GNDT User', array(
      'gndt_can_view_research_panel' => true,
      'gndt_read_researchposttype' => true,
  ));

  add_role('gndt_admin', 'GNDT Admin', array(
      'gndt_publish_researchposttypes' => true,
      'gndt_edit_researchposttypes' => true,
      'gndt_edit_others_researchposttypes' => true,
      'gndt_read_private_researchposttypes' => true,
      'gndt_edit_researchposttype' => true,
      'gndt_delete_researchposttype' => true,
      'gndt_read_researchposttype' => true,
  ));


  add_role('gndt_scholar', 'GNDT Scholar', array(
      'gndt_read_researchposttype' => true,
      'gndt_edit_researchposttype' => true,
      'gndt_edit_researchposttypes' => true,
      'gndt_delete_researchposttype' => true,
  ));

  add_role('gndt_reviewer', 'GNDT Reviewer', array(
      'gndt_publish_researchposttypes' => true,
      'gndt_read_researchposttype' => true,
      'gndt_edit_researchposttype' => true,
      'gndt_edit_researchposttypes' => true,
      'gndt_delete_researchposttype' => true,
  ));
}

function gndt_deactivate(){ /* Clean up after the plugin. */
  /* Remove custom roles */
  remove_role('gndt_user');
  remove_role('gndt_admin');
  remove_role('gndt_scholar');
  remove_role('gndt_reviewer');
}

register_activation_hook(__FILE__, 'gndt_activate');
register_deactivation_hook(__FILE__, 'gndt_deactivate');
?>
