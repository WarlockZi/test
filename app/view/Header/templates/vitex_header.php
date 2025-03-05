<header class="burger">
    <? include_once ROOT. '/app/view/share/adminPanel/adminPanel.php'; ?>
	<div class="info" itemscope itemtype="https://schema.org/Organization">

        <div class="column none">
            <h3>Компания</h3>
            <p itemprop="name">Витекс</p>
        </div>
        <?php include 'logo.php'; ?>

        <?php include 'phone.php'; ?>
        <?php include 'location.php'; ?>
        <?php include 'call_me.php'; ?>
        <?php include 'user_menu.php'; ?>

	</div>

	<?=	$blueRibbon; ?>
</header>
