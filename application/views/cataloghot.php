<?php
/* @var $surveys Surveyobj[] */
/* @var $user Userobj */
?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" class="catalog-new">
				<span class="help-block">最近勢いのある投票</span>
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
				人気の投票はありません
				<?php
			}
			?>
		</div>
	</div>
</div>