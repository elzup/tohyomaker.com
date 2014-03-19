<?php
/* @var $survyes_new SurveyObj[] */
/* @var $survyes_hot SurveyObj[] */
?>




<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<?php surveysblock_type($surveys_hot, SURVEY_BLOCKTYPE_HOT);?>
		</div>

		<div class="col-sm-8 col-sm-offset-2">
			<?php surveysblock_type($surveys_new, SURVEY_BLOCKTYPE_NEW);?>
		</div>
	</div>
</div>