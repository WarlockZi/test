<div class="adm-content">
	<? if ($user): ?>

	  <div class="user-item">

		  <div class="tabs">
			  <input id="tab1" type="radio" name="tabs" checked>
			  <label for="tab1" title="Основное">Основное</label>
			  <input id="tab2" type="radio" name="tabs">
			  <label for="tab2" title="Права">Права</label>

			  <section id="content-tab1">
						 <?= $item; ?>
			  </section>

			  <section id="content-tab2">



			  </section>

			  <div class="custom-catalog-item__buttons">
				  <div class="del button"><?include TRASH?></div>
				  <div class="save button"><?include SAVE?></div>
				  <a href="/adminsc/user/list" class="to-list">К списку</a>
			  </div>

		  </div>

	  </div>

	<? else: ?>
	  <H3>Пользователь не найден</H3>
	  <a href="/adminsc/user/list" class="to-list">К списку</a>
	<? endif; ?>

</div>


