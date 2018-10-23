<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$form = Loader::helper('form'); 
$captcha = Loader::helper('validation/captcha');
?>

<div class="step" id="purchase-or-repair">
	<p><?php echo $settings['initialQuestion'];?></p>
	<div class="buttons">
		<form action="/survey/initial/" method="POST" id="purchase-or-repair-form">
			<input type="hidden" name="ip" id="ip" value="<?php echo $_SERVER['REMOTE_ADDR'];?>"/>
			<button value="<?=$settings['initialQuestionOption1'];?>" class="button"><?=$settings['initialQuestionOption1'];?></button>
			<button value="<?=$settings['initialQuestionOption2'];?>" class="button"><?=$settings['initialQuestionOption2'];?></button>
		</form>
	</div>
</div>

<div class="step" id="locations">
	<p><?php echo $settings['locationsCopy'];?></p>
	<div class="buttons">
		<form action="/survey/location/" method="POST" id="locations-form">
			<select class="custom-select" name="location">
				<option value="">Select a Location</option>
				<?php foreach($locations as $location) { 
					$name = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $location['name']) ;?>
					<option value="<?=$location['id'];?>"><?=$location['name'];?></option>
				<?php } ?>
			</select>
		</form>
	</div>
</div>

<div class="step" id="purchase-experience">
	<p><?php echo $settings['purchaseExperienceQuestion'];?></p>
	<div class="buttons">
		<form action="/survey/satisfaction/" method="POST" id="purchase-experience-form">
			<button value="1" class="button"><?=$settings['purchaseExperienceOption1'];?></button>
			<button value="0" class="button"><?=$settings['purchaseExperienceOption2'];?></button>
		</form>
	</div>
</div>

<div class="step" id="delivery-installation-experience">
	<p><?php echo $settings['deliveryInstallExperienceQuestion'];?></p>
	<div class="buttons">
		<form action="/survey/satisfaction/" method="POST" id="deliver-installation-experience-form">
			<button value="1" class="button"><?=$settings['deliveryInstallExperienceOption1'];?></button>
			<button value="0" class="button"><?=$settings['deliveryInstallExperienceOption2'];?></button>
		</form>
	</div>
</div>

<div class="step" id="repair-experience">
	<form action="/survey/satisfaction/" method="POST" id="repair-experience-form">
		<?php for ($i=1; $i<=5; $i++) { ?>
		<p><?php echo $settings['repairExperienceQuestion' . $i];?></p>
			<div class="options">
				<?php for ($j=1; $j<=5; $j++) { ?>
					<!--<button value="<?=$j;?>" class="button small"><?=$j;?></button>-->
					<label>
						<input class="validate[required]" type="radio" value="<?=$j;?>" id="" name="repairExperienceValue<?=$i;?>">
						<?=$j;?>
						<?php
							if ($j==1) { echo '<br/><span>(worst)</span>'; }
							if ($j==5) { echo '<br/><span>(best)</span>'; }
						?>
					</label>
				<?php } ?>
			</div>
		<?php } ?>
		<div class="buttons">
			<input type="submit" value="Next" class="button"/>
		</div>
	</form>
</div>

<div class="step" id="share-screen">
	<?php echo $settings['shareCopy'];?>
	<div class="buttons">
		<?php
			echo '<a href="#" class="button google" target="_blank">Write a <br/>Review on <img src="' . $blockPath . '/images/google-plus.png" alt="Google Plus" width="67" /></a>';
			echo '<a href="#" class="button facebook" target="_blank">Write a <br/>Review on  <img src="' . $blockPath . '/images/facebook.png" alt="Facebook" width="67" /></a>';
			echo '<a href="https://www.houzz.com/writeReview2/cmd=r/n=mmillard58" class="button houzz" target="_blank">Write a <br/>Review on <img src="' . $blockPath . '/images/houzz.png" alt="Houzz" width="67" /></a>';
			echo '<a href="#" class="button yelp" target="_blank">Write a <br/>Review on  <img src="' . $blockPath . '/images/yelp.png" alt="Yelp" width="127" height="61"/></a>';
		?>
	</div>

	<script type="text/javascript">		

		// ADDED BY BRYAN Y.

		// SCRIPT IS TRIGGERED WHEN THE SELECT BOX CHANGE EVENT FIRES
		// 	-	CHECKS THE CURRENTLY SELECTED VALUE, AND USES CSS CLASSES TO SHOW THE APPROPRIATE BUTTONS DEPENDING ON THE LOCATION SELECTED
		// 	-	THE CSS FILE HAS BEEN TWEAKED SO THAT BUTTONS INITIALLY START OUT HIDDEN, AND BECOME VISIBLE ONLY WHEN THE CORRESPONDING CLASS IS APPLIED

		$(".custom-select[name='location']").on("change",function() {

				// console.log($(this).val());
				// laurel store id == 16

				

				// if this is the laurel store
				if ($(this).val() == 16) { 
					$("#share-screen").addClass("show-yelp"); // show yelp
					$("#share-screen").removeClass("show-facebook"); // hide fb
					$("#share-screen").removeClass("show-google"); // hide google
					$("#share-screen").removeClass("show-houzz"); // hide houzz
				} else { // if not
					$("#share-screen").removeClass("show-yelp"); // hide yelp
					$("#share-screen").addClass("show-facebook"); // show fb
					$("#share-screen").addClass("show-google"); // show google
					$("#share-screen").addClass("show-houzz"); // show houzz
				}

			});


	</script>
	
	<?php /*
	<div class="closing">
		<p><?php echo $settings['feedbackFormThankYouCopy2']; ?></p>
	</div>
	*/ ?>
	
	<div class="clear"></div>
</div>

<div class="step" id="feedback-screen">
	<p><?php echo $settings['feedbackFormCopy'];?></p>
	
	<form id="feedback-form" action="/survey/feedback/" method="POST">
		<?php
			echo '<label>First Name*';
			echo $form->text("firstName", "", array('class'=>'validate[required]', 'maxlength'=>'50'));
			echo '</label>';

			echo '<label>Last Name*';
			echo $form->text("lastName", "", array('class'=>'validate[required]', 'maxlength'=>'50'));
			echo '</label>';

			echo '<label>Email*';
			echo $form->text("email", "", array('class'=>'validate[required, custom[email]]', 'maxlength'=>'255'));
			echo '</label>';

			echo '<label>Phone Number';
			echo $form->text("phone", "", array('maxlength'=>'20'));
			echo '</label>';

			echo '<label class="comments">Comments:';
			echo $form->textarea("comments", "", array('maxlength'=>'1500'));
			echo '</label>';
						
			// echo $form->hidden("formValid", "true");
		?>
		
		<script src='https://www.google.com/recaptcha/api.js'></script>
		
		<script type="text/javascript">
			var validCaptcha = 0;
			function checkRecaptcha(){ validCaptcha = 1; }
		</script>
		
		<div class="recaptcha-group">
			<div class="g-recaptcha" data-sitekey="6LcULhsTAAAAAMMdTLiqLepF4ZS-Qq119GDB-Bbf" data-callback="checkRecaptcha"></div>
		</div>
	
		<input class="button btn ccm-input-submit" id="submit" name="submit" onclick="ga(['send', 'event', 'FeedbackForm', 'click', 'Submit'])" value="<?=$settings['feedbackFormButtonCopy'];?>" type="submit">
	</form>
</div>

<div class="step" id="thank-you-screen">
	<div><p><?php echo $settings['feedbackFormThankYouCopy']; ?></p></div>
</div>
