<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function material_design_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  material_design_preprocess_html($variables, $hook);
  material_design_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
/* -- Delete this line if you want to use this function
function material_design_preprocess_html(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // The body tag's classes are controlled by the $classes_array variable. To
  // remove a class from $classes_array, use array_diff().
  //$variables['classes_array'] = array_diff($variables['classes_array'], array('class-to-remove'));
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function material_design_preprocess_page(&$variables, $hook) {
  $variables['primary_local_tasks'] = array(
    '#theme' => 'menu_local_tasks',
    '#primary' => menu_primary_local_tasks(),
  );
  $variables['secondary_local_tasks'] = array(
    '#theme' => 'menu_local_tasks',
    '#secondary' => menu_secondary_local_tasks(),
  );
}
/**
 * Override or insert variables into the field templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 */
function material_design_process_field(&$variables) {
  $element = $variables['element'];

  // Field type image
  if ($element['#field_type'] == 'image') {

    // Reduce number of images in teaser view mode to single image
    if ($element['#view_mode'] == 'teaser') {
      $item = reset($variables['items']);
      $variables['items'] = array($item);
    }

  }

}

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function material_design_preprocess_node(&$variables, $hook) {
  if ($variables['display_submitted']) {
    $variables['submitted_by'] = t('Written by !username', array('!username' => $variables['name']));
    $variables['submitted_on'] = t('!datetime', array('!datetime' => $variables['pubdate']));
  }
  // Optionally, run node-type-specific preprocess functions, like
  // material_design_preprocess_node_page() or material_design_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function material_design_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function material_design_preprocess_region(&$variables, $hook) {
  // Don't use Zen's region--sidebar.tpl.php template for sidebars.
  //if (strpos($variables['region'], 'sidebar_') === 0) {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('region__sidebar'));
  //}
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function material_design_preprocess_block(&$variables, $hook) {
  // Add a count to all the blocks in the region.
  // $variables['classes_array'][] = 'count-' . $variables['block_id'];

  // By default, Zen will use the block--no-wrapper.tpl.php for the main
  // content. This optional bit of code undoes that:
  //if ($variables['block_html_id'] == 'block-system-main') {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('block__no_wrapper'));
  //}
}
// */

function material_design_preprocess_form_element(&$variables) {
  $available = array(
    'checkbox',
    'radio',
  );
  if (in_array($variables['element']['#type'], $available)) {
    $variables['element']['#title_display'] = 'after';
  }
  if (isset($variables['element']['#title_display']) && $variables['element']['#title_display'] == 'before') {
    $variables['element']['#theme_wrappers'][] = 'form_element_label_before_wrapper';
  }

}

function material_design_theme() {
  return array(
    'form_element_label_before_wrapper' => array(
      'render element' => 'element',
    ),
  );
}

function material_design_form_element_label_before_wrapper($variables) {
  $element = $variables['element'];
  return $element['#children'];
}