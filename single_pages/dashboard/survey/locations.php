<!-- Locations --> 
<?php 
	$form = Loader::helper('form'); 
	$this->addHeaderItem(Loader::helper('html')->css('/css/dashboard.css'));
	$this->addHeaderItem(Loader::helper('html')->javascript('/js/jquery-validation-engine/js/jquery.validationEngine.js'));
	$this->addHeaderItem(Loader::helper('html')->javascript('/js/jquery-validation-engine/js/jquery.validationEngine-en.js'));
	$this->addHeaderItem(Loader::helper('html')->css('/js/jquery-validation-engine/css/validationEngine.jquery.css'));
	$al = Loader::helper('concrete/asset_library');
	Loader::element('editor_config');


	//var_dump($locations);

?> 

<div class="ccm-dashboard-inner mgh-dashboard ccm-ui">

	<h1>Survey Locations Manager</h1> 
	
	<?php 
		if ($_GET['errormsg']) { 
			echo '<div class="errormsg">' . $_GET['errormsg'] . '</div>';	
		}
		if ($_GET['msg']) { 
			echo '<div class="msg">' . $_GET['msg'] . '</div>';	
		}
	?>

	<p><a href="#" class="btn primary" id="add-location">Add Location</a></p>
	
	<form action="<?php echo $this->action('add');?>" method="post" class="location-form" id="add-form">
		<?php
			
			echo $form->label('name', 'Name: ');
			echo $form->text("name", "", array('class'=>'validate[required]', 'maxlength'=>'255'));

			echo $form->label('yelpUrl', 'Yelp URL:');
			echo $form->text("yelpUrl", "", array('class'=>'validate[required,custom[url]]', 'maxlength'=>'255'));

			echo $form->label('googleUrl', 'Google URL:');
			echo $form->text("googleUrl", "", array('class'=>'validate[required,custom[url]]', 'maxlength'=>'255'));

			echo $form->label('facebookUrl', 'Facebook URL:');
			echo $form->text("facebookUrl", "", array('class'=>'validate[required,custom[url]]', 'maxlength'=>'255'));
			
			echo $form->submit("submit", "Add"); 

		?>	
	</form>

	<?php 
		if ($locations) { 
	?>

		<table width="650" align="center" class="clear">
			<tr>
				<th width="100">Name</th>
				<th width="50">Yelp</th>
				<th width="50">Google</th>
				<th width="50">Facebook</th>
				<th>Edit</th>
			</tr>
			<?php foreach($locations as $location) {  ?>
			<tr>
				<td>
					<?php echo $location['name'];?>
				</td>
				<td>
					<a href="<?php echo $location['yelpUrl'];?>" target="_blank">Yelp</a>
				</td>
				<td>
					<a href="<?php echo $location['googleUrl'];?>" target="_blank">Google</a>
				</td>
				<td>
					<a href="<?php echo $location['facebookUrl'];?>" target="_blank">Facebook</a>
				</td>
				<td>
					<p class="edit">
						<a href="#" class="edit">Edit</a> | 
						<a href="/dashboard/survey/locations/delete/<?php echo $location['id'];?>">Delete</a>
					</p>
					<form action="<?php echo $this->action('update');?>" method="post" class="locations-form" id="update-form<?php echo $location['id'];?>">
					<?php
						
						echo $form->hidden("id", $location['id']);

						echo $form->label('name', 'Name: ');
						echo $form->text("name", $location['name'], array('class'=>'validate[required]', 'maxlength'=>'255'));

						echo $form->label('yelpUrl', 'Yelp URL:');
						echo $form->text("yelpUrl", $location['yelpUrl'], array('class'=>'validate[required,custom[url]]', 'maxlength'=>'255'));

						echo $form->label('googleUrl', 'Google URL:');
						echo $form->text("googleUrl", $location['googleUrl'], array('class'=>'validate[required,custom[url]]', 'maxlength'=>'255'));

						echo $form->label('facebookUrl', 'Facebook URL:');
						echo $form->text('facebookUrl', $location['facebookUrl'], array('class'=>'validate[required,custom[url]]', 'maxlength'=>'255'));
						
						echo $form->submit("submit", "Update");

					?>	
				</form>
				</td>
			</tr>
			<?php } ?>
		</table>
	<?php 
		}
	?>

</div>

<script type="text/javascript">
$(function() {
   $(".location-form").validationEngine();
   $('#add-location').click(function() {
   		$('#add-form').show(); 
   		return false;
   });
   $('a.edit').click(function() {
   		$(this).parent().siblings('form').slideToggle();
   		return false;
   });
}); 
</script>

