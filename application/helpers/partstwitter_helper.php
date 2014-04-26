<?php
if (!function_exists('sharebtn_twitter'))
{

	function sharebtn_twitter($text, $uri, $name_text = 'ツイートする', $is_count = TRUE, $is_large = FALSE)
	{
		?>
		<a href="http://twitter.com/share" class="twitter-share-button"
			 data-url="<?= fix_url($uri) ?>"
			 data-text="<?= $text ?>"
			 <?= $is_large ? 'data-size="large"' : '' ?>
			 data-count=<?= $is_count ? "horizontal" : "none" ?>
			 data-lang="ja"><?= $name_text ?></a>
		<?php
	}

}
