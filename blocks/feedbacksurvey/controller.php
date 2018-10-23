<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

class FeedbacksurveyBlockController extends BlockController {

	protected $btDescription = "Displays a survey.";
	protected $btName = "Feedback Survey";
	protected $btTable = 'btMGH_survey_block';
	protected $btInterfaceWidth = "500";
	protected $btInterfaceHeight = "450";
	
	public function view() { 
		$db = Loader::db();

		$query = $db->query('select * from FeedbackSettings');	
		$settings = $query->FetchRow(); 
		$this->set('settings',$settings);

		$query = $db->query('select * from FeedbackLocations ORDER BY name');	
		$locations = $query->GetAll(); 
		$this->set('locations',$locations);

		$uh = Loader::helper('concrete/urls');
		$bt = BlockType::getByHandle('feedbacksurvey');
		$local = $uh->getBlockTypeAssetsURL($bt);
		$this->set('blockPath', $local); 
	}

}
