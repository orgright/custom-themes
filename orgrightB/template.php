<?php
/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to orgrightB_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: orgrightB_breadcrumb()
 *
 *   where orgrightB is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/**
 * Implementation of HOOK_theme().
 */
function orgrightB_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  /***
  $hooks['image'] = array(
  'arguments' => array(
  'path' => NULL,
  'alt' => '',
  'title' => '',
  'attributes' => NULL,
  'getsize' => TRUE
  )
  );
   ***/
  // @TODO: Needs detailed comments. Patches welcome!
  $hooks['node_form'] = array(
    'arguments' => array('form' => NULL),
  );
  $hooks['membership_import_members_form'] = array(
    'arguments' => array('form' => NULL),
  );
  $hooks['membership_subscription_wizard'] = array(
    'arguments' => array('form' => NULL),
  );
  $hooks['meeting_template_use_form'] = array(
    'arguments' => array('form' => NULL),
  );
  return $hooks;
}

/***
function orgrightB_image($path, $alt = '', $title = '', $attributes = NULL, $getsize = TRUE) {
if (!$getsize || (is_file($path) && (list($width, $height, $type, $image_attributes) = @getimagesize($path)))) {
$pathx = str_replace("\"'", "", $path);
$attributes = drupal_attributes($attributes);
$url = (url($pathx) == $pathx) ? $pathx : (base_path() . $pathx);
return '<img src="'. check_url($url) .'" alt="'. check_plain($alt) .'" title="'. check_plain($title) .'" '. (isset($image_attributes) ? $image_attributes : '') . $attributes .' />';
}
}
 ***/

function orgrightB_node_form($form) {
  //orgright_debug_msg('portal','Fn: orgrightB_node_form');
  $form_id = $form['form_id']['#value'];
  // Admin form fields and submit buttons must be rendered first, because
  // they need to go to the bottom of the form, and so should not be part of
  // the catch-all call to drupal_render().
  $admin = '';
  if (isset($form['author'])) {
    $admin .= '<div class="authored">';
    $admin .= drupal_render($form['author']);
    $admin .= '</div>';
  }
  if (isset($form['options'])) {
    $admin .= '<div class="options">';
    $admin .= drupal_render($form['options']);
    $admin .= '</div>';
  }
  $buttons = drupal_render($form['buttons']);
  // Everything else gets rendered here, and is displayed
  // before the admin form field and the submit buttons.
  // prepare the display panels for the form fields
  // First fill the panels with node specific fields
  switch ($form_id) {
    case 'member_node_form':
      $panels = orgrightB_member_node_form($form);
      break;
    case 'subscription_node_form':
    case 'membership_subscription_wizard':
      $panels = orgrightB_subscription_node_form($form);
      break;
    case 'subpayment_node_form':
      $panels = orgrightB_subpayment_node_form($form);
      break;
    case 'committee_node_form':
      $panels = orgrightB_committee_node_form($form);
      break;
    case 'role_node_form':
      $panels = orgrightB_role_node_form($form);
      break;
    case 'appointment_node_form':
      $panels = orgrightB_appointment_node_form($form);
      break;
    case 'assignment_node_form':
      $panels = orgrightB_assignment_node_form($form);
      break;
    case 'meeting_node_form':
      $panels = orgrightB_meeting_node_form($form);
      break;
    case 'agenda_item_node_form':
      $panels = orgrightB_agenda_item_node_form($form);
      break;
    case 'mtg_item_node_form':
      $panels = orgrightB_mtg_item_node_form($form);
      break;
    case 'project_node_form':
      $panels = orgrightB_project_node_form($form);
      break;
    case 'projactivity_node_form':
      $panels = orgrightB_projactivity_node_form($form);
      break;
    case 'projreport_node_form':
      $panels = orgrightB_projreport_node_form($form);
      break;
    case 'drawer_node_form':
      $panels = orgrightB_drawer_node_form($form);
      break;
    case 'folder_node_form':
      $panels = orgrightB_folder_node_form($form);
      break;
    case 'document_node_form':
      $panels = orgrightB_document_node_form($form);
      break;
    case 'meeting_template_use_form':
      $panels = orgrightB_meeting_node_form($form);
      if ($form['step']['#value'] == 2) {
        $panels['bottom'] .= drupal_render($form['template']);
      }
      else {
        $panels['bottom'] = '';
      }
      break;
    default:
  }
  // and define the panel variables
  $lupper = ($panels['lupper']) ? '<div class="panel-lupper">' . $panels['lupper'] . '</div>' : '';
  $rupper = ($panels['rupper']) ? '<div class="panel-rupper">' . $panels['rupper'] . '</div>' : '';
  $middle = ($panels['middle']) ? '<div class="panel-middle">' . $panels['middle'] . '</div>' : '';
  $llower = ($panels['llower']) ? '<div class="panel-llower">' . $panels['llower'] . '</div>' : '';
  $rlower = ($panels['rlower']) ? '<div class="panel-rlower">' . $panels['rlower'] . '</div>' : '';
  $bottom = ($panels['bottom']) ? '<div class="panel-bottom">' . $panels['bottom'] . '</div>' : '';
  // include panels in node-form
  $output = '<div class="standard">';
  $output .= $lupper . $rupper . $middle . $llower . $rlower . $bottom;
  // catch-all in case any fields have been missed
  $output .= drupal_render($form);
  // add closing </div> tag for id="standard"
  $output .= '</div>';
  // and finally, the other details
  if (!empty($admin)) {
    $output .= '<div class="admin">' . $admin . '</div>';
  }
  $output .= $buttons;
  return '<div class="node-form">' . $output . '</div>';
}

/**
 * Theme functions for each form
 */
