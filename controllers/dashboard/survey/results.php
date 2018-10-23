<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardSurveyResultsController extends Controller {

	public function view($page = 1) {
   		$db = Loader::db();
   		define("PERPAGE", 100);

   		$results = $db->GetArray('select s.*, l.name as locationName from FeedbackSurveys s INNER JOIN FeedbackLocations l on l.id = s.location ORDER BY s.id Desc LIMIT ?, ? ', array((($page-1)*PERPAGE), PERPAGE));
   		$this->set('surveys', $results);

   		$pageCountQry = $db->GetRow('select count(*) as count from FeedbackSurveys s INNER JOIN FeedbackLocations l on l.id = s.location');
   		$this->set('pageCount',ceil($pageCountQry['count']/PERPAGE));
   		$this->set('curPage',$page);
	}

	public function export() { 
		Loader::library("PHPExcel", 'feedbacksurvey');
		Loader::library("PHPExcel/IOFactory", 'feedbacksurvey');
		$error = Loader::helper('validation/error');
		$db = Loader::db();
		$san = Loader::helper('text');

		// Get results 
		$results = $db->GetArray('
			select s.id, s.ip, s.createDate, s.repairOrPurchase, 
			l.name as locationName, 
			s.purchaseExperienceSatisfied, s.deliveryExperienceSatisfied, s.repairExperienceSatisfied, 
			s.repairExperienceValue1, s.repairExperienceValue2, s.repairExperienceValue3, s.repairExperienceValue4, repairExperienceValue5, 
			s.firstName, s.lastName, s.email, s.phone, s.comments 
			from FeedbackSurveys s 
			INNER JOIN FeedbackLocations l on l.id = s.location 
			ORDER BY s.id Desc');
		foreach($results as $i=>$result) {
			if ($results[$i]['repairOrPurchase'] == "Purchase") {
				$results[$i]['purchaseExperienceSatisfied'] = ($result['purchaseExperienceSatisfied'] == 1 ? "Yes" : "No");
				$results[$i]['deliveryExperienceSatisfied'] = ($result['deliveryExperienceSatisfied'] == 1 ? "Yes" : "No");
			} else {
				$results[$i]['purchaseExperienceSatisfied'] = '';
				$results[$i]['deliveryExperienceSatisfied'] = '';
			}
			if ($results[$i]['repairOrPurchase'] == "Repair" && !$results[$i]['repairExperienceValue1']) {
				$results[$i]['repairExperienceSatisfied'] = ($result['repairExperienceSatisfied'] == 1 ? "Yes" : "No");
			} else {
				$results[$i]['repairExperienceSatisfied'] = '';
			}
		}

		// Create spreadsheet
		$phpExcelObj = new PHPExcel();
		$headings = array("ID", "IP", "createDate", "Repair or Purchase?", "Location", "Satisfied with Purchase?", "Satisfied with Delivery?", "Satisfied with Repair? (old field)", "Timeliness", "Overall Performance", "Clean/Tidy?", "Overall Interaction", "Would recommend B&S?", "First Name", "Last Name", "Email", "Phone", "Comments");
		if(count($results) > 0) {
			$phpExcelObj->setActiveSheetIndex(0);

			$i = 0;
			foreach($headings as $head) {
				$phpExcelObj->getActiveSheet()->setCellValueByColumnAndRow($i, 1, $head);
				$i++;
			}

			$phpExcelObj->getActiveSheet()->fromArray($results, null, 'A2');
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename=feedback_results_'. date("Y-m-d", time()).'.xls');
		header('Cache-Control: max-age=0');

		$excelWriter = PHPExcel_IOFactory::createWriter($phpExcelObj, "Excel5");
		$excelWriter->save("php://output");

   }
	
}

?>