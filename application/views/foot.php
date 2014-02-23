
			<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script type="text/javascript" src="<?=site_url()?>/lib/less-1.3.3.min.js"></script>
      <script src="<?= site_url()?>/lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
			<?php if (!empty($jss)) {foreach ($jss as $js) {?>
			<script src="<?= site_url()?>/js/{$js}.js" type="text/javascript"></script>
			<?php }}?>
  </body>
</html>