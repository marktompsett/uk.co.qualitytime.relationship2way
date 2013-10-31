<?php
/*	display two-way relationships
 *	@package CRM
 * 	@author	Mark Tompsett / QualityTime Services
 */
 
require_once 'CRM/Report/Form.php';

 
class CRM_Report_Form_Contact_relationship2way extends CRM_Report_Form	  {
	
	function __construct()	{
		$this->_columns = array(
			'view'	 => array(
				'dao' 		=> 'CRM_Contact_DAO_Contact',
				'fields'	=> array(
					'this_id' => array(
						'title'		=> ts(''),
						'required'	=> true,
						'no_display'=> true,
					),
					'this_type' => array(
						'title'		=> ts(''),
						'required'	=> true,
						'no_display'=> true,
					),
					'this_permission' => array(
						'title'		=> ts(''),
						'required'	=> true,
						'no_display'=> true,
					),
					'this_name' => array(
						'title'		=> ts('This Contact'),
						'default'	=> true,
					),
					'relationship' => array(
						'title'		=> ts('relationship'),
						'default' 	=> true,
					),
					'that_id' => array(
						'title'		=> ts(''),
						'required'	=> true,
						'no_display'=> true,
					),
					'that_type' => array(
						'title'		=> ts(''),
						'required'	=> true,
						'no_display'=> true,
					),
					'that_permission' => array(
						'title'		=> ts(''),
						'required'	=> true,
						'no_display'=> true,
					),
					'that_name' => array(
						'title'		=> ts('That Contact'),
						'default'	=> true,
					),
					'start_date' => array(
						'title'		=> ts('Start Date'),
						'default' 	=> true,
					),
					'end_date' => array(
						'title'		=> ts('End Date'),
						'default' 	=> true,
					),
					'description' => array(
						'title'		=> ts('Description'),
						'default' 	=> true,
					),
				),
			),
		);
				
		$this->_options = array(
			'my_relationships' => array(
					'title' => ts('My Relationships'),
					'type' => 'checkbox',
			),
		);
				
		parent::__construct();
	}

	function preProcess()	{
		parent::preProcess();
	}

	function select()	{
	
		$select = $this->_columnHeaders = array( );
	
		foreach ($this->_columns as $tableName => $table)	{
			if ( array_key_exists('fields', $table) )	{
				foreach ( $table['fields'] as $fieldName => $field )	{
					if ( CRM_Utils_Array::value('required', $field) || CRM_Utils_Array::value($fieldName, $this->_params['fields']))	{
						$select[] = "{$field['dbAlias']} as {$tableName}_{$fieldName}";
						//	initialising columns as well
						$this->_columnHeaders["{$tableName}_{$fieldName}"]['type'] = CRM_Utils_Array::value('type', $field);
						$this->_columnHeaders["{$tableName}_{$fieldName}"]['title'] = $field['title'];
					}
				}
			}
		}
		$this->_select = "SELECT " . implode( ', ', $select) . " ";
	}
	
	function from()	{
		$this->_from = "FROM view_relationship2way {$this->_aliases['view']}";
	}
	
	function where() {
		$clauses = array();
		$this->_having = '';
		
		if (isset($this->_params['options']['my_relationships'])) {
			$session   = CRM_Core_Session::singleton();
			$userID    = $session->get('userID');
			$clauses[] = " this_id = {$userID}";
		}

		if (empty($clauses)) {
			$this->_where = 'WHERE ( 1 ) ';
		}
		else {
			$this->_where = 'WHERE ' . implode(' AND ', $clauses);
		}
	}
	
	function alterDisplay( &$rows ) {	        // custom code to alter rows
        $entryFound = false;  
        
        foreach ( $rows as $rowNum => $row ) {
			
			$contactType = $rows[$rowNum]['view_this_type'];
			$icon = '<span class="icon crm-icon ' . $contactType . '-icon">' . $contactType . '</span>';
			$rows[$rowNum]['view_this_type'] = $icon;
			$entryFound = true;
			
			if ( array_key_exists('view_this_name', $row) && array_key_exists('view_this_id', $row) ) {
				$name = $rows[$rowNum]['view_this_name' ];
				$rows[$rowNum]['view_this_name' ] = $icon . $name;
                $url = CRM_Utils_System::url( 'civicrm/contact/view', 'reset=1&cid=' . $row['view_this_id'], $this->_absoluteUrl );
                $rows[$rowNum]['view_this_name_link' ] = $url;
				$canView = $rows[$rowNum]['view_this_permission'];
				if ( $canView == 1 ) 	{
					$hoverText = "That Contact can view details for This Contact.";
				} else	{
					$hoverText = "That Contact can only view details for This Contact if has permission to view all contacts";
				}
                $rows[$rowNum]['view_this_name_hover'] = ts($hoverText);
                $entryFound = true;
            }
			
			$contactType = $rows[$rowNum]['view_that_type'];
			$icon = '<span class="icon crm-icon ' . $contactType . '-icon">' . $contactType . '</span>';
			$rows[$rowNum]['view_that_type'] = $icon;
			$entryFound = true;
			
			if ( array_key_exists('view_that_name', $row) && array_key_exists('view_that_id', $row) ) {
				$name = $rows[$rowNum]['view_that_name' ];
				$rows[$rowNum]['view_that_name' ] = $icon . $name;
                $url = CRM_Utils_System::url( 'civicrm/contact/view', 'reset=1&cid=' . $row['view_that_id'], 
											$this->_absoluteUrl );
                $rows[$rowNum]['view_that_name_link' ] = $url;
				$canView = $rows[$rowNum]['view_that_permission'];
				if ( $canView == 1 ) 	{
					$hoverText = "This Contact can view details for That Contact.";
				} else	{
					$hoverText = "This Contact can only view details for That Contact if has permission to view all contacts";
				}
                $rows[$rowNum]['view_that_name_hover'] = ts($hoverText);
                $entryFound = true;
            }

			if ( array_key_exists('view_start_date', $row) )	{
				$value = $rows[$rowNum]['view_start_date'];
				$rows[$rowNum]['view_start_date'] = CRM_Utils_Date::customFormat($value, '%d-%b-%Y');
                $entryFound = true;
			}	
			
			if ( array_key_exists('view_end_date', $row) )	{
				$value = $rows[$rowNum]['view_end_date'];
				$rows[$rowNum]['view_end_date'] = CRM_Utils_Date::customFormat($value, '%d-%b-%Y');
                $entryFound = true;
			}
			
			// skip looking further in rows, if first row itself doesn't have the column(s) we need
            if ( !$entryFound ) {
                break;
            }	
		}
	}
            
}

?>