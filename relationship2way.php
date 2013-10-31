<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require_once 'relationship2way.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function relationship2way_civicrm_config(&$config) {
  _relationship2way_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function relationship2way_civicrm_xmlMenu(&$files) {
  _relationship2way_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function relationship2way_civicrm_install() {
  CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, __DIR__ . '/sql/auto_install.sql');
  return _relationship2way_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function relationship2way_civicrm_uninstall() {
  CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, __DIR__ . '/sql/auto_uninstall.sql');
  return _relationship2way_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function relationship2way_civicrm_enable() {
  return _relationship2way_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function relationship2way_civicrm_disable() {
  return _relationship2way_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function relationship2way_civicrm_managed(&$entities) {
  return _relationship2way_civix_civicrm_managed($entities);
}

?>