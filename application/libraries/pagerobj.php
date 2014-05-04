<?php

/*
 * (c) copyright Hiroya Fujii
 * http://blog.3ot.net/design/php/20090915185455.html
 * license http://opensource.org/licenses/mit-license.php MIT License
 *
 */

class Pagerobj
{

// 番号リンクの数
	public $linksNum = 7;
// 1ページに表示するデータ数
	public $parOnePage = 20;
// 「いちばん最初リンク」と「いちばん最後リンク」のところの数。
	public $topEnd = 2;
// 「いちばん最初リンク」と「いちばん最後リンク」の区切り文字。
	public $between = '...';
// prev, nextの文字列
	public $prevString = '<';
	public $nextString = '>';
// prev, クエリ文字列
	public $query = 'page';
// ulタグにつくクラス名
	public $class = 'pagination pagination-lg';
	public $url = "";
	public $html = "";

	function __construct($options = false)
	{
		if (is_array($options) && count($options) > 0)
		{
			array_walk($options, array($this, 'options'));
		}
	}

	function doIt($total, $current)
	{
		$current += 1;
//    $current = $this->current;
		$pages = ceil($total / $this->parOnePage);
		$prev = $current > 1 ? $current - 1 : -1;
		$next = $current < $pages ? $current + 1 : -1;
		$left = $current - ceil($this->linksNum / 2);
		$right = $current + ceil($this->linksNum / 2);
		if ($left < 1)
		{
			while ($right <= $this->linksNum)
			{
				$right++;
			}
			$left = 1;
		}
		if ($right > $pages)
		{
			$left = $left - $right + $pages;
			$left = $left < 1 ? 1 : $left;
			$right = $pages;
		}
		for ($i = $left; $i <= $right; $i++)
		{
			$temp[] = $i;
		}
		if ($temp[0] > 1)
		{
			for ($i = 1; $i < $temp[0] && $i <= $this->topEnd; $i++)
			{
				$top[] = $i;
			}
		}
		$top = isset($top) ? $top : array();
		if (count($top) > 0 && $top[count($top) - 1] != $temp[0] - 1)
		{
			array_push($top, $this->between);
		}
		$last = $temp[count($temp) - 1];
		if ($last < $pages - $this->topEnd)
		{
			array_push($temp, $this->between);
		}
		for ($i = 0; $i < $this->topEnd; $i++, $pages--)
		{
			if ($pages > $last)
			{
				$bottom[] = $pages;
			}
		}
		$bottom = isset($bottom) ? array_reverse($bottom) : array();
		$temp = array_merge($top, $temp, $bottom);
		$pager[] = '<li' . (($prev === -1) ? ' class="disabled" ' : '') . '><a ' . attr_href($this->url . '/' . ($prev - 1)) . '>' . $this->prevString . '</a></li>';
		for ($i = 0; $i < count($temp); $i++)
		{
			if ($temp[$i] == $this->between)
			{
				$li = '<li class="disabled"><a href="#">' . $this->between . '</a></li>';
			} elseif ($current == $temp[$i])
			{
				$li = '<li class="active"><a href="#">' . $temp[$i] . '</a></li>';
			} else
			{
				$li = '<li><a ' . attr_href($this->url . '/' . ($temp[$i] - 1)) . '>' . $temp[$i] . '</a></li>';
			}
			$pager[] = $li;
		}
		$pager[] = '<li' . (($next === - 1) ? ' class="disabled"' : '') . '><a ' . attr_href($this->url . '/' . ($next - 1)) . '>' . $this->nextString . '</a></li>';
//      $pager[] = '<li><a href="'.$_SERVER['SCRIPT_NAME'].$this->pagerQuery($next, $query).'">'.$this->nextString.'</a></li>';
		$this->html = '<ul class="' . $this->class . '">' . implode($pager) . '</ul>';
	}

	function __toString()
	{
		return $this->html;
	}

	function options($v, $k)
	{
		$this->$k = $v;
	}

}
