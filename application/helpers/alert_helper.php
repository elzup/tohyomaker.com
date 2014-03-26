<?php
if (!function_exists('set_alert'))
{

	function set_alert($type, $text = '')
	{
		return array('alert' => $type . ':' . $text);
	}

}

if (!function_exists('get_alert'))
{

	function get_alert($data)
	{
		if (empty($data))
		{
			return;
		}
		$pattern = '#^(.+):(.*)#';
		$matches = array();
		if (preg_match($pattern, $data, $matches))
		{
			?> 
			<div id="alert-div">
				<div class="col-sm-row">
					<div class="col-sm-offset-1 col-sm-10">
						<?php
						$type = $matches[1];
						$text = $matches[2];
						alert_box($type, $text);
						?> 
					</div>
				</div>
			</div>
			<?php
		}
	}

}

if (!function_exists('alert_box'))
{

	function alert_box($type, $text = '')
	{
		$lib = array(
				'',
				'ログインしました。',
				'ログアウトしました。',
				'投票が完了しました。',
				'',
				'なにかのエラーです。',
		);
		if (empty($lib[$type]))
		{
			return;
		}
		$type_text = $lib[$type];
		$alert_type = 'alert-success';
		if ($type == ALERT_TYPE_ERROR)
		{
			$alert_type = 'alert-warning';
			// TODO: write error log / $text in error code
		}
		?>
		<div class="alert alert-dismissable <?= $alert_type ?>">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<p><?= $type_text ?></p>
			<span class="help-block"><?= $text ?></span>
		</div>
		<?php
	}

}