<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
class SurveyController extends Controller {

	public function view($arg = '') {

	}
	
	public function initial() { 
		header('Content-Type: application/json');
		$db = Loader::db();

		if ($_POST['ip'] && $_POST['repairOrPurchase']) {
			$db->Execute('insert into FeedbackSurveys (ip, repairOrPurchase, createDate) values (?,?, NOW())', array($_POST['ip'], $_POST['repairOrPurchase']));
			$id = $db->Insert_ID();
			$result = $db->Execute('select * from FeedbackLocations where id = ?', array($_POST['location']));
			$location = $result->FetchRow();
			echo json_encode(array("id"=>$id)); 
		}
		die();
	}

	public function location() { 
		header('Content-Type: application/json');
		$db = Loader::db();

		if ($_POST['location']) {
			$db->Execute('update FeedbackSurveys set location = ? where id =?', array($_POST['location'], $_POST['id']));
			$result = $db->Execute('select * from FeedbackLocations where id = ?', array($_POST['location']));
			$location = $result->FetchRow();
			echo json_encode(array("id"=>$id, "location"=>$location)); 
		}
		die();
	}

	public function satisfaction() { 
		header('Content-Type: application/json');
		$db = Loader::db();
		
		$type = $_POST['type']; 
		
		// In case some bad input comes in somehow..
		if ($type == "repairExperienceSatisfied") {
			if ($_POST['id'] && $_POST['repairExperienceValue1']) {
				$db->Execute('
						update FeedbackSurveys set 
						repairExperienceValue1 = ?, 
						repairExperienceValue2 = ?,
						repairExperienceValue3 = ?,
						repairExperienceValue4 = ?,
						repairExperienceValue5 = ?
						where id = ?
					',
					array(
						$_POST['repairExperienceValue1'],
						$_POST['repairExperienceValue2'],
						$_POST['repairExperienceValue3'],
						$_POST['repairExperienceValue4'],
						$_POST['repairExperienceValue5'],
						$_POST['id']
					)
				);
			}
		} elseif ($type == "purchaseExperienceSatisfied" || $type == "deliveryExperienceSatisfied") {
			if ($_POST['id'] && $_POST['satisfaction']) {
				$db->Execute('update FeedbackSurveys set ' . $type . ' = ? where id = ?', array($_POST['satisfaction'], $_POST['id']));
			}
		} 

		die();
	}

	public function feedback() { 
		header('Content-Type: application/json');
		$db = Loader::db();
				
		/*
		// If the hidden field is there, it's probably spam, and captcha needs to be validated
		if ($_POST['formValid']) {
			if (strtoupper($_SESSION['securimage_code_value']) == trim(strtoupper($_GET['ccmCaptchaCode']))) {
				$passCaptcha = true;
			} else {
				$passCaptcha = false;
			}
		} else {
			$passCaptcha = true;
		}
		*/

		// Submit Form - Check to make sure form properly goes through the javascript routine
		if( $_POST['id'] ){
			$db->Execute('update FeedbackSurveys set firstName = ?, lastName = ?, email = ?, phone = ?, comments = ? where id = ?', 
				array($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['phone'], $_POST['comments'], $_POST['id']));
			
			// Get location and repair/purchase info
			$query = $db->query('select repairOrPurchase, locations.name as locationName from FeedbackSurveys as survey, FeedbackLocations as locations where survey.location = locations.id AND survey.id = ?', array($_POST['id']));	
			$survey = $query->FetchRow(); 
			
			// Get settings to grab email notification address
			$query = $db->query('select * from FeedbackSettings');	
			$settings = $query->FetchRow(); 
			if ($survey['repairOrPurchase'] == "Purchase") { 
				$email = $settings['purchaseEmails'];
			} else {
				$email = $settings['repairEmails'];
			} 
	
			// Send email notification
			$mh = Loader::helper('mail');
			$mh->to($email);
			$mh->addParameter('location', $survey['locationName']);
			$mh->addParameter('firstName', $_POST['firstName']);
			$mh->addParameter('lastName', $_POST['lastName']);
			$mh->addParameter('email', $_POST['email']);
			$mh->addParameter('phone', $_POST['phone']);
			$mh->addParameter('comments', $_POST['comments']);
			$mh->from("noreply@brayandscarffreview.com");
			$mh->load('feedback-submission', 'feedbacksurvey');
			$mh->setSubject('Bray & Scarff Feedback Submission');
			@$mh->sendMail();
		}
		
		die();
	}

	public function validateCaptcha() { 
		if (strtoupper($_SESSION['securimage_code_value']) == trim(strtoupper($_GET['ccmCaptchaCode']))) {
			echo 'true';
		} else {
			echo 'false';
		}
		die();
	}
	
}

?>