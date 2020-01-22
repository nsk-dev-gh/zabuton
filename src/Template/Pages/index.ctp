<!DOCTYPE html>
<html>
<head>
	<title>ひとこと大喜利「ザブトン」</title>
	<?= $this->element('include'); ?>
	<meta property="og:title" content="ひとこと大喜利「ザブトン」" />
	<meta property="og:url" content="https://zabuton.co/" />
	<meta property="og:image" content="https://zabuton.co/img/default_ogp.png" />
	<meta property="og:site_name" content="ひとこと大喜利「ザブトン」" />
	<meta name="twitter:card" content="summary_large_image" />
</head>
<body>
	<div class="wrapper">
		<?= $this->element('header'); ?>
		<div class="main_container">
			<div class="border"></div>
			<div class="logo_area">
				<?= $this->Html->image("top_logo.png"); ?>
				<div class="logo_subtitle">
					もっと気軽に、お笑いを。
				</div>
			</div>

			<div class="main_description_area">
				<div class="main_description_base">
					<p><b>ザブトンは会員登録やSNS連携をせずとも、<br>気軽に大喜利を楽しめるサービスです。</b></p>
					<p>様々なお題に面白い回答をして、<br>みんなをクスッと笑わせてみましょう。</p>
					<p>さぁ、あなたも「<b>座布団、一枚！</b>」</p>
					<?= $this->Html->image("top_catch.png"); ?>
				</div>
			</div>

			<div class="sub_description_area">
				<div class="sub_des_title">
					会員登録、ログインは不要！<br>回答はTwitterへ！
				</div>
				<div class="sub_des_text">
					<p>ザブトンでは、もっと気軽に周りの人と大喜利を楽しんでほしいため<br>会員登録なしに回答ができるようになっています。</p>
					<p>回答したURLを投稿すると自動で画像が生成されるようになっていますので、<br>気軽に回答して、気軽にシェアしてください。</p>
					<?= $this->Html->image("top_ogp_sample.png"); ?>
				</div>
			</div>

			<div class="sub_description_area">
				<div class="sub_des_title">
					お題をつくって<br>友達に送ろう！
				</div>
				<div class="sub_des_text">
					<p>お題を登録するのも、<br>ワンステップでログインいらず。</p>
					<p>ちょっと面白い話題を考えたらお題を登録して、友達に送ってみんなで大喜利しあってみよう</p>
					<p>いつもは静かな友達が実は才能あるかも…?</p>
				</div>
			</div>

			<div class="twitter_timeline_area">
				<p>おすすめのおもしろ回答</p>
				<div class="twitter_timeline">
					<a class="twitter-timeline" data-lang="ja" data-theme="light" href="https://twitter.com/zzabuton/likes?ref_src=twsrc%5Etfw">Tweets Liked by @zzabuton</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
				</div>
			</div>

		</div>
		<?= $this->element('footer'); ?>
	</div>
</body>
</html>