function orgrightB_member_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_member_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['member']);
  $panels['lupper'] .= drupal_render($form['address']);
  $panels['lupper'] .= drupal_render($form['city']);
  $panels['lupper'] .= drupal_render($form['postcode']);
  $panels['lupper'] .= drupal_render($form['joindate']);
  $panels['lupper'] .= drupal_render($form['leavedate']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['phone']);
  $panels['rupper'] .= drupal_render($form['email']);
  $panels['rupper'] .= drupal_render($form['parent']);
  $panels['rupper'] .= drupal_render($form['category']);
  $panels['rupper'] .= drupal_render($form['standing']);
  // add fields to bottom panel
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'member');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_subscription_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_subscription_node_form');
  // add fields to left upper panel
  if (isset($form['member'])) {
    $panels['lupper'] .= drupal_render($form['member']);
  }
  if (isset($form['category'])) {
    $panels['lupper'] .= drupal_render($form['category']);
  }
  $panels['lupper'] .= drupal_render($form['datefrom']);
  $panels['lupper'] .= drupal_render($form['dateto']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['scode']);
  $panels['rupper'] .= drupal_render($form['amount']);
  // add fields to bottom panel
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'subscription');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_subpayment_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_subpayment_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['member']);
  $panels['lupper'] .= drupal_render($form['datepaid']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['scode']);
  $panels['rupper'] .= drupal_render($form['payment']);
  // add fields to bottom panel
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'subpayment');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_committee_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_committee_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['committee']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['parent']);
  // add fields to bottom panel
  $panels['bottom'] .= drupal_render($form['body']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'committee');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_role_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_role_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['role']);
  $panels['lupper'] .= drupal_render($form['committee']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['multiperson']);
  $panels['rupper'] .= drupal_render($form['allowvacant']);
  // add fields to bottom panel
  $panels['bottom'] .= drupal_render($form['body']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'role');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_appointment_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_appointment_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['member']);
  $panels['lupper'] .= drupal_render($form['committee']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['appointtype']);
  $panels['rupper'] .= drupal_render($form['appointdate']);
  $panels['rupper'] .= drupal_render($form['retiredate']);
  // add fields to bottom panel
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'appointment');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_assignment_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_assignment_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['member']);
  $panels['lupper'] .= drupal_render($form['committee']);
  $panels['lupper'] .= drupal_render($form['role']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['assigntype']);
  $panels['rupper'] .= drupal_render($form['assigndate']);
  $panels['rupper'] .= drupal_render($form['ceasedate']);
  // add fields to bottom panel
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'assignment');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_meeting_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_meeting_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['meeting']);
  $panels['lupper'] .= drupal_render($form['committee']);
  $panels['lupper'] .= drupal_render($form['location']);
  $panels['lupper'] .= drupal_render($form['mtgstatus']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['mtgtype']);
  $panels['rupper'] .= drupal_render($form['mtgdate']);
  $panels['rupper'] .= drupal_render($form['start']);
  $panels['rupper'] .= drupal_render($form['finish']);
  // add fields to bottom panel
  $panels['bottom'] .= drupal_render($form['body']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'meeting');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_agenda_item_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_agenda_item_node_form');
  // add fields to middle panel
  $panels['middle'] .= drupal_render($form['meeting']);
  // add fields to left lower panel
  $panels['llower'] .= drupal_render($form['agendaitem']);
  // add fields to right lower panel
  $panels['rlower'] .= drupal_render($form['sequence']);
  $panels['rlower'] .= drupal_render($form['agitstatus']);
  // add fields to bottom panel
  $panels['bottom'] .= drupal_render($form['body']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'agenda_item');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_mtg_item_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_mtg_item_node_form');
  // add fields to middle panel
  $panels['middle'] .= drupal_render($form['meeting']);
  // add fields to left lower panel
  $panels['llower'] .= drupal_render($form['itemname']);
  $panels['llower'] .= drupal_render($form['member']);
  // add fields to right lower panel
  $panels['rlower'] .= drupal_render($form['itemtype']);
  $panels['rlower'] .= drupal_render($form['itemdate']);
  $panels['rlower'] .= drupal_render($form['itemstatus']);
  // add fields to bottom panel
  $panels['bottom'] .= drupal_render($form['body']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'mtg_item');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_project_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_project_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['project']);
  $panels['lupper'] .= drupal_render($form['manager']);
  $panels['lupper'] .= drupal_render($form['meeting']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['projcategory']);
  $panels['rupper'] .= drupal_render($form['projstatus']);
  // add fields to middle panel
  $panels['middle'] .= drupal_render($form['body']);
  // add fields to left lower panel
  $panels['llower'] .= drupal_render($form['projdate']);
  // add fields to right lower panel
  $panels['rlower'] .= drupal_render($form['projdatype']);
  // add fields to bottom panel
  $panels['bottom'] .= drupal_render($form['pschedule']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'project');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_projactivity_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_projactivity_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['activity']);
  $panels['lupper'] .= drupal_render($form['project']);
  $panels['lupper'] .= drupal_render($form['member']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['activicategory']);
  $panels['rupper'] .= drupal_render($form['activistatus']);
  // add fields to middle panel
  $panels['middle'] .= drupal_render($form['body']);
  // add fields to left lower panel
  $panels['llower'] .= drupal_render($form['duration']);
  $panels['llower'] .= drupal_render($form['actividate']);
  $panels['llower'] .= drupal_render($form['actualstart']);
  // add fields to right lower panel
  $panels['rlower'] .= drupal_render($form['duratype']);
  $panels['rlower'] .= drupal_render($form['actividatype']);
  $panels['rlower'] .= drupal_render($form['actualfinish']);
  // add fields to bottom panel
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'projactivity');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_projreport_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_projreport_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['projreport']);
  $panels['lupper'] .= drupal_render($form['member']);
  $panels['lupper'] .= drupal_render($form['projrepdate']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['project']);
  $panels['rupper'] .= drupal_render($form['projactivity']);
  // add fields to bottom panel
  $panels['bottom'] .= drupal_render($form['body']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'projreport');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_drawer_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_drawer_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['drawer']);
  $panels['lupper'] .= drupal_render($form['parent']);
  $panels['lupper'] .= drupal_render($form['drawerperm']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['owner']);
  $panels['rupper'] .= drupal_render($form['drawerstatus']);
  // add fields to bottom panel
  $panels['bottom'] .= drupal_render($form['body']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'drawer');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_folder_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_folder_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['folder']);
  $panels['lupper'] .= drupal_render($form['parent']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['drawer']);
  $panels['rupper'] .= drupal_render($form['folderstatus']);
  // add fields to bottom panel
  $panels['bottom'] .= drupal_render($form['body']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'folder');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_document_node_form(&$form) {
  //orgright_debug_msg('portal','Fn: orgrightB_document_node_form');
  // add fields to left upper panel
  $panels['lupper'] .= drupal_render($form['docname']);
  $panels['lupper'] .= drupal_render($form['member']);
  $panels['lupper'] .= drupal_render($form['folder']);
  $panels['lupper'] .= drupal_render($form['headoc']);
  // add fields to right upper panel
  $panels['rupper'] .= drupal_render($form['docversion']);
  $panels['rupper'] .= drupal_render($form['docdate']);
  $panels['rupper'] .= drupal_render($form['doctype']);
  $panels['rupper'] .= drupal_render($form['docstatus']);
  // add fields to middle panel
  $panels['middle'] .= drupal_render($form['attachment']);
  $panels['middle'] .= drupal_render($form['docdesc']);
  // add fields to left lower panel
  // add fields to right lower panel
  // add fields to bottom panel
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  $panels['bottom'] .= orgrightB_render_custom_fields($form, 'document');
  $panels['bottom'] .= drupal_render($form['notes']);
  $panels['bottom'] .= '<div class="member rule-off"></div>';
  // finished this form
  return $panels;
}

