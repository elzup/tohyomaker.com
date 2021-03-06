<?php
/* @var $survyes_new Surveyobj[] */
/* @var $survyes_hot Surveyobj[] */
?>

<div class="container">
	<div class="row">
		<div class="col-lg-offset-2 col-sm-8">
			<div class="row">
				<div id="title-div" class="col-sm-12">
					<h1 id="title-str" class="top-logo">
						<a href="/">
							<img class="hidden-xs" <?= attr_src(PATH_IMG_LOGO) ?> alt="投票メーカー" />
							<img class="visible-xs" <?= attr_src(PATH_IMG_LOGO_M) ?> alt="投票メーカー" />
						</a>
					</h1>
				</div>
				<div class="col-sm-12 well align-center">
					<?= SITE_DESCRIPTION ?><br />
					<div class="">
						<a <?= attr_href(PATH_MAKE) ?> class="btn btn-success btn-lg">
							<i class="glyphicon glyphicon-edit"></i>
							投票を作成する
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>