CREATE OR REPLACE
 ALGORITHM = UNDEFINED
 VIEW view_relationship2way
 AS 
SELECT
 `contact_id_a` AS this_id, a.contact_type AS this_type, a.sort_name AS this_name, is_permission_b_a as this_permission,
 `label_a_b` AS relationship,
 `contact_id_b` AS that_id, b.contact_type AS that_type, b.sort_name AS that_name, is_permission_a_b as that_permission,
 `start_date` , `end_date` , r.description
	FROM `civicrm_relationship` r
	JOIN civicrm_relationship_type t ON relationship_type_id = t.id
	JOIN civicrm_contact a ON contact_id_a = a.id
	JOIN civicrm_contact b ON contact_id_b = b.id
	WHERE r.`is_active` =1
UNION
SELECT
 `contact_id_b` AS this_id, b.contact_type AS this_type, b.sort_name AS this_name, is_permission_a_b as this_permission,
 `label_b_a` AS relationship,
 `contact_id_a` AS that_id, a.contact_type AS that_type, a.sort_name AS that_name, is_permission_b_a as that_permission,
 `start_date` , `end_date` , r.description
	FROM `civicrm_relationship` r
	JOIN civicrm_relationship_type t ON relationship_type_id = t.id
	JOIN civicrm_contact a ON contact_id_a = a.id
	JOIN civicrm_contact b ON contact_id_b = b.id
	WHERE r.`is_active` =1
ORDER BY this_name, that_name;