<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;
$APPLICATION->SetTitle("Регистрация");
if($USER->isAuthorized()) {
	LocalRedirect("/personal");
}else {?>
<div class="register-form__box">
	<form method="post" class="registration-form" name="registrationform">
	<div class="form-group">
		<label for="" class="bx-soa-custom-label">Ведите email</label>
		<input type="text" id="reg_login_field" class="form__control" name="email">
	</div>
		<div class="form-group">
			<label for="" class="bx-soa-custom-label">Введите пароль</label>
			<input type="password" id="reg_passwd_field" class="form__control" name="password">
		</div>
		<div class="form-group">
			<label for="" class="bx-soa-custom-label">Подтвердите пароль</label>
			<input type="password" id="reg_passwd_confirm_field" class="form__control" name="password_confirm">
		</div>
		<div class="captcha-group">
		<? $CaptchaCode = htmlspecialcharsbx($APPLICATION->CaptchaGetCode()); ?>
			<div class="capcha_img">
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$CaptchaCode?>" width="160" height="40" alt="CAPTCHA" />
			</div>
			<div class="captcha-img-update">
				<div class="capchatext">
					<label for="" class="bx-soa-custom-label">Код с картинки</label>
					<input type="text" class="form__control" name="captcha_word">
					<input type="hidden" name="captcha_sid" class="captcha_sid" value="<?=$CaptchaCode?>">
				</div>
				<div class="capcha_button">
					<button type="button" class="btn capcha-button">Обновить</button>
				</div>	
			</div>
			
		</div>
		<input type="submit" name="register_submit_button" class="registration-btn btn-round"/>
	</form>
	<div class="or-delimeter__box">
		<div class="or-delimeter">
			или
		</div>
	</div>
	<a href="/auth" class="login-page-redir btn-round">Войти</a>
</div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>