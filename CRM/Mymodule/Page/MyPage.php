<?php

class CRM_Mymodule_Page_MyPage extends CRM_Core_Page {

	public function run() {
		if ( isset( $_GET['cid'] ) )
		{
			$contact_id   = $_GET['cid'];
			$term_content = '<style>
	.membership_terms {
		border:1px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
	}
	.membership_terms th {
		border:1px solid #C0C0C0;
		padding:5px;
		background:#F0F0F0;
		text-align: center;
	}
	.membership_terms td {
		border:1px solid #C0C0C0;
		padding:5px;
		text-align: center;
	}
</style>
<table class="membership_terms">
	<tbody>';
			$term_qry     = "select * from civicrm_view_membership_terms join civicrm_membership on civicrm_membership.id = civicrm_view_membership_terms.membership_id where civicrm_membership.contact_id = $contact_id";
			$term_result  = CRM_Core_DAO::executeQuery( $term_qry );
			$term_number  = 0;
			while ( $term_result->fetch() )
			{
				$term_content .= '<tr>
		<td>Term/Period ' . ++ $term_number . ': ' . date( 'j M Y', strtotime( $term_result->membership_start_date ) ) . ' - ' . date( 'j M Y', strtotime( $term_result->membership_end_date ) ) . '</td>
	</tr>';
			}

			$term_content .= '</tbody>
</table>';
		}

		$this->assign( 'myPage', $term_content );
		parent::run();
	}
}