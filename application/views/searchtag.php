<?php
/* @var $surveys Surveyobj[] */
/* @var $word string */
?>

<div class="container">
	<div class="row">

		<div class="col-sm-offset-2 col-sm-8 well">
			<?php searchbox_tag() ?>
		</div>

		<?php
		if (isset($word))
		{
			?>
		<div class="col-sm-offset-2 col-sm-8 well">
			<span class="searchword"><?= $word ?></span>の検索結果一覧です.
		</div>
		<?php } ?>

		<?php
		if (!empty($surveys))
		{
			?>
			<div class="col-sm-offset-2 col-sm-8" id="search-tag-div">
				<?php
				foreach ($surveys as $survey)
				{
					surveypane($survey);
				}
				?>
			</div>
		<?php } ?>
	</div>
</div>