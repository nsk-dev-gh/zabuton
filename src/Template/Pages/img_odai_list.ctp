<!DOCTYPE html>
<html>
<head>
	<title>画像お題一覧｜ひとこと大喜利「ザブトン」</title>
	<?= $this->element('include'); ?>
	<meta property="og:title" content="画像お題一覧｜ひとこと大喜利「ザブトン」" />
	<meta property="og:url" content="https://zabuton.co/img_odai_list" />
	<meta property="og:image" content="https://zabuton.co/img/default_ogp.png" />
	<meta property="og:site_name" content="ひとこと大喜利「ザブトン」" />
	<meta name="twitter:card" content="summary_large_image" />
</head>
<body>
	<div class="wrapper">
		<?= $this->element('header'); ?>
		<div class="main_container">
			<div class="odai_container">
				<ul class="img_odai_list">
					<?php foreach ($odaiList as $key => $value): ?>
						<a href="/input?i=<?=$value['id'];?>">
							<li>
								<?= $this->Html->image('odai_img/'.$value['img_url']); ?>
							</li>
						</a>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="pagination">
				<?php if($possibleFlg == 1): ?>
					<div id="loading" style="display:none; text-align: center; padding-top: 10px;">
						<?= $this->Html->image('loading.gif', ["style" => "width:80px;"]); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?= $this->element('footer'); ?>
		<script type="text/javascript">
			var possibleFlg = <?= $possibleFlg; ?>;
			var pageType = 1;
		</script>
		<?= $this->Html->script('pagination'); ?>
	</div>
</body>
</html>