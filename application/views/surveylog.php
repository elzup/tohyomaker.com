<?php
/* @var $survey Surveyobj */
/* @var $user Userobj */
?>
<?php if (!empty($survey->results))
{
	?>

	<div class="container" id="survey-log-div">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<h2>投票結果ログ</h2>
				<?php
				// TODO: do folding logpane
				$no_result = TRUE;
				foreach ($survey->results as $result)
				{
					if ($result->type < RESULT_TYPE_BOOK_SHIFT)
					{
						$no_result = FALSE;
						logpane($result, $survey);
					}
				}
				if ($no_result)
				{
					?>
					<p>記録された集計結果はまだありません</p>
					<?php
				}
				?>
			</div>
		</div>
	</div>


	<?php
}