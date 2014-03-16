
				</div>
				<div id="footer">
					<!--TODO: create footer-->

				</div>
			<!-- jQuery include -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- zClip jQuery plugins -->
			
			<!--<script src="<?=base_url("lib/jquery.zclip.js")?>"></script>-->
			<!--<script src="<?=base_url("lib/ZeroClipboard.minjs")?>"></script>-->

      <!-- LESS include -->
      <script type="text/javascript" src="<?=base_url('lib/less-1.3.3.min.js')?>"></script>
      <!-- LESS Twitter bootstrap include -->
      <script src="<?= base_url('lib/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
			<!-- Incliude Twitter share button widgets -->
			<script src="http://platform.twitter.com/widgets.js" type="text/javascript" charset="utf-8"></script>

			<!-- js of act on all page-->
			<script src="<?= base_url("js/helper.js")?>" type="text/javascript"></script>
			<script src="<?= base_url("js/alert.js")?>" type="text/javascript"></script>
			<?php if (!empty($jss)) {foreach ($jss as $js) {?>
			<script src="<?= base_url("js/{$js}.js")?>" type="text/javascript"></script>
			<?php }}?>
  </body>
</html>