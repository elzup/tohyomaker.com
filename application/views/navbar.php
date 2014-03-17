<?php
/* @var $user UserObj */
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

		<div class="navbar-brand"><a href="<?= base_url()?>">brand</a></div>
		<!--<a href="" class="navbar-brand">投票メーカー</a>-->
	</div>
	<div class="collapse navbar-collapse target">
		<ul class="nav navbar-nav">
			<li class="active">
				<a href="<?=  base_url('make')?>"><i class="glyphicon glyphicon-pencil"></i>作成</a>
			</li>
			<li>
				<a href="<?=  base_url('make')?>"><i class="glyphicon glyphicon-pencil"></i>オススメ</a>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a onClick="$('#navbar').hide()">hide</a>
			</li>
			<li class="dropdown">
				<?php if ($user)
				{
					?>
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="login-info"><?= $user->screen_name ?> <span class="caret"></span></a>
					<ul class="dropdown-menu" aria-labelledby="login-info">
						<li><a href="<?=  base_url('mypage')?>">マイページ</a></li>
						<!--li class="divider"></li-->
						<li><a href="<?= base_url('auth/logout') ?>">ログアウト</a></li>
					</ul>
				<?php } else
				{
					?>
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="login-info">ログイン<span class="caret"></span></a>
					<ul class="dropdown-menu" aria-labelledby="login-info">
						<li><a href="<?= base_url('auth') ?>">Twitter</a></li>
					</ul>
				</li>
<?php } ?>

		</ul>
	</div>
</nav>
