<?php
if (!isset($offset))
{
	$offset = 2;
}
$col = 12 - $offset * 2;
?>
<div class="container">
	<div class="row">
		<div id="title-div" class="col-lg-offset-<?=$offset?> col-sm-<?=$col?>">
			<h1 id="title-str" class="page-header"><?=$title?></h1>
		</div>
	</div>
</div>