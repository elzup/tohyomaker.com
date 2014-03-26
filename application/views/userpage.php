<?php
/* @var $surveys_maked Surveyobj[] */
?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8">
			<h2>作成した投票</h2>
			<?php
			if (!empty($surveys_maked))
			{
				foreach ($surveys_maked as $survey)
				{
					surveypane($survey);
				}
			} else
			{
				?>
				<p>作成した投票はありません</p>
				<?php
			}
			?>
		</div>
	</div>
</div>