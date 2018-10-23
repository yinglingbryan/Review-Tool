<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

class FeedbacksurveyPackage extends Package {

	protected $pkgHandle = 'feedbacksurvey';
	protected $appVersionRequired = '5.6.1';
	protected $pkgVersion = '1.1';
	
	public function install($path) {
		$db = Loader::db();
		
		// Create data tables
		$add_qry = "CREATE TABLE IF NOT EXISTS `FeedbackSettings` (
		  `id` int(11) unsigned NOT NULL auto_increment,
		  `emailNotificationAddress` varchar(255) default NULL,
		  `locationsCopy` varchar(255) default NULL,
		  `initialQuestion` varchar(255) default NULL,
		  `initialQuestionSatisfiedOption` varchar(25) default NULL,
		  `initialQuestionUnsatisfiedOption` varchar(25) default NULL,
		  `feedbackFormCopy` varchar(255) default NULL,
		  `feedbackFormButtonCopy` varchar(50) default NULL,
		  `feedbackFormThankYouCopy` varchar(255) default NULL,
		  `feedbackFormThankYouCopy2` varchar(255) default NULL,
		  `shareCopy` varchar(500) default NULL, 
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;"; 
		$db->execute($add_qry); 

		$add_qry = "CREATE TABLE IF NOT EXISTS `FeedbackSurveys` (
		  `id` int(11) unsigned NOT NULL auto_increment,
		  `ip` varchar(30) default NULL,
		  `createDate` date default NULL,
		  `location` varchar(25) default NULL,
		  `isSatisfied` tinyint(4) default NULL,
		  `firstName` int(25) default NULL,
		  `lastName` varchar(25) default NULL,
		  `email` varchar(255) default NULL,
		  `phone` varchar(20) default NULL,
		  `comments` varchar(1500) default NULL,
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		$db->execute($add_qry); 

		$add_qry = "CREATE TABLE IF NOT EXISTS `FeedbackLocations` (
		  `id` int(11) unsigned NOT NULL auto_increment,
		  `name` varchar(255) default NULL,
		  `yelpUrl` varchar(255) default NULL,
		  `googleUrl` varchar(255) default NULL,
		  `facebookUrl` varchar(255) default NULL,
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		$db->execute($add_qry); 
				
		$pkg = parent::install();
     
		// install block 
		BlockType::installBlockTypeFromPackage('feedbacksurvey', $pkg); 
		
		// Create dashboard pages
		Loader::model('single_page');
		$dashboardSettingsPage = SinglePage::add('/dashboard/survey/settings', $pkg);
		$dashboardSettingsPage->update(array('cName' => 'Survey Settings', 'cDescription' => 'Manage the survey settings. '));
		$dashboardLocationsPage = SinglePage::add('/dashboard/survey/locations', $pkg);
		$dashboardLocationsPage->update(array('cName' => 'Manage Locations', 'cDescription' => 'Manage the locations. '));
		$dashboardResultsPage = SinglePage::add('/dashboard/survey/results', $pkg);
		$dashboardResultsPage->update(array('cName' => 'Survey Results'));
		$ahjaxPage = SinglePage::add('/survey', $pkg);

	}
	
	public function getPackageDescription() {
		return t("Manage feedback survey.");
	}

	public function getPackageName() {
		return t("MGH Survey Tool");
	}

}
