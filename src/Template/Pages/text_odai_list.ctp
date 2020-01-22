<!DOCTYPE html>
<html>
<head>
	<title>お題一覧｜ひとこと大喜利「ザブトン」</title>
	<?= $this->element('include'); ?>
	<meta property="og:title" content="お題一覧｜ひとこと大喜利「ザブトン」" />
	<meta property="og:url" content="https://zabuton.co/text_odai_list" />
	<meta property="og:image" content="https://zabuton.co/img/default_ogp.png" />
	<meta property="og:site_name" content="ひとこと大喜利「ザブトン」" />
	<meta name="twitter:card" content="summary_large_image" />
</head>
<body>
	<div class="wrapper">
		<?= $this->element('header'); ?>
		<div class="main_container">
			<div class="odai_container">
				<ul class="text_odai_list">
					<?php foreach ($odaiList as $key => $value): ?>
						<a href="/input?i=<?=$value['id'];?>">
							<li>
								<?=$value['text'];?>
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
			var pageType = 0;
		</script>
		<?= $this->Html->script('pagination'); ?>
	</div>
</body>
</html>