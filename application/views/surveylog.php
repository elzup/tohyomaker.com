<?php
/* @var $survey Surveyobj */
/* @var $user Userobj */
?>


<div class="container" id="survey-log-div">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8">
			<?php
			// TODO: do folding logpane
			foreach ($survey->results as $result)
			{
				logpane($result, $survey);
			}
			?>
		</div>
	</div>
</div>

