<?php
$limit = $PlanetConfig->getMaxDisplay();
$count = 0;

$all_people = &$Planet->getPeople();
usort($all_people, array('PlanetPerson', 'compare'));

header('Content-type: text/html; charset=UTF-8');
?><!DOCTYPE HTML>
<html lang="ja">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="//www.archlinuxjp.org/stylesheets/archweb.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="https://www.archlinuxjp.org/stylesheets/mobile.css" media="only screen and (max-width:790px)" />
	<link rel="icon" type="image/x-icon" href="//www.archlinuxjp.org/images/favicon.ico" />
	<link rel="shortcut icon" type="image/x-icon" href="//www.archlinuxjp.org/images/favicon.ico" />
	<style type="text/css">
		<!--
		img {
			max-width:600px;
		}
		pre {
			white-space:pre-wrap;
			word-wrap:break-word;
			width:600px;
			min-width:95%;
			max-height:700px;
			overflow:auto;
			font-family:monospace;
		}
		#content th, #content td {
			white-space:normal;
		}
		h4 {
			border-bottom:1px dotted #BBB;
		}
		-->
	</style>
	<title><?php echo $PlanetConfig->getName(); ?></title>
        <link rel="alternate" type="application/atom+xml" title="ATOM" href="?type=atom10" />
</head>
<body>
    <script type="text/javascript">
    document.body.className += 'js';
    </script>
	<div id="archnavbar" class="anb-home">
		<div id="archnavbarlogo"><h1><a href="https://www.archlinuxjp.org/" title="メインページに戻る">Arch Linux</a></h1></div>
		<div id="archnavbaricon"><i title="メニューを開く"></i></div>
		<div id="archnavbarmenu">
            <ul id="archnavbarlist">
                <li id="anb-home"><a href="https://www.archlinuxjp.org/" title="Arch ニュース、パッケージ、プロジェクトなど">ホーム</a></li>
                <li id="anb-packages"><a href="https://www.archlinuxjp.org/packages/" title="Arch パッケージデータベース">パッケージ</a></li>
                <li id="anb-forums"><a href="https://bbs.archlinuxjp.org/" title="コミュニティフォーラム">フォーラム</a></li>
                <li id="anb-wiki"><a href="https://wiki.archlinuxjp.org/" title="コミュニティドキュメント">ArchWiki</a></li>
                <li id="anb-bugs"><a href="http://blog.archlinuxjp.org/" title="活動報告">ブログ</a></li>
                <li id="anb-aur"><a href="https://archlinuxjp-slack.herokuapp.com/" title="チャット">Slack</a></li>
                <li id="anb-download"><a href="https://www.archlinuxjp.org/download/" title="Arch Linux を入手">ダウンロード</a></li>
            </ul>
		</div>
	</div>
    <div id="content">
        <div id="archdev-navbar"></div>
		<div id="content-left-wrapper">
		<div id="content-left">
			<div id="planetnews">
				<h2>Planet Arch Linux JP</h2>
            <?php if (0 == count($items)) : ?>
				<h4>No article</h4>
				<div>No news, good news.</div>
            <?php else : ?>
                <?php foreach ($items as $item): ?>
                    <?php 
                    $arParsedUrl = parse_url($item->get_feed()->get_link());
                    $host = preg_replace('/[^a-zA-Z]/i', '-', $arParsedUrl['host']);
                    ?>
				<h4><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h4>
				<p class="date"><?php echo date("F d, Y H:i A", $item->get_date('U')) ?></p>
				<div><?php echo $item->get_content(); ?></div>
				<div style="font-size:x-small;text-align:right;clear:both;">
					<?php echo ($item->get_author()? $item->get_author()->get_name().'@' : ''); ?><?php
                            $feed = $item->get_feed();
                            echo '<a href="'.$feed->getWebsite().'">'.$feed->getName().'</a>';
                            ?>
				</div>
                    <?php if (++$count == $limit) { break; } ?>
                <?php endforeach; ?>
            <?php endif; ?>
			</div>
		</div>
		</div>
		<div id="content-right">
			<div class="box">
				<h4>Planet Arch Linux JP</h4>
				<p>Planet Arch Linux JP は日本の Arch Linux ハッカーによって書かれた記事を収集しています。</p>
			</div>
			<div id="sidebar">
				<h4>寄稿</h4>
				<ul>
            <?php foreach ($all_people as $person) : ?>
					<li><a href="<?php echo htmlspecialchars($person->getFeed(), ENT_QUOTES, 'UTF-8'); ?>"><img src="postload.php?url=<?php echo urlencode(htmlspecialchars($person->getFeed(), ENT_QUOTES, 'UTF-8')); ?>" alt="" height="12" width="12" style="border:none" /></a>&nbsp;<a href="<?php echo $person->getWebsite(); ?>"><?php echo htmlspecialchars($person->getName(), ENT_QUOTES, 'UTF-8'); ?></a></li>
            <?php endforeach; ?>
				</ul>
				<h4>フィード</h4>
				<ul>
					<li><img src="custom/img/feed.png" alt="feed" height="12" width="12" />&nbsp;<a href="?type=atom10">ATOM 1.0</a></li>
					<li><img src="custom/img/feed.png" alt="feed" height="12" width="12" />&nbsp;<a href="?type=rss10">RSS 1.0</a></li>
					<li><img src="custom/img/opml.png" alt="feed" height="12" width="12" />&nbsp;<a href="custom/people.opml">OPML</a></li>
				</ul>
				<h4>Arch Planet Worldwide</h4>
				<p>海外の Arch Linux コミュニティ。</p>
				<ul style="list-style: square !important; margin-left: 1em;">
					 <li><a href="https://planet.archlinux.org/">本家</a></li>
					 <li><a href="http://planeta.archlinux-br.org/">ブラジル</a></li>
					 <li><a href="http://planet.archlinux.cl/">チリ</a></li>
					 <li><a href="http://planet.archlinuxcn.org/">中国</a></li>
					 <li><a href="http://planet.archlinux.fr/">フランス</a></li>
					 <li><a href="http://planet.archlinux.de/">ドイツ</a></li>
					 <li><a href="http://www.archlinux.it/planet/">イタリア</a></li>
					 <li><a href="http://archlinux.org.ru/blogs/">ロシア</a></li>
					 <li><a href="http://planeta.archlinux-es.org/">スペイン</a></li>
				</ul>
				<p>世界中の arch ユーザーの居住地を示した <a href="https://archwomen.org/media/archmap/archmap.kml">google earth map</a> が brain0 によって管理されています。<a href="https://wiki.archlinux.org/index.php/ArchMap/List">あなたの住所も追加しましょう</a>。</p>
				<h4>刊記</h4>
				<p>このページは <a href="http://moonmoon.org/">moonmoon</a> によって作成されています。</p>
				<p>Planet Arch Linux JP のフィードにブログを追加して欲しい場合や、質問があるときなどは <a href="mailto:shohei@kusakata.com" title="連絡先">shohei@kusakata.com</a> に連絡して下さい。</p>
			</div>
		</div>
		<div id="footer"><br>
			<p>Copyright &copy; 2014-2015 <a href="//www.archlinuxjp.org/">Arch Linux JP Project</a>.</p>
			<p>このページに記載されたブログ記事の著作権はそれぞれの記事の著者に帰属します。</p>
		</div>
	</div>
<script type="text/javascript" src="https://www.archlinuxjp.org/javascripts/archweb.js"></script>
</body>
</html>