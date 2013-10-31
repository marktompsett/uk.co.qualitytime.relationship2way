<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// http://wiki.civicrm.org/confluence/display/CRMDOC42/Hook+Reference
return array (
  0 => 
  array (
    'name' => 'CRM_Report_Form_Contact_relationship2way',			//	must correspond to the filepath of the Report Template 
    'entity' => 'ReportTemplate',									//	this is a Report Template
	'module' => 'uk.co.qualitytime.relationship2way',				//	must match the key of the Extension
    'params' => 
    array (
      'version' => 3,												//	
      'label' => 'Relationship Report (both ways)',					//	name of the report template
      'description' => 'Shows all relationships both ways round',	//	description of the report template
      'class_name' => 'CRM_Report_Form_Contact_relationship2way',	//	must match the class name in the report template (.php) file
      'report_url' => 'uk.co.qualitytime.relationship2way',			//	URL of the report template
      'component' => '',											//	null component, ie appears in the Contact Report Templates
    ),
  ),
);