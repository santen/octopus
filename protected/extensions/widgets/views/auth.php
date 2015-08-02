<div id="authWindow">
	<div class="auth-header">
		<div class="auth-block-1"></div>
		<div class="auth-block-2"></div>
		<div class="auth-block-3"></div>
	</div>
	<div class="auth-body">
		<div class="tabs-bar">
			<div class="tab-active" id="signinTab">Вход</div>
			<div class="tab" id="signupTab">Регистрация</div>
		</div>
		<form action="" method="POST" role="form" id="signInForm">
			<div class="form-group">
				<label for="">Ваша почта:</label>
				<input type="text" class="form-control" id="email">
			</div>
			<div class="form-group">
				<label for="">Пароль:</label>
				<input type="password" class="form-control" id="pass">
			</div>
			<button type="submit" class="btn btn-primary">Войти</button>
			<button type="submit" class="btn btn-warning">Отмена</button>
		</form>

		<form action="" method="POST" role="form" id="signUpForm">
			<div class="form-group">
				<label for="">Ваша почта:</label>
				<input type="text" class="form-control" id="email">
			</div>
			<div class="form-group">
				<label for="">Пароль:</label>
				<input type="password" class="form-control" id="pass">
			</div>
			<div class="form-group">
				<label for="">Повторите пароль:</label>
				<input type="password" class="form-control" id="retype">
			</div>
			<button type="submit" class="btn btn-primary">Зарегистрироваться</button>
			<button type="submit" class="btn btn-warning">Отмена</button>
		</form>
	</div>
</div>