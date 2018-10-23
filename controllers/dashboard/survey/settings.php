<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardSurveySettingsController extends Controller {

   public function view() {
   		$db = Loader::db();
   		$results = $db->GetArray('select * from FeedbackSettings');
		$this->set('settings',$results[0]);
   }
   
	public function save() { 
		$db = Loader::db();

		// Update existing settings. Loop through each field to construct an update query.
		$count = 0;
		$query = "UPDATE FeedbackSettings SET ";
		foreach($_POST as $field => $val) {
			if ($field != "submit") { 
				if ($count != 0) {
					$query .= ", ";
				}
				$vals[] = $val;
				$query = $query . $field . "= ?";
				$count++;
			}
		}
		$db->execute($query, $vals);
	   	
	   	// Redirect 
	   	Header('Location: /dashboard/survey/settings/' . '?msg=' . urlencode('Settings saved.')); 
	   	
	}
	
}

?>