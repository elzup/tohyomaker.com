<?php
/* @var $user Userobj */
$user;
if ($user == null)
{
	$user = false;
}
?>
<nav class="navbar navbar-default navbar-fixed-top" id="navbar">
	<div class="navbar-header">
		<button class="navbar-toggle" data-toggle="collapse" data-target=".target">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		<div class="navbar-brand"><a <?= attr_href('') ?>>brand</a></div>
		<!--<a href="" class="navbar-brand">投票メーカー</a>-->
	</div>
	<div class="collapse navbar-collapse target">
		<ul class="nav navbar-nav navbar-right">
			<li class="active">
				<a <?= attr_href(HREF_TYPE_MAKE)?>><?= tag_icon(ICON_MAKE)?>作成</a>
			</li>
			<li>
				<a <?= attr_href(HREF_TYPE_NEW)?>><?= tag_icon(ICON_NEW)?>新着</a>
			</li>
			<li>
				<a <?= attr_href(HREF_TYPE_HOT)?>><?= tag_icon(ICON_HOT)?>人気</a>
			</li>
			<li>
				<a onClick="$('#navbar').hide()">hide</a>
			</li>
			<li class="dropdown">
				<?php if ($user)
				{
					?>
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="login-info"><?= $user->screen_name ?> <span class="caret"></span></a>
					<ul class="dropdown-menu" aria-labelledby="login-info">
						<li><a <?= attr_href(HREF_TYPE_MYPAGE)?>><?= tag_icon(ICON_HOME)?>マイページ</a></li>
						<!--li class="divider"></li-->
						<li><a <?= attr_href(HREF_TYPE_LOGOUT)?>><?= tag_icon(ICON_LOGOUT)?>ログアウト</a></li>
					</ul>
				<?php } else
				{
					?>
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="login-info"><?= tag_icon(ICON_LOGIN)?>ログイン<span class="caret"></span></a>
					<ul class="dropdown-menu" aria-labelledby="login-info">
						<li>
							<a <?= attr_href(HREF_TYPE_LOGIN) ?>><?= tag_icon(ICON_TWITTER)?>Twitter</a>
						</li>
					</ul>
				</li>
<?php } ?>

		</ul>
	</div>
</nav>
