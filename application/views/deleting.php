<?php
/* @var $survey Surveyobj */
/* @var $token string */
?>
<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="survey-head-div">
			<div class="well center">
				<h4>※消去した投票は復元することが出来ません</h4>
				投票「<?= $survey->title ?>」を消去しますか？
				<a class="btn btn-lg btn-warning" <?= attr_href(implode('/', array(PATH_DELETE, $survey->id, $token))) ?>>消去する</a>
			</div>
		</div>
	</div>
</div>