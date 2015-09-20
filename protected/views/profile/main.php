	<div class="tabs-bar">
		<div class="tab">Профиль</div>
		<div class="tab-active">Настройка</div>		
	</div>
	<div class="page-layout">
		<table class="settings">
			<tr>
				<td>
					<div class="avatar-settings">
						<img src="<?php //echo Yii::app()->request->baseUrl; ?>/images/octopus_blue.png" alt="">
						<div class="upload-avatar">
							<input type="file" id="uplAvatar">
						</div>
						<button type="button" class="btn btn-default btn-sm">Загрузить</button>
					</div>
					<div class="form-container">
						<form action="" method="POST" role="form">
							<legend>Изменить проходное слово</legend>

							<div class="form-group input-group-sm">
								<label for="">Старый пароль</label>
								<input type="text" class="form-control" id="" placeholder="Input field">
							</div>
							<div class="form-group input-group-sm">
								<label for="">Новый пароль</label>
								<input type="text" class="form-control" id="" placeholder="Input field">
							</div>
							<div class="form-group input-group-sm">
								<label for="">Повторите новый пароль</label>
								<input type="text" class="form-control" id="" placeholder="Input field">
							</div>	


							<button type="submit" class="btn btn-primary btn-sm" id="savePassBtn">Сохранить</button>
						</form>
					</div>
				</td>
				<td>
					<div class="form-container">
						<form action="" method="POST" role="form">
							<legend>Ваша электронная почта</legend>
							
							<div class="form-group input-group-sm">
								<label for="">Почта</label>
								<input type="text" class="form-control" id="" placeholder="Input field">
							</div>
							<button type="submit" class="btn btn-primary btn-sm" id="saveMailBtn">Сохранить</button>
						</form>
					</div>
					<div class="form-container">
						<form action="" method="POST" role="form">
							<legend>Аккаунт социальной сети</legend>
							
							<div class="form-group input-group-sm">
								<label for="">Ссыль</label>
								<input type="text" class="form-control" id="" placeholder="Input field">
							</div>

							<button type="submit" class="btn btn-primary btn-sm" id="saveSocBtn">Submit</button>
						</form>
					</div>
				</td>
			</tr>
		</table>			
	</div>