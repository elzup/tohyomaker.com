
<div class="container" id="survey-log-div">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8">
			<?php
			foreach ($survey->results as $result)
			{
				logpane($result);
			}
			?>
		</div>
	</div>
</div>
