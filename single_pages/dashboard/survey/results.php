<!-- results --> 
<?php 
	$this->addHeaderItem(Loader::helper('html')->css('/css/dashboard.css'));
?> 

<div class="ccm-dashboard-inner mgh-dashboard ccm-ui">

	<h1>Survey Results</h1> 

	<p style="margin-top: 5px;"><a class="btn" href="/dashboard/survey/results/export/">Export (Excel)</a></p>

	<?php if ($surveys) { ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>IP</th>
					<th>Location</th>
					<th>Purchase or Repair?</th>
					<th>Satisfied with Purchase?</th>
					<th>Satisfied with Delivery / Installation?</th>
					<th>Satisfied with Repair? (old question)</th>
					<th>Survey Results</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($surveys as $survey) { ?>
					<tr>
						<td><?php echo $survey['id'];?></td>
						<td><?php echo $survey['ip'];?></td>
						<td><?php echo $survey['repairOrPurchase'];?></td>
						<td><?php echo $survey['locationName'];?></td>
						<td><p><?php if ($survey['repairOrPurchase'] == "Purchase") { echo ($survey['purchaseExperienceSatisfied'] == 1 ? "Yes" : "No"); } ;?></p></td>
						<td><p><?php if ($survey['repairOrPurchase'] == "Purchase") { echo ($survey['deliveryExperienceSatisfied'] == 1 ? "Yes" : "No"); } ;?></p></td>
						<td><p><?php if ($survey['repairOrPurchase'] == "Repair" && !$survey['repairExperienceValue1']) { echo ($survey['repairExperienceSatisfied'] == 1 ? "Yes" : "No"); } ;?></p></td>
						<td>
							<?php if ($survey['repairExperienceValue1']) { ?>
								<strong>Timeliness:</strong> <?=$survey['repairExperienceValue1'];?><br/>
								<strong>Overall performance:</strong> <?=$survey['repairExperienceValue2'];?><br/>
								<strong>Clean &amp; tidy?:</strong> <?=$survey['repairExperienceValue3'];?><br/>
								<strong>Overall interaction:</strong> <?=$survey['repairExperienceValue4'];?><br/>
								<strong>Recommend B&S?:</strong> <?=$survey['repairExperienceValue5'];?><br/>
							<?php } ?>
							<strong>Name:</strong> <?php echo $survey['firstName'] . " " . $survey['lastName'];?><br/>
							<strong>Phone:</strong> <?php echo $survey['phone'];?><br/>
							<strong>Email:</strong> <?php echo $survey['email'];?><br/>
							<strong>Comment:</strong> <?php echo $survey['comments'];?><br/>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
	
	<?php if ($pageCount > 1) { ?>
		<div class="pagination ccm-pagination">
			<ul>
				<?php for ($i=1; $i<=$pageCount; $i++ ) { 
					if ($i == $curPage) {
						echo '<li class="numbers currentPage active disabled"><a href="#" class="">' . $i . '</a></li>';
					} else {
						echo '<li class="numbers"><a href="/dashboard/survey/results/' . $i . '">' . $i  . '</a></li>';
					}
				} ?>
			</ul>
		</div>
	<?php } ?>


</div>
