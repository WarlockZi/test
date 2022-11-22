<section class="planning-create">

	Ежедневные

	<div class="planning-table">
		<div class="num head">№</div>
		<div class="time-plan head">План</div>
		<div class="time-fact head">Факт</div>
		<div class="time-fact head">Выполнено</div>
		<div class="time-fact head">Принято</div>
		<div class="function head">Задача</div>

		<div class="num">1</div>
		<div class="time-plan">
			<div class="hour">
				<input maxlength="2">
				<? include ROOT . '/app/view/components/up-down.php' ?>
			</div>
			<div class="minute">
				<input maxlength="2">
				<? include ROOT . '/app/view/components/up-down.php' ?>
			</div>
		</div>

		<div class="time-fact">
			<div class="hour">
				<input maxlength="2">
				<? include ROOT . '/app/view/components/up-down.php' ?>
			</div>
			<div class="minute">
				<input maxlength="2">
				<? include ROOT . '/app/view/components/up-down.php' ?>
			</div>
		</div>

		<input type="checkbox" class="done">
		<input type="checkbox" class="accepted">
		<div class="function">Отгрузка</div>
	</div>


</section>