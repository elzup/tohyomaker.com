
</div>
<div id="footer">
	<div class="container">
		<div class="row">
			<!--TODO: create footer-->
			<div class="col-sm-4">
				<strong>メイン</strong>
				<ul>
					<li><a <?= attr_href() ?>>トップ</a></li>
				</ul>
			</div>
			<div class="col-sm-4">
				<strong>カタログ</strong>
				<ul>
					<li><a <?= attr_href(HREF_TYPE_NEW) ?>>新着投票</a></li>
					<li><a <?= attr_href(HREF_TYPE_HOT) ?>>人気投票</a></li>
				</ul>
			</div>
		</div>
	</div>

</div>
<!-- jQuery include -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- zClip jQuery plugins -->

<!--<script src="<?= base_url("lib/jquery.zclip.js") ?>"></script>-->
<!--<script src="<?= base_url("lib/ZeroClipboard.minjs") ?>"></script>-->

<!-- LESS include -->
<script type="text/javascript" src="<?= base_url('lib/less-1.3.3.min.js') ?>"></script>
<!-- LESS Twitter bootstrap include -->
<script src="<?= base_url('lib/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<!-- Incliude Twitter share button widgets -->
<script src="http://platform.twitter.com/widgets.js" type="text/javascript" charset="utf-8"></script>

<!-- js of act on all page-->
<script src="<?= base_url(PATH_JS.'/helper.js') ?>" type="text/javascript"></script>
<script src="<?= base_url(PATH_JS.'/alert.js' ) ?>" type="text/javascript"></script>
<?php
if (!empty($jss))
{
	foreach ($jss as $js)
	{
		?>
		<script src="<?= base_url("js/{$js}.js") ?>" type="text/javascript"></script>
		<?php
	}
}
?>
</body>
</html>