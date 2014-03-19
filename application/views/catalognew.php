<?php
/* @var $surveys SurveyObj[] */
/* @var $user UserObj */
?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" class="catalog-new">
				<span class="help-block">最近作成された投票を新着順に表示.</span>
			<?php
			if (isset($surveys))
			{
				foreach ($surveys as $survey)
				{
					surveypane($survey);
				}
			} else
			{
				// warning
				?>
				新着の投票はありません
				<?php
			}
			?>
		</div>
	</div>
</div>