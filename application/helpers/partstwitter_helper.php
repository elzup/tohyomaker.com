<?php

if (!function_exists('sharebtn_twitter'))
{

	function sharebtn_twitter($text, $uri, $name_text ='ツイートする', $is_count = TRUE)
	{
		?>
		<a href="http://twitter.com/share" class="twitter-share-button"
			 data-url="<?= fix_url($uri) ?>"
			 data-text="<?= $text ?>"
			 data-count=<?= $is_count ? "horizontal" : "none"?>
			 data-lang="ja"><?=$name_text?></a>
			 <?php
		 }

	 }
