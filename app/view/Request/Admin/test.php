<header class="site-header sticky-top py-1 bg-light">
	<nav class="container d-flex flex-column flex-md-row justify-content-end">
		<div class="btn-group">
			<a class="py-2 d-md-inline-block btn btn-outline-primary" href="#" rel="nofollow">Войти</a>
			<a class="py-2 d-md-inline-block btn btn-outline-primary" href="#" rel="nofollow">Выйти</a>
		</div>
	</nav>
</header>


<main>
	<div class="container my-4">
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<div class="d-flex flex-column">
						<div class="form-group">
							<input type="text" id="title" class="form-control" maxlength="50" autocomplete="off" placeholder="Title" required>
						</div>
						<div class="form-check form-switch my-1">
							<input class="form-check-input" type="checkbox" id="important">
							<label class="form-check-label" for="important">Важная</label>
						</div>
						<button type="submit" class="btn btn-success btn-block my-2 float-right">Save</button>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="row">
				<div class="col-sm-3 text-left">
					<p class="font-weight-bold">Title</p>
				</div>
				<div class="col-sm-6 text-left">
					<p class="font-weight-bold">Description</p>
				</div>
				<div class="col-sm-3 text-right">
					<p class="font-weight-bold">Delete</p>
				</div>
			</div>
			<hr>
			<div id="tasks"></div>
		</div>

		</div>

		<div class="container d-flex my-5 justify-content-center">
			<div class="btn-toolbar d-flex " role="toolbar" aria-label="Панель инструментов с группами кнопок">
				<div class="btn-group me-2" role="group" aria-label="Вторая группа">
					<button type="button" class="btn btn-secondary">1</button>
					<button type="button" class="btn btn-secondary">2</button>
					<button type="button" class="btn btn-secondary">3</button>
				</div>
			</div>
		</div>
	</div>
</main>


