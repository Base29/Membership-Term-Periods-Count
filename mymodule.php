<?php

require_once 'mymodule.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function mymodule_civicrm_config( &$config ) {
	_mymodule_civix_civicrm_config( $config );
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function mymodule_civicrm_xmlMenu( &$files ) {
	_mymodule_civix_civicrm_xmlMenu( $files );
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function mymodule_civicrm_install() {
	_mymodule_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function mymodule_civicrm_postInstall() {
	_mymodule_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function mymodule_civicrm_uninstall() {
	_mymodule_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function mymodule_civicrm_enable() {
	_mymodule_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function mymodule_civicrm_disable() {
	_mymodule_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function mymodule_civicrm_upgrade( $op, CRM_Queue_Queue $queue = null ) {
	return _mymodule_civix_civicrm_upgrade( $op, $queue );
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function mymodule_civicrm_managed( &$entities ) {
	_mymodule_civix_civicrm_managed( $entities );
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function mymodule_civicrm_caseTypes( &$caseTypes ) {
	_mymodule_civix_civicrm_caseTypes( $caseTypes );
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function mymodule_civicrm_angularModules( &$angularModules ) {
	_mymodule_civix_civicrm_angularModules( $angularModules );
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function mymodule_civicrm_alterSettingsFolders( &$metaDataFolders = null ) {
	_mymodule_civix_civicrm_alterSettingsFolders( $metaDataFolders );
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
 * function mymodule_civicrm_preProcess($formName, &$form) {
 *
 * } // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
 * function mymodule_civicrm_navigationMenu(&$menu) {
 * _mymodule_civix_insert_navigation_menu($menu, NULL, array(
 * 'label' => ts('The Page', array('domain' => 'com.faisalblink.mymodule')),
 * 'name' => 'the_page',
 * 'url' => 'civicrm/the-page',
 * 'permission' => 'access CiviReport,access CiviContribute',
 * 'operator' => 'OR',
 * 'separator' => 0,
 * ));
 * _mymodule_civix_navigationMenu($menu);
 * } // */

/** Function to check and record membership creation and renewal creation. */
function mymodule_civicrm_post( $op, $objectName, $objectId, &$objectRef ) {

	/** @var $membership_table Table that stores membership data on creation and renewal. */
	$membership_table = 'civicrm_view_membership_terms';

	/** Condition to check operation Create or Edit and check Membership module in action  */
	if ( $objectName == 'Membership' && $op == 'create' || $op == 'edit' )
	{

		/** @var $get_data Query for inserting data in to civicrm_view_membership_terms table. */
		$get_data = "insert into $membership_table (membership_contribution_id, membership_id, membership_start_date, membership_end_date, membership_renewal_date) values (0, '$objectRef->id', '$objectRef->start_date', '$objectRef->end_date', now() )";

		/** Executing query */
		CRM_Core_DAO::executeQuery( $get_data );
	}
	/** Condition to check if the MemebershipPayment module in action and operation is Create  */
	elseif ( $objectName == "MembershipPayment" && $op == "create" )
	{
		/** @var $check_contribution Query to check if a contribution record in is the civicrm_view_membership_persiods table. */
		$check_contribution = "SELECT * FROM $membership_table WHERE membership_contribution_id = $objectRef->contribution_id";

		/** @var $check_query_result Executing query */
		$check_query_result = CRM_Core_DAO::executeQuery( $check_contribution );

		/** Condition to check if there is any data returned in $check_query_result from $check_contribution */
		if ( ! ( $check_query_result->fetch() ) )
		{

			/** @var $update_contribution_query query for updating contribution data in civicrm_view_membership_periods */
			$update_contribution_query = "UPDATE $membership_table SET membership_contribution_id = $objectRef->contribution_id WHERE membership_id = $objectRef->membership_id AND membership_contribution_id = 0 ORDER BY id DESC LIMIT 1";

			/** Excecuting query and updating record. */
			CRM_Core_DAO::executeQuery( $update_contribution_query );
		}
	}
}

/**
 * @param $tabsetName
 * @param $tabs
 * @param $context
 * Function to add tab for viewing membership terms.
 */
function mymodule_civicrm_tabset( $tabsetName, &$tabs, $context ) {
	if ( $tabsetName == 'civicrm/contact/view' )
	{
		//for contact view page
		$contact_id        = $context['contact_id'];
		$url               = CRM_Utils_System::url( 'civicrm/my-page', "cid=" . $contact_id );
		$term_count_qry    = "select * from civicrm_view_membership_terms join civicrm_membership on civicrm_membership.id = civicrm_view_membership_terms.membership_id where civicrm_membership.contact_id = $contact_id";
		$term_count_result = CRM_Core_DAO::executeQuery( $term_count_qry );
		$term_count        = 0;
		while ( $term_count_result->fetch() )
		{
			$term_count ++;
		}
		$tabs[] = array(
			'id'    => 'myModuleTab',
			'url'   => $url,
			'title' => 'Membership Terms/Periods',
			'count' => $term_count
		);

	}
}