<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="itemresult-div">
			<ul>
				<?php
				// TODO: item sort after view 
				foreach ($survey->items as $i => $item)
				{
					?>
					<li>
						<div class="row">
							<div class="col-sm-6">
								<h3>
									<?= $item ?>
								</h3>
							</div>
							<div class="col-sm-6">
								<h3 class="num">
									<?= $survey->result[$i] ?>票
								</h3>
							</div>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>
