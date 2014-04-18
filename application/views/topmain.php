<?php
/* @var $survyes_new Surveyobj[] */
/* @var $survyes_hot Surveyobj[] */
?>

<div class="container">
	<div class="row">
		<div class="col-lg-offset-2 col-sm-8">
			<div class="row">

				<div id="title-div" class="col-sm-12">
					<h1 id="title-str" class="top-logo">診断メーカー</h1>
				</div>
				<div class="col-sm-12 well">
					<?= SITE_DESCRIPTION?><br />
					<div class="align-center">
						<a <?= attr_href(PATH_MAKE) ?> class="btn btn-success align-center">
							<i class="glyphicon glyphicon-edit"></i>
							投票を作成する
						</a>
					</div>
				</div>

				<div class="col-sm-12">
					<?php surveysblock_type($surveys_hot, SURVEY_BLOCKTYPE_HOT); ?>
				</div>

				<div class="col-sm-12">
					<?php surveysblock_type($surveys_new, SURVEY_BLOCKTYPE_NEW); ?>
				</div>
			</div>
		</div>
	</div>
</div>