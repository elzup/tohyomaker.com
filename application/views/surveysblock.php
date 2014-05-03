<?php
/* @var $survyes Surveyobj[] */
/* @var $type int */
/* @var $is_more_btn boolean */
if (!isset($is_more_btn)) {
	$is_more_btn = TRUE;
}
?>

<div class="container">
	<div class="row">
		<div class="col-lg-offset-2 col-sm-8">
			<div class="row">
				<div class="col-sm-12">
					<?php surveysblock_type($surveys, $type, $is_more_btn); ?>
				</div>
			</div>
		</div>
	</div>
</div>
