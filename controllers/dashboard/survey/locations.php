<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardSurveyLocationsController extends Controller {

	public function view() {
			$db = Loader::db();
			$results = $db->GetArray('select * from FeedbackLocations');
		$this->set('locations',$results);
	}

	public function add() {
		$db = Loader::db();
		if ($_POST['name'] != "") {
			$options = $db->Execute('INSERT INTO FeedbackLocations(name, yelpUrl, googleUrl, facebookUrl) VALUES (?, ?, ?, ?)', array($_POST['name'], $_POST['yelpUrl'], $_POST['googleUrl'], $_POST['facebookUrl']));
			Header('Location: ' . '/dashboard/survey/locations/?msg=' . urlencode('Location added.'));
		}
	}

	public function update() {
		$db = Loader::db();
		if ($_POST['id'] != "") {
			$options = $db->Execute('UPDATE FeedbackLocations SET name = ?, yelpUrl = ?, googleUrl = ?, facebookUrl = ? WHERE id = ?', array($_POST['name'], $_POST['yelpUrl'], $_POST['googleUrl'], $_POST['facebookUrl'], $_POST['id']));
			Header('Location: ' . '/dashboard/survey/locations/?msg=' . urlencode('Location updated.'));
		}
	}

	public function delete($id) {
		$db = Loader::db();
		$options = $db->Execute('DELETE from FeedbackLocations WHERE id = ?', array(intval($id)));
		Header('Location: ' . '/dashboard/survey/locations/?msg=' . urlencode('Location deleted.'));
	}
	
}

?>