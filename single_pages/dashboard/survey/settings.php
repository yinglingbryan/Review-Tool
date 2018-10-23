<?php 
	$form = Loader::helper('form'); 
	$this->addHeaderItem(Loader::helper('html')->css('/css/dashboard.css'));
	$this->addHeaderItem(Loader::helper('html')->javascript('/js/jquery-validation-engine/js/jquery.validationEngine.js'));
	$this->addHeaderItem(Loader::helper('html')->javascript('/js/jquery-validation-engine/js/jquery.validationEngine-en.js'));
	$this->addHeaderItem(Loader::helper('html')->css('/js/jquery-validation-engine/css/validationEngine.jquery.css'));
	$al = Loader::helper('concrete/asset_library');
	Loader::element('editor_config'); 
?> 

<div class="ccm-dashboard-inner mgh-dashboard ccm-ui">

	<h1>Survey Settings</h1> 
	
	<?php 
		if ($_GET['errormsg']) { 
			echo '<div class="errormsg">' . $_GET['errormsg'] . '</div>';	
		}
		if ($_GET['msg']) { 
			echo '<div class="msg">' . $_GET['msg'] . '</div>';	
		}
	?>
	
	<form action="<?php echo $this->action('save');?>" method="post" id="settings-form">
		<?php
			
			echo $form->label('purchaseEmails', 'Purchase/Delivery Email Notification Address(es): ');
			echo $form->text("purchaseEmails", $settings['purchaseEmails'], array('class'=>'validate[required, custom[multiEmail]]', 'maxlength'=>'255'));
			
			echo $form->label('repairEmails', 'Repair Email Notification Address(es): ');
			echo $form->text("repairEmails", $settings['repairEmails'], array('class'=>'validate[required, custom[multiEmail]]', 'maxlength'=>'255'));
			
			echo '<fieldset class="clear">'; 
			echo '<legend>Initial Question Screen</legend>';

				echo '<div class="clear"></div>';

				echo $form->label('initialQuestion', 'Question Copy:');
				echo $form->textarea("initialQuestion", $settings['initialQuestion'], array('class'=>'validate[required]', 'maxlength'=>'255'));

				echo $form->label('initialQuestionOption1', 'Option 1:');
				echo $form->text("initialQuestionOption1", $settings['initialQuestionOption1'], array('class'=>'validate[required]', 'maxlength'=>'25'));
				
				echo $form->label('initialQuestionOption2', 'Option 2:');
				echo $form->text("initialQuestionOption2", $settings['initialQuestionOption2'], array('class'=>'validate[required]', 'maxlength'=>'25'));
			
			echo '</fieldset>';

			echo '<fieldset class="clear">'; 
			echo '<legend>Locations Screen</legend>';
				echo $form->label('locations', 'Copy: ');
				echo $form->textarea("locationsCopy", $settings['locationsCopy'], array('class'=>'validate[required]', 'maxlength'=>'255'));

				echo '<p>Locations can be updated in the <a href="/dashboard/survey/locations" target="_blank">locations manager</a>.</p>';
			echo '</fieldset>';
			
			echo '<fieldset class="clear">'; 
			echo '<legend>Purchase Experience Screen</legend>';

				echo $form->label('purchaseExperienceQuestion', 'Question Copy:');
				echo $form->textarea("purchaseExperienceQuestion", $settings['purchaseExperienceQuestion'], array('class'=>'validate[required]', 'maxlength'=>'255'));

				echo $form->label('purchaseExperienceOption1', 'Option 1:');
				echo $form->text("purchaseExperienceOption1", $settings['purchaseExperienceOption1'], array('class'=>'validate[required]', 'maxlength'=>'25'));
				
				echo $form->label('purchaseExperienceOption2', 'Option 2:');
				echo $form->text("purchaseExperienceOption2", $settings['purchaseExperienceOption2'], array('class'=>'validate[required]', 'maxlength'=>'25'));
			
			echo '</fieldset>';
			
			echo '<fieldset class="clear">'; 
			echo '<legend>Delivery/Installation Experience Screen</legend>';

				echo $form->label('deliveryInstallExperienceQuestion', 'Question Copy:');
				echo $form->textarea("deliveryInstallExperienceQuestion", $settings['deliveryInstallExperienceQuestion'], array('class'=>'validate[required]', 'maxlength'=>'255'));

				echo $form->label('deliveryInstallExperienceOption1', 'Option 1:');
				echo $form->text("deliveryInstallExperienceOption1", $settings['deliveryInstallExperienceOption1'], array('class'=>'validate[required]', 'maxlength'=>'25'));
				
				echo $form->label('deliveryInstallExperienceOption2', 'Option 2:');
				echo $form->text("deliveryInstallExperienceOption2", $settings['deliveryInstallExperienceOption2'], array('class'=>'validate[required]', 'maxlength'=>'25'));
			
			echo '</fieldset>';
			
			echo '<fieldset class="clear">'; 
			echo '<legend>Repair Experience Screen</legend>';

				echo $form->label('repairExperienceQuestion', 'Question 1 Copy:');
				echo $form->textarea("repairExperienceQuestion1", $settings['repairExperienceQuestion1'], array('class'=>'validate[required]', 'maxlength'=>'255'));

				echo $form->label('repairExperienceQuestion', 'Question 2 Copy:');
				echo $form->textarea("repairExperienceQuestion2", $settings['repairExperienceQuestion2'], array('class'=>'validate[required]', 'maxlength'=>'255'));

				echo $form->label('repairExperienceQuestion', 'Question 3 Copy:');
				echo $form->textarea("repairExperienceQuestion3", $settings['repairExperienceQuestion3'], array('class'=>'validate[required]', 'maxlength'=>'255'));

				echo $form->label('repairExperienceQuestion', 'Question 4 Copy:');
				echo $form->textarea("repairExperienceQuestion4", $settings['repairExperienceQuestion4'], array('class'=>'validate[required]', 'maxlength'=>'255'));

				echo $form->label('repairExperienceQuestion', 'Question 5 Copy:');
				echo $form->textarea("repairExperienceQuestion5", $settings['repairExperienceQuestion5'], array('class'=>'validate[required]', 'maxlength'=>'255'));


			echo '</fieldset>';

			echo '<fieldset class="clear">'; 
			echo '<legend>Feedback Form Screen</legend>';

				echo $form->label('feedbackFormCopy', 'Copy:');
				echo $form->textarea("feedbackFormCopy", $settings['feedbackFormCopy'], array('class'=>'validate[required]', 'maxlength'=>'255'));

				echo $form->label('feedbackFormButtonCopy', 'Button Copy:');
				echo $form->text("feedbackFormButtonCopy", $settings['feedbackFormButtonCopy'], array('class'=>'validate[required]', 'maxlength'=>'50'));
				
				echo $form->label('feedbackFormThankYouCopy', 'Thank You Copy:');
				echo $form->textarea("feedbackFormThankYouCopy", $settings['feedbackFormThankYouCopy'], array('class'=>'validate[required]', 'maxlength'=>'255'));
			
			echo '</fieldset>';


			echo '<fieldset class="clear">'; 
			echo '<legend>Share Screen</legend>';

				echo $form->label('shareCopy', 'Copy:');
				echo $form->textarea("shareCopy", $settings['shareCopy'], array('class'=>'validate[required]', 'maxlength'=>'500'));
				
				echo $form->label('feedbackFormThankYouCopy2', 'Closing Copy:');
				echo $form->textarea("feedbackFormThankYouCopy2", $settings['feedbackFormThankYouCopy2'], array('class'=>'validate[required]', 'maxlength'=>'500'));
			
			echo '</fieldset>';
			
			echo $form->submit("submit", "submit"); 

		?>	
	</form>

</div>

<script type="text/javascript">
$(function() {
   $("#settings-form").validationEngine();
}); 
</script>

