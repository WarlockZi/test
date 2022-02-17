<div class="adm-content">

	<table class="custom-list users">

		<thead>
		<tr>
			<th class="id">ID</th>
			<th class="fio">фио<input type="text"></th>
			<th class="email">email<input type="text"></th>
			<th class="confirmed">co</th>
			<th class="edit"><? include EDIT; ?></th>
			<th class="del"><? include TRASH; ?></th>
		</tr>
<!--		<tr>-->
<!--			<th></th>-->
<!--			<th class="fio"></th>-->
<!--			<th class="email"><input type="text"></th>-->
<!--			<th class="confirmed">co</th>-->
<!--			<th class="edit">--><?// include EDIT; ?><!--</th>-->
<!--			<th class="del">--><?// include TRASH; ?><!--</th>-->
<!--		</tr>-->
		</thead>

		<tbody>
		<? foreach ($users as $use): ?>
			<tr>
				<td class="id"><?= $use['id'] ?></td>
				<td>
					<a class="fio" href="/adminsc/crm/user?id=<?= $use['id']; ?>"></a>
					<?= $use['surName']; ?> <?= $use['name']; ?> <?= $use['middleName']; ?>
				</td>
				<td class="email"><?= $use['email']; ?></td>
				<td class="confirmed"><?= $use['confirm']; ?></td>
				<td class="edit"><? include EDIT; ?></td>
				<td class="del"><? include TRASH; ?></td>
			</tr>
		<? endforeach; ?>

		<!--		<div class="user new">-->
		<!--			<div class="id"></div>-->
		<!--			<div class="fio" contenteditable></div>-->
		<!--			<div class="email" contenteditable></div>-->
		<!--			<div class="confirmed" contenteditable></div>-->
		<!--			<div class="save">--><? // include EDIT; ?><!--</div>-->
		<!--			<div class="del">--><? // include TRASH; ?><!--</div>-->
		<!--		</div>-->

		</tbody>

	</table>


	<!--	<div class="user-table">-->
	<!--		<div class="user head">-->
	<!--			<div class="id">ID</div>-->
	<!--			<div class="fio">фио</div>-->
	<!--			<div class="email">email</div>-->
	<!--			<div class="confirmed">co</div>-->
	<!--			<div>--><? // include EDIT; ?><!--</div>-->
	<!--			<div>--><? // include TRASH; ?><!--</div>-->
	<!--		</div>-->
	<!---->
	<!--		--><? // foreach ($users as $use): ?>
	<!--			<div class="user">-->
	<!--				<div class="id">--><? //= $use['id'] ?><!--</div>-->
	<!--				<a class="fio"-->
	<!--				   href="/adminsc/crm/user?id=--><? //= $use['id']; ?><!--">--><? //= $use['surName']; ?><!-- -->
	<? //= $use['name']; ?><!-- --><? //= $use['middleName']; ?><!--</a>-->
	<!--				<div class="email" contenteditable>--><? //= $use['email']; ?><!--</div>-->
	<!--				<div class="confirmed" contenteditable>--><? //= $use['confirm']; ?><!--</div>-->
	<!--				<div class="edit">--><? // include EDIT; ?><!--</div>-->
	<!--				<div class="del">--><? // include TRASH; ?><!--</div>-->
	<!--			</div>-->
	<!--		--><? // endforeach; ?>
	<!---->
	<!--		<div class="user new">-->
	<!--			<div class="id"></div>-->
	<!--			<div class="fio" contenteditable></div>-->
	<!--			<div class="email" contenteditable></div>-->
	<!--			<div class="confirmed" contenteditable></div>-->
	<!--			<div class="save">--><? // include EDIT; ?><!--</div>-->
	<!--			<div class="del">--><? // include TRASH; ?><!--</div>-->
	<!--		</div>-->
	<!--	</div>-->


</div>
