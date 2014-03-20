<?php
/* @var $survyes_new SurveyObj[] */
/* @var $survyes_hot SurveyObj[] */
?>

<div class="container">
	<div class="row">
		<div class="col-lg-offset-2 col-sm-8">
			<div class="row">

				<div id="title-div" class="col-sm-12 col-wide">
					<h1 id="title-str" class="top-logo">診断メーカー</h1>
				</div>
				<div class="col-sm-12 well">
					投票メーカーは手軽に投票を作成,参加,シェアすることが出来るサービスです。<br />
					<div class="align-center">
						<a href="<?= base_url('make') ?>" class="btn btn-success align-center">
							<i class="glyphicon glyphicon-edit"></i>
							投票を作成する
						</a>
					</div>
				</div>

				<div class="col-sm-12 col-wide">
					<?php surveysblock_type($surveys_hot, SURVEY_BLOCKTYPE_HOT); ?>
				</div>

				<div class="col-sm-12 col-wide">
					<?php surveysblock_type($surveys_new, SURVEY_BLOCKTYPE_NEW); ?>
				</div>
			</div>
		</div>
	</div>
</div>