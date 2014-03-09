
				</div>
			<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script type="text/javascript" src="<?=base_url('lib/less-1.3.3.min.js')?>"></script>
      <script src="<?= base_url('lib/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
			<!-- Incliude Twitter share button widgets-->
			<script src="http://platform.twitter.com/widgets.js" type="text/javascript" charset="utf-8"></script>
			<?php if (!empty($jss)) {foreach ($jss as $js) {?>
			<script src="<?= base_url("js/{$js}.js")?>" type="text/javascript"></script>
			<?php }}?>
  </body>
</html>