function orgrightB_membership_import_members_form($form) {
  //orgright_debug_msg('portal','Fn: orgrightB_membership_import_members_form');
  //orgright_debug_dump('import members',$form);
  // Admin form fields and submit buttons must be rendered first, because
  // they need to go to the bottom of the form, and so should not be part of
  // the catch-all call to drupal_render().
  $admin = '';
  if (isset($form['author'])) {
    $admin .= '<div class="authored">';
    $admin .= drupal_render($form['author']);
    $admin .= '</div>';
  }
  if (isset($form['options'])) {
    $admin .= '<div class="options">';
    $admin .= drupal_render($form['options']);
    $admin .= '</div>';
  }
  $buttons = drupal_render($form['submit']);
  // Add fields to the panels
  $panels['middle'] .= drupal_render($form['instructions']);
  $panels['middle'] .= drupal_render($form['field_names']);
  $panels['middle'] .= drupal_render($form['csv_file']);
  $panels['llower'] .= drupal_render($form['default_category']);
  $panels['llower'] .= drupal_render($form['default_standing']);
  $panels['rlower'] .= drupal_render($form['add_categories']);
  $panels['rlower'] .= drupal_render($form['add_standings']);
  $panels['bottom'] = '<div class="member rule-off"></div>';
  // Define the panels and add the panel variables
  $middle = ($panels['middle']) ? '<div class="panel-middle">' . $panels['middle'] . '</div>' : '';
  $llower = ($panels['llower']) ? '<div class="panel-llower">' . $panels['llower'] . '</div>' : '';
  $rlower = ($panels['rlower']) ? '<div class="panel-rlower">' . $panels['rlower'] . '</div>' : '';
  $bottom = ($panels['bottom']) ? '<div class="panel-bottom">' . $panels['bottom'] . '</div>' : '';
  // include panels in node-form
  $output = '<div class="standard">';
  $output .= $middle . $llower . $rlower . $bottom;
  // catch-all in case any fields have been missed
  $output .= drupal_render($form);
  // add closing </div> tag for class="standard"
  $output .= '</div>';
  // and finally, the other details
  if (!empty($admin)) {
    $output .= '<div class="admin">' . $admin . '</div>';
  }
  $output .= $buttons;
  return '<div class="node-form">' . $output . '</div>';
}

function orgrightB_membership_subscription_wizard($form) {
  //orgright_debug_msg('portal','Fn: orgrightB_membership_subscription_wizard');
  //orgright_debug_dump('subscription wizard',$form);
  // if this is the first step, use the standard subscription node form
  // function to theme the form, else use a basic function
  if ($form['step']['#value'] == 1) {
    return orgrightB_node_form($form);
  }
  // Okay - just use basic drupal form processing
  $admin = '';
  if (isset($form['author'])) {
    $admin .= '<div class="authored">';
    $admin .= drupal_render($form['author']);
    $admin .= '</div>';
  }
  if (isset($form['options'])) {
    $admin .= '<div class="options">';
    $admin .= drupal_render($form['options']);
    $admin .= '</div>';
  }
  $buttons = drupal_render($form['buttons']);
  $output = '<div class="standard">';
  $output .= drupal_render($form);
  $output .= '</div>';
  // and finally, the other details
  if (!empty($admin)) {
    $output .= '<div class="admin">' . $admin . '</div>';
  }
  $output .= $buttons;
  return '<div class="node-form">' . $output . '</div>';
}

function orgrightB_meeting_template_use_form($form) {
  // use the standard node form for meeting templates
  return orgrightB_node_form($form);
}

/**
 * Include any custom CCK fields into the form
 */
function orgrightB_render_custom_fields(&$form, $type) {
  // Check the database for any custom fields
  $output = '';
  if (variable_get('orgright_custom_fields_' . $type, 0)) {
    $sql = "SELECT field_name FROM {content_node_field_instance} WHERE type_name = '%s' ORDER BY weight";
    $result = db_query($sql, $type);
    while ($field = db_fetch_array($result)) {
      $output .= drupal_render($form[$field['field_name']]);
    }
    if ($output) {
      $output .= '<div class="' . $type . ' rule-off"></div>';
    }
  }
  return $output;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function orgrightB_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function orgrightB_preprocess_page(&$vars, $hook) {
  global $user;
  // To remove a class from $classes_array, use array_diff().
  //$vars['classes_array'] = array_diff($vars['classes_array'], array('class-to-remove'));
  // options for the logout link
  $options = array(
    'attributes' => array('title' => "Log Out from orgRight", 'tabindex' => "-1"),
  );
  $vars['loggedin'] = '<ul><li>';
  if ($user->uid) {
    $vars['loggedin'] .= t('Logged in as <b><em>@name</em></b>', array('@name' => $user->name));
    $vars['loggedin'] .= '</li><li>|</li><li>';
    $vars['loggedin'] .= l(t('Log out'), 'logout', $options);
  }
  else {
    $vars['loggedin'] .= t('Not logged in');
  }
  $vars['loggedin'] .= '</li></ul>';
  // options for the logo image link
  $options = array(
    'attributes' => array(title => 'orgRight Logo'),
    'html' => TRUE,
  );
  $logo = $vars['base_path'] . $vars['directory'] . '/images/logo.gif';
  $img_src = '<img src="' . $logo . '" width="246" height="114" alt="' . t('orgRright Logo') . '" />';
  $vars['orgright_logo'] = l($img_src, $front_page, $options);

  // Align the footer message to the left, and add a theme designer link
  // options for the theme designer link
  $options = array(
    'attributes' => array('target' => '_blank'),
  );
  $vars['footer_message'] = '<p class="float-left">' . $vars['footer_message'] . '</p>';
  $vars['footer_message'] .= '<p class="float-right">';
  $vars['footer_message'] .= l(t('Powered by orgRight'), 'http://orgright.com', $options);
  $vars['footer_message'] .= '</p>';

}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function orgrightB_preprocess_node(&$vars, $hook) {
  // Optionally, run node-type-specific preprocess functions, like
  // orgrightB_preprocess_node_page() or orgrightB_preprocess_node_story().
  /*$function = __FUNCTION__ . '_' . $vars['node']->type;
  if (function_exists($function)) {
    $function($vars, $hook);
  }*/
  // Prepare variables for node display
  $node = $vars['node'];
  $type = $node->type;
  if (isset($vars['terms']) && !empty($vars['terms'])) {
    $node->content['terms'] = '<div class="terms terms-heading tag">' . t('Tags: ') . '</div>';
    $node->content['terms'] .= '<div class="terms terms-inline val">' . $vars['terms'] . '</div>';
    unset($vars['terms']);
  }
  // elect a specific preprocess routine for each node type
  switch ($type) {
    case 'member':
      $vars['content'] = orgrightB_preprocess_node_member($node);
      return;
    case 'subscription':
      $vars['content'] = orgrightB_preprocess_node_subscription($node);
      return;
    case 'subpayment':
      $vars['content'] = orgrightB_preprocess_node_subpayment($node);
      return;
    case 'committee':
      $vars['content'] = orgrightB_preprocess_node_committee($node);
      return;
    case 'role':
      $vars['content'] = orgrightB_preprocess_node_role($node);
      return;
    case 'appointment':
      $vars['content'] = orgrightB_preprocess_node_appointment($node);
      return;
    case 'assignment':
      $vars['content'] = orgrightB_preprocess_node_assignment($node);
      return;
    case 'meeting':
      $vars['content'] = orgrightB_preprocess_node_meeting($node);
      return;
    case 'agenda_item':
      $vars['content'] = orgrightB_preprocess_node_agenda_item($node);
      return;
    case 'mtg_item':
      $vars['content'] = orgrightB_preprocess_node_mtg_item($node);
      return;
    case 'project':
      $vars['content'] = orgrightB_preprocess_node_project($node);
      return;
    case 'projactivity':
      $vars['content'] = orgrightB_preprocess_node_projactivity($node);
      return;
    case 'projreport':
      $vars['content'] = orgrightB_preprocess_node_projreport($node);
      return;
    case 'drawer':
      $vars['content'] = orgrightB_preprocess_node_drawer($node);
      return;
    case 'folder':
      $vars['content'] = orgrightB_preprocess_node_folder($node);
      return;
    case 'document':
      $vars['content'] = orgrightB_preprocess_node_document($node);
      return;
    default:
  }

}

function orgrightB_preprocess_node_member($node) {
  //orgright_debug_dump('Fn: orgrightB_preprocess_node_member',$node);
  // Member type nodes will have 3 panels, upper left & right
  // and a bottom full width region
  $header = '<div class="content-orgright content-member">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['member']['#value'];
  $lupper .= $node->content['address']['#value'];
  $lupper .= $node->content['city']['#value'];
  $lupper .= $node->content['postcode']['#value'];
  $lupper .= $node->content['parent']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['phone']['#value'];
  $rupper .= $node->content['email']['#value'];
  $rupper .= $node->content['joined']['#value'];
  $rupper .= $node->content['dateleft']['#value'];
  $rupper .= $node->content['category']['#value'];
  $rupper .= $node->content['standing']['#value'];
  $rupper .= '</div>';
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="member rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'member');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="member rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="member rule-off"></div>';
    }
    if (isset($node->content['children'])) {
      $bottom .= $node->content['children']['#value'];
      $bottom .= $node->content['children']['#children'];
    }
    $bottom .= $node->content['add-child']['#value'];
    $bottom .= '<div class="member rule-off"></div>';
    if (isset($node->content['assignments'])) {
      $bottom .= $node->content['assignments']['#value'];
      $bottom .= $node->content['assignments']['#children'];
    }
    if (isset($node->content['old-assignments'])) {
      $bottom .= $node->content['old-assignments']['#value'];
      $bottom .= $node->content['old-assignments']['#children'];
    }
    $bottom .= $node->content['add-assignment']['#value'];
    $bottom .= '<div class="member rule-off"></div>';
    if (isset($node->content['appointments'])) {
      $bottom .= $node->content['appointments']['#value'];
      $bottom .= $node->content['appointments']['#children'];
    }
    if (isset($node->content['old-appointments'])) {
      $bottom .= $node->content['old-appointments']['#value'];
      $bottom .= $node->content['old-appointments']['#children'];
    }
    $bottom .= $node->content['add-appointment']['#value'];
    $bottom .= '<div class="member rule-off"></div>';
    if (isset($node->content['subscriptions'])) {
      $bottom .= $node->content['subscriptions']['#value'];
      $bottom .= $node->content['subscriptions']['#children'];
    }
    $bottom .= $node->content['add-subscription']['#value'];
    $bottom .= '<div class="member rule-off"></div>';
    if (isset($node->content['subpayments'])) {
      $bottom .= $node->content['subpayments']['#value'];
      $bottom .= $node->content['subpayments']['#children'];
    }
    $bottom .= $node->content['add-subpayment']['#value'];
    $bottom .= '<div class="member rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="member rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $bottom . $footer;
}

function orgrightB_preprocess_node_subscription($node) {
  // Subscription type nodes will have 3 panels, upper left & right
  // and a bottom full width region
  $header = '<div class="content-orgright content-subscription">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['member']['#value'];
  $lupper .= $node->content['scode']['#value'];
  $lupper .= $node->content['amount']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['start']['#value'];
  $rupper .= $node->content['finish']['#value'];
  $rupper .= $node->content['totpaid']['#value'];
  $rupper .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="subscription rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'subscription');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="subscription rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="subscription rule-off"></div>';
    }
    if (isset($node->content['subpayments'])) {
      $bottom .= $node->content['subpayments']['#value'];
      $bottom .= $node->content['subpayments']['#children'];
    }
    $bottom .= $node->content['add-subpayment']['#value'];
    $bottom .= '<div class="subscription rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="subscription rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $bottom . $footer;
}

function orgrightB_preprocess_node_subpayment($node) {
  // Subscription type nodes will have 3 panels, upper left & right
  // and a bottom full width region
  $header = '<div class="content-orgright content-subpayment">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['member']['#value'];
  $lupper .= $node->content['scode']['#value'];
  $lupper .= $node->content['amount']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['paydate']['#value'];
  $rupper .= $node->content['payment']['#value'];
  $rupper .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="subpayment rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'subpayment');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="subpayment rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="subpayment rule-off"></div>';
    }
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="subpayment rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $bottom . $footer;
}

function orgrightB_preprocess_node_committee($node) {
  // Committee type nodes will have 3 panels, upper left & right
  // and a bottom full width region
  $header = '<div class="content-orgright content-committee">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['committee']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['parent']['#value'];
  $rupper .= '</div>';
  // Prepare the middle panel
  $middle = '<div class="panel-middle">';
  $middle .= $node->content['body']['#value'];
  $middle .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="committee rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'committee');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="committee rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="committee rule-off"></div>';
    }
    if (isset($node->content['subcommittees'])) {
      $bottom .= $node->content['subcommittees']['#value'];
      $bottom .= $node->content['subcommittees']['#children'];
    }
    $bottom .= $node->content['add-subcommittee']['#value'];
    $bottom .= '<div class="committee rule-off"></div>';
    if (isset($node->content['roles'])) {
      $bottom .= $node->content['roles']['#value'];
      $bottom .= $node->content['roles']['#children'];
    }
    $bottom .= $node->content['add-role']['#value'];
    $bottom .= '<div class="committee rule-off"></div>';
    if (isset($node->content['appointments'])) {
      $bottom .= $node->content['appointments']['#value'];
      $bottom .= $node->content['appointments']['#children'];
    }
    $bottom .= $node->content['add-appointment']['#value'];
    $bottom .= '<div class="committee rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="committee rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  return $header . $lupper . $rupper . $middle . $bottom . $footer;
}

function orgrightB_preprocess_node_role($node) {
  // Role type nodes will have 3 panels, upper left & right
  // and a bottom full width region
  $header = '<div class="content-orgright content-role">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['role']['#value'];
  $lupper .= $node->content['committee']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['multiperson']['#value'];
  $rupper .= $node->content['allowvacant']['#value'];
  $rupper .= '</div>';
  // Prepare the middle panel
  $middle = '<div class="panel-middle">';
  $middle .= $node->content['body']['#value'];
  $middle .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="role rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'role');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="role rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="role rule-off"></div>';
    }
    if (isset($node->content['assignments'])) {
      $bottom .= $node->content['assignments']['#value'];
      $bottom .= $node->content['assignments']['#children'];
    }
    $bottom .= $node->content['add-assignment']['#value'];
    $bottom .= '<div class="role rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="role rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $middle . $bottom . $footer;
}

function orgrightB_preprocess_node_appointment($node) {
  // Appointment type nodes will have 3 panels, upper left & right
  // and a bottom full width region
  $header = '<div class="content-orgright content-appointment">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['member']['#value'];
  $lupper .= $node->content['committee']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['appointtype']['#value'];
  $rupper .= $node->content['appointed']['#value'];
  $rupper .= $node->content['retired']['#value'];
  $rupper .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="appointment rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'appointment');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="appointment rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="appointment rule-off"></div>';
    }
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="appointment rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $bottom . $footer;
}

function orgrightB_preprocess_node_assignment($node) {
  // Assignment type nodes will have 3 panels, upper left & right
  // and a bottom full width region
  $header = '<div class="content-orgright content-assignment">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['member']['#value'];
  $lupper .= $node->content['role']['#value'];
  $lupper .= $node->content['committee']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['assigntype']['#value'];
  $rupper .= $node->content['assigned']['#value'];
  $rupper .= $node->content['ceased']['#value'];
  $rupper .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="assignment rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'assignment');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="assignment rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="assignment rule-off"></div>';
    }
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="assignment rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $bottom . $footer;
}

function orgrightB_preprocess_node_meeting($node) {
  // Meeting type nodes will have 3 panels, upper left & right
  // and a bottom full width region
  $header = '<div class="content-orgright content-meeting">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['meeting']['#value'];
  $lupper .= $node->content['committee']['#value'];
  $lupper .= $node->content['location']['#value'];
  $lupper .= $node->content['mtgstatus']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['mtgtype']['#value'];
  $rupper .= $node->content['mtgdate']['#value'];
  $rupper .= $node->content['start']['#value'];
  $rupper .= $node->content['finish']['#value'];
  $rupper .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= $node->content['body-label']['#value'];
    $bottom .= $node->content['body']['#value'];
    $bottom .= '<div class="meeting rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'meeting');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="meeting rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="meeting rule-off"></div>';
    }
    if (isset($node->content['agenda-items'])) {
      $bottom .= $node->content['agenda-items']['#value'];
      $bottom .= $node->content['agenda-items']['#children'];
    }
    $bottom .= $node->content['add-agenda-item']['#value'];
    $bottom .= '<div class="meeting rule-off"></div>';
    if (isset($node->content['mtg-items'])) {
      $bottom .= $node->content['mtg-items']['#value'];
      $bottom .= $node->content['mtg-items']['#children'];
    }
    $bottom .= $node->content['add-mtg-item']['#value'];
    $bottom .= '<div class="meeting rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="meeting rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $bottom . $footer;
}

function orgrightB_preprocess_node_agenda_item($node) {
  // Agenda-item type nodes will have 3 panels, upper left & right
  // and a bottom full width region
  $header = '<div class="content-orgright content-agenda-item">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['agenda-item']['#value'];
  $lupper .= $node->content['sequence']['#value'];
  $lupper .= $node->content['agitstatus']['#value'];
  $lupper .= $node->content['committee']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['meeting']['#value'];
  $rupper .= $node->content['mtgtype']['#value'];
  $rupper .= $node->content['mtgdate']['#value'];
  $rupper .= '</div>';
  // Prepare the bottom panel
  $bottom = '<div class="panel-bottom">';
  $bottom .= $node->content['body-label']['#value'];
  $bottom .= $node->content['body']['#value'];
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    $bottom .= '<div class="agenda-item rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'agenda_item');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="agenda-item rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="agenda-item rule-off"></div>';
    }
    $bottom .= $node->content['add-agenda-item']['#value'];
    $bottom .= '<div class="agenda-item rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="agenda-item rule-off"></div>';
    }
  }
  $bottom .= '</div>';
  // all done
  return $header . $lupper . $rupper . $bottom . $footer;
}

function orgrightB_preprocess_node_mtg_item($node) {
  // Mtg-item type nodes will have 3 panels, upper left & right
  // and a bottom full width region
  $header = '<div class="content-orgright content-mtg-item">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['itemname']['#value'];
  $lupper .= $node->content['member']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['itemtype']['#value'];
  $rupper .= $node->content['itemdate']['#value'];
  $rupper .= $node->content['itemstatus']['#value'];
  $rupper .= '</div>';
  // Prepare the middle panel
  $middle = '<div class="panel-middle">';
  $middle .= $node->content['meeting']['#value'];
  $middle .= '</div>';
  // Prepare the lower left panel
  $llower = '<div class="panel-llower">';
  $llower .= $node->content['committee']['#value'];
  $llower .= '</div>';
  // Prepare the lower right panel
  $rlower = '<div class="panel-rlower">';
  $rlower .= $node->content['mtgtype']['#value'];
  $rlower .= $node->content['mtgdate']['#value'];
  $rlower .= '</div>';
  // Prepare the bottom panel
  $bottom = '<div class="panel-bottom">';
  $bottom .= $node->content['body-label']['#value'];
  $bottom .= $node->content['body']['#value'];
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    $bottom .= '<div class="mtg-item rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'mtg_item');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="mtg-item rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="mtg-item rule-off"></div>';
    }
    $bottom .= $node->content['add-mtg-item']['#value'];
    $bottom .= '<div class="mtg-item rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="mtg-item rule-off"></div>';
    }
  }
  $bottom .= '</div>';
  // all done
  return $header . $lupper . $rupper . $middle . $llower . $rlower . $bottom . $footer;
}

function orgrightB_preprocess_node_project($node) {
  // Project type nodes will have 6 panels, upper left & right,
  // a full width middle, then a lower left & right,
  // and a bottom full width region
  $header = '<div class="content-orgright content-project">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['project']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['manager']['#value'];
  $rupper .= '</div>';
  // Prepare the middle panel
  $middle = '<div class="panel-middle">';
  $middle .= $node->content['body-label']['#value'];
  $middle .= $node->content['body']['#value'];
  $middle .= '</div>';
  // Prepare the lower left panel
  $llower = '<div class="panel-llower">';
  $llower .= $node->content['projcategory']['#value'];
  $llower .= $node->content['projstatus']['#value'];
  $llower .= $node->content['recalc']['#value'];
  $llower .= '</div>';
  // Prepare the lower right panel
  $rlower = '<div class="panel-rlower">';
  $rlower .= $node->content['projdatype']['#value'];
  $rlower .= $node->content['projdate']['#value'];
  $rlower .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="project rule-off"></div>';
    $bottom .= $node->content['projsched']['#value'];
    $bottom .= $node->content['recalc-sched']['#value'];
    $bottom .= '<div class="project rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'project');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="project rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="project rule-off"></div>';
    }
    if (isset($node->content['activities'])) {
      $bottom .= $node->content['activities']['#value'];
      $bottom .= $node->content['activities']['#children'];
    }
    $bottom .= $node->content['add-activity']['#value'];
    $bottom .= '<div class="meeting rule-off"></div>';
    if (isset($node->content['reports'])) {
      $bottom .= $node->content['reports']['#value'];
      $bottom .= $node->content['reports']['#children'];
    }
    $bottom .= $node->content['add-report']['#value'];
    $bottom .= '<div class="project rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="project rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $middle . $llower . $rlower . $bottom . $footer;
}

function orgrightB_preprocess_node_projactivity($node) {
  // Project type nodes will have 6 panels, upper left & right,
  // a full width middle, then a lower left & right,
  // and a bottom full width region
  $header = '<div class="content-orgright content-projactivity">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['project']['#value'];
  $lupper .= $node->content['activity']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['member']['#value'];
  $rupper .= '</div>';
  // Prepare the middle panel
  $middle = '<div class="panel-middle">';
  $middle .= $node->content['body-label']['#value'];
  $middle .= $node->content['body']['#value'];
  $middle .= '</div>';
  // Prepare the lower left panel
  $llower = '<div class="panel-llower">';
  $llower .= $node->content['activicategory']['#value'];
  $llower .= $node->content['activistatus']['#value'];
  $llower .= $node->content['duration']['#value'];
  $llower .= $node->content['time-units']['#value'];
  $llower .= '</div>';
  // Prepare the lower right panel
  $rlower = '<div class="panel-rlower">';
  $rlower .= $node->content['actividatype']['#value'];
  $rlower .= $node->content['actividate']['#value'];
  $rlower .= $node->content['actualstart']['#value'];
  $rlower .= $node->content['actualfinish']['#value'];
  $rlower .= $node->content['schedstart']['#value'];
  $rlower .= $node->content['schedfinish']['#value'];
  $rlower .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="projactivity rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'projactivity');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="projactivity rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="projactivity rule-off"></div>';
    }
    $bottom .= $node->content['link-activities']['#value'];
    $bottom .= $node->content['add-activity']['#value'];
    $bottom .= '<div class="projactivity rule-off"></div>';
    if (isset($node->content['reports'])) {
      $bottom .= $node->content['reports']['#value'];
      $bottom .= $node->content['reports']['#children'];
    }
    $bottom .= $node->content['add-report']['#value'];
    $bottom .= '<div class="projactivity rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="projactivity rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $middle . $llower . $rlower . $bottom . $footer;
}

function orgrightB_preprocess_node_projreport($node) {
  // Projreport type nodes will have 3 panels, upper left & right
  // and a bottom full width region
  $header = '<div class="content-orgright content-projreport">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['project']['#value'];
  $lupper .= $node->content['activity']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['member']['#value'];
  $rupper .= $node->content['projrepdate']['#value'];
  $rupper .= '</div>';
  // Prepare the bottom panel
  $bottom = '<div class="panel-bottom">';
  $bottom .= $node->content['body-label']['#value'];
  $bottom .= $node->content['body']['#value'];
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    $bottom .= '<div class="report rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'projreport');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="report rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="report rule-off"></div>';
    }
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="report rule-off"></div>';
    }
  }
  $bottom .= '</div>';
  return $header . $lupper . $rupper . $bottom . $footer;
}

function orgrightB_preprocess_node_drawer($node) {
  // Drawer type nodes will have 3 panels, upper left & right
  // and a lower full width region
  $header = '<div class="content-orgright content-drawer">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['drawer']['#value'];
  $lupper .= $node->content['owner']['#value'];
  $lupper .= $node->content['parent']['#value'];
  $lupper .= $node->content['drawerstatus']['#value'];
  $lupper .= $node->content['drawerperm']['#value'];
  $rupper .= $node->content['body-label']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['body']['#value'];
  $rupper .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="drawer rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'drawer');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="drawer rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="drawer rule-off"></div>';
    }
    $bottom .= $node->content['add-drawer']['#value'];
    if (isset($node->content['subdrawers'])) {
      $bottom .= $node->content['subdrawers']['#value'];
      $bottom .= $node->content['subdrawers']['#children'];
    }
    $bottom .= $node->content['add-subdrawer']['#value'];
    $bottom .= '<div class="drawer rule-off"></div>';
    if (isset($node->content['folders'])) {
      $bottom .= $node->content['folders']['#value'];
      $bottom .= $node->content['folders']['#children'];
    }
    $bottom .= $node->content['add-folder']['#value'];
    $bottom .= '<div class="drawer rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="drawer rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $bottom . $footer;
}

function orgrightB_preprocess_node_folder($node) {
  // Folder type nodes will have 3 panels, upper left & right
  // and a lower full width region
  $header = '<div class="content-orgright content-folder">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['folder']['#value'];
  $lupper .= $node->content['parent']['#value'];
  $lupper .= $node->content['drawer']['#value'];
  $lupper .= $node->content['folderstatus']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['body-label']['#value'];
  $rupper .= $node->content['body']['#value'];
  $rupper .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="folder rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'folder');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= '<div class="folder rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="folder rule-off"></div>';
    }
    $bottom .= $node->content['add-folder']['#value'];
    $bottom .= '<div class="folder rule-off"></div>';
    if (isset($node->content['subfolders'])) {
      $bottom .= $node->content['subfolders']['#value'];
      $bottom .= $node->content['subfolders']['#children'];
    }
    $bottom .= $node->content['add-subfolder']['#value'];
    $bottom .= '<div class="folder rule-off"></div>';
    if (isset($node->content['documents'])) {
      $bottom .= $node->content['documents']['#value'];
      $bottom .= $node->content['documents']['#children'];
    }
    $bottom .= $node->content['add-document']['#value'];
    $bottom .= '<div class="folder rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    if (isset($node->content['add-doclink'])) {
      $bottom .= $node->content['add-doclink']['#value'];
      $bottom .= '<div class="folder rule-off"></div>';
    }
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $bottom . $footer;
}

function orgrightB_preprocess_node_document($node) {
  // Project type nodes will have 6 panels, upper left & right,
  // a full width middle, then a lower left & right,
  // and a bottom full width region
  $header = '<div class="content-orgright content-document">';
  $footer = '</div>';
  // Prepare the upper left panel
  $lupper = '<div class="panel-lupper">';
  $lupper .= $node->content['docname']['#value'];
  $lupper .= $node->content['member']['#value'];
  $lupper .= $node->content['folder']['#value'];
  $lupper .= $node->content['headoc']['#value'];
  $lupper .= '</div>';
  // Prepare the upper right panel
  $rupper = '<div class="panel-rupper">';
  $rupper .= $node->content['docversion']['#value'];
  $rupper .= $node->content['docdate']['#value'];
  $rupper .= $node->content['doctype']['#value'];
  $rupper .= $node->content['docstatus']['#value'];
  $rupper .= '</div>';
  // Prepare the middle panel
  $middle = '<div class="panel-middle">';
  $middle .= '<div class="document rule-off"></div>';
  $middle .= $node->content['docdesc']['#value'];
  //if (isset($node->teaser)) {
  // skip these items for teaser display
  $middle .= '<div class="document rule-off"></div>';
  //$middle .= $node->content['body-label']['#value'];
  //$middle .= $node->content['body']['#value'];
  $middle .= $node->content['nodebody']['#value'];
  //}
  $middle .= '<div class="document rule-off"></div>';
  $middle .= '</div>';
  // Prepare the lower left panel
  $llower = '<div class="panel-llower">';
  $llower .= $node->content['filename']['#value'];
  $llower .= '</div>';
  // Prepare the lower right panel
  $rlower = '<div class="panel-rlower">';
  $rlower .= $node->content['filemime']['#value'];
  $rlower .= '</div>';
  // Done if a teaser view is all that is required
  // will be more if a full page is being generated
  if (isset($node->body)) {
    // Prepare the bottom panel
    $bottom = '<div class="panel-bottom">';
    $bottom .= '<div class="document rule-off"></div>';
    $bottom .= orgrightB_content_cck_fields($node, 'document');
    $bottom .= $node->content['notes']['#value'];
    $bottom .= $node->content['new-version']['#value'];
    $bottom .= '<div class="folder rule-off"></div>';
    if (isset($node->content['terms'])) {
      $bottom .= $node->content['terms'];
      $bottom .= '<div class="document rule-off"></div>';
    }
    if (isset($node->content['attachments'])) {
      $bottom .= $node->content['attachments']['#value'];
      $bottom .= $node->content['attachments']['#children'];
    }
    $bottom .= $node->content['add-attachment']['#value'];
    $bottom .= '<div class="folder rule-off"></div>';
    $bottom .= $node->content['add-document']['#value'];
    $bottom .= '<div class="folder rule-off"></div>';
    if (isset($node->content['doclinks'])) {
      $bottom .= $node->content['doclinks']['#value'];
      $bottom .= $node->content['doclinks']['#children'];
    }
    $bottom .= $node->content['add-doclink']['#value'];
    $bottom .= '<div class="document rule-off"></div>';
    $bottom .= '</div>';
  }
  else {
    $bottom = '';
  }
  // all done
  return $header . $lupper . $rupper . $middle . $llower . $rlower . $bottom . $footer;
}

/**
 * Include any custom CCK fields in the content to be displayed
 */
function orgrightB_content_cck_fields($node, $type) {
  // Check the database for any custom fields
  $output = '';
  if (variable_get('orgright_custom_fields_' . $type, 0)) {
    $sql = "SELECT field_name FROM {content_node_field_instance} WHERE type_name = '%s' ORDER BY weight";
    $result = db_query($sql, $type);
    while ($field = db_fetch_object($result)) {
      $field_name = $field->field_name;
      $output .= $node->content[$field_name]['#children'];
    }
    if ($output) {
      $output = '<div class="' . $type . ' custom-fields">' . $output . '</div>';
      $output .= '<div class="' . $type . ' rule-off"></div>';
    }
  }
  return $output;

}


/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function orgrightB_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function orgrightB_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/*
 * Almost identical to menu_tree_output, except distinguishes between
 * levels of the menu.  Therefore the top level (this function) may
 * be handled differently to the second (dropdown) level.
 */
function orgrightB_toplevel_menu_output($tree, $attributes = array('class' => 'links'), $heading = '') {
  $output = '';
  $items = array();

  // Pull out just the menu items we are going to render so that we
  // get an accurate count for the first/last classes.
  foreach ($tree as $data) {
    if (!$data['link']['hidden']) {
      $items[] = $data;
    }
  }

  $num_items = count($items);
  foreach ($items as $i => $data) {
    $extra_class = array();
    $extra_class[] = 'menu-' . $data['link']['mlid'];
    if ($i == 0) {
      $extra_class[] = 'first';
    }
    if ($i == $num_items - 1) {
      $extra_class[] = 'last';
    }
    $extra_class = implode(' ', $extra_class);
    $link = theme('menu_item_link', $data['link']);
    if ($data['below']) {
      //Theme the link, and its children
      $output .= theme('menu_item', $link, $data['link']['has_children'], orgrightB_dropdown_menu_output($data['below']), $data['link']['in_active_trail'], $extra_class);
    }
    else {
      //Just theme the link, no children
      $output .= theme('menu_item', $link, $data['link']['has_children'], '', $data['link']['in_active_trail'], $extra_class);
    }
  }
  return $output ? theme('menu_tree', $output, $attributes, $heading) : '';
}

/*
 * Almost the same as menu_tree_output except the levels are distinguished.
 * In the case of this function (the second level), no more children are
 * added on as we only want two levels of menu.  This also allows better
 * access to the theming of the menus.
 */
function orgrightB_dropdown_menu_output($tree) {
  $output = '';
  $items = array();

  // Pull out just the menu items we are going to render so that we
  // get an accurate count for the first/last classes.
  foreach ($tree as $data) {
    if (!$data['link']['hidden']) {
      $items[] = $data;
    }
  }

  $num_items = count($items);

  foreach ($items as $i => $data) {
    $extra_class = array();
    if ($i == 0) {
      $extra_class[] = 'first';
    }
    if ($i == $num_items - 1) {
      $extra_class[] = 'last';
    }

    $extra_class = implode(' ', $extra_class);
    $link = theme('menu_item_link', $data['link']);

    //Just theme the link, no children even if it has some
    $output .= theme('menu_item', $link, $data['link']['has_children'], '', $data['link']['in_active_trail'], $extra_class);
  }
  return $output ? theme('menu_tree', $output) : '';
}

/*
 * Themes the menu tree - adds heading if specified and uses attributes
 * as specified
 */
function orgrightB_menu_tree($tree, $attributes = array(), $heading = '') {
  global $user;
  // no links for anonymous users
  if (!$user->uid) {
    return '';
  }

  global $language;
  $output = '';

  // Treat the heading first if it is present to prepend it to the
  // list of links.
  if (!empty($heading)) {
    if (is_string($heading)) {
      // Prepare the array that will be used when the passed heading
      // is a string.
      $heading = array(
        'text' => $heading,
        // Set the default level of the heading.
        'level' => 'h2',
      );
    }
    $output .= '<' . $heading['level'];
    if (!empty($heading['class'])) {
      $output .= drupal_attributes(array('class' => $heading['class']));
    }
    $output .= '>' . check_plain($heading['text']) . '</' . $heading['level'] . '>';
  }
  $output .= '<ul' . drupal_attributes($attributes) . '>';
  $output .= $tree . "</ul>";

  return $output;
}

/**
 * Override the default theme function for primary and secondary links
 */
/**
 * Return a themed set of links.
 *
 * @param $links
 *   A keyed array of links to be themed.
 * @param $attributes
 *   A keyed array of attributes
 * @return
 *   A string containing an unordered list of links.
 */
function orgrightB_links($links, $attributes = array('class' => 'links'), $heading = '') {
  global $user;
  // no links for anonymous users
  if (!$user->uid) {
    return '';
  }

  global $language;
  $output = '';

  if (count($links) > 0) {
    // Treat the heading first if it is present to prepend it to the
    // list of links.
    if (!empty($heading)) {
      if (is_string($heading)) {
        // Prepare the array that will be used when the passed heading
        // is a string.
        $heading = array(
          'text' => $heading,
          // Set the default level of the heading.
          'level' => 'h2',
        );
      }
      $output .= '<' . $heading['level'];
      if (!empty($heading['class'])) {
        $output .= drupal_attributes(array('class' => $heading['class']));
      }
      $output .= '>' . check_plain($heading['text']) . '</' . $heading['level'] . '>';
    }

    $output .= '<ul' . drupal_attributes($attributes) . '>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = $key;

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class .= ' first';
      }
      if ($i == $num_links) {
        $class .= ' last';
      }
      if (isset($link['href']) && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page()))
        && (empty($link['language']) || $link['language']->language == $language->language)
      ) {
        $class .= ' active';
      }
      $output .= '<li' . drupal_attributes(array('class' => $class)) . '>';

      if (isset($link['href'])) {
        // Pass in $link as $options, they share the same keys.
        $output .= l($link['title'], $link['href'], $link);
      }
      else {
        if (!empty($link['title'])) {
          // Some links are actually not links, but we wrap these in <span> for adding title and class attributes
          if (empty($link['html'])) {
            $link['title'] = check_plain($link['title']);
          }
          $span_attributes = '';
          if (isset($link['attributes'])) {
            $span_attributes = drupal_attributes($link['attributes']);
          }
          $output .= '<span' . $span_attributes . '>' . $link['title'] . '</span>';
        }
      }

      $i++;
      $output .= "</li>\n";
    }

    $output .= '</ul>';
  }

  return $output;
}

/*
function orgrightB_links($links, $attributes = array('class' => 'links')) {
  global $user;
  // no links for anonymous users
  if (!$user->uid) { return ''; }

 global $language;
  $output = '';

  if (count($links) > 0) {
    $output = '<ul'. drupal_attributes($attributes) .'>';

    $num_links = count($links);
    $i = 0;
    foreach ($links as $key => $link) {
      $i++;
      $class = $key . ' navlink';
      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class .= ' first';
      }
      if ($i == $num_links) {
        $class .= ' last';
      }
      if (isset($link['href']) && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page()))
          && (empty($link['language']) || $link['language']->language == $language->language)) {
        $class .= ' active';
      }
      $output .= '<li'. drupal_attributes(array('class' => $class)) .'>';

      if (isset($link['href'])) {
        // Pass in $link as $options, they share the same keys.
        $output .= l($link['title'], $link['href'], $link);
      }
      else if (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span'. $span_attributes .'>'. $link['title'] .'</span>';
      }
      $output .= "</li>\n";
      if ($i < $num_links) {
        $output .= '<li class="divider">&nbsp;</li>';
      }
    }

    $output .= '</ul>';
  }

  return $output;
}
// */

/**
 * Override the orgRight theming functions
 */
function orgrightB_orgright_heading($module, $class, $value) {
  //orgright_debug_msg('theme','heading, module='.$module.', class='.$class);
  $classes = $module . ' heading ' . $class;
  $output = '<div class="' . $classes . '">' . $value . ': </div>';
  return $output;
}

function orgrightB_orgright_item($module, $class, $description, $item, $node_ref = 0) {
  //orgright_debug_msg('theme','item, module='.$module.', class='.$class);
  // General function for themeing an item value to be displayed.
  $classes = $module . ' item ' . $class;
  $item = preg_replace('|\r\n|', '<br>', $item);
  $output = '<div class="' . $classes . '">';
  if ($description) {
    $output .= '<div class="item-tag">' . $description . ': </div>';
  }
  if ($item) {
    $output .= '<div class="item-val">';
    $output .= ($node_ref) ? l($item, 'node/' . $node_ref) : $item;
    $output .= '</div>';
  }
  $output .= '</div>';
  return $output;
}

function orgrightB_orgright_subitem($module, $class, $subitem, $node_ref, $attributes) {
  //orgright_debug_msg('theme','subitem, module='.$module.', class='.$class);
  // General function for themeing a sub-item set of values to be displayed.
  $classes = $module . ' subitem ' . $class;
  $output = '<div class="' . $classes . '"><div class="subitem-tag">';
  $output .= ($node_ref) ? l($subitem, 'node/' . $node_ref) : $subitem;
  $output .= '&nbsp;</div><div class="subitem-val">';
  foreach ($attributes as $value) {
    $output .= $value;
  }
  $output .= '</div></div>';
  return $output;
}

function orgrightB_orgright_link($module, $class, $link) {
  //orgright_debug_msg('theme','link, module='.$module.', class='.$class);
  $classes = $module . ' link ' . $class;
  $output = '<div class="' . $classes . '">' . $link . '</div>';
  return $output;
}
