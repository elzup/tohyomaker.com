
<div class="container" id="survey-head-div">
	<div class="well">
		<div class="col-sm-offset-2 colsm-8">
			<?php
			foreach ($survey->results as $result)
			{
				logpane($result);
			}
			?>

		</div>
	</div>
</div>

