<?php defined('_NO') or die("Access denied!");
function message_succes($lang,$message)
{
	echo $message;
	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";
	
	if($lang == 'rus')
	{
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{	
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
?>
</div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <td align="left" valign="middle"><?php echo $footercoopyrights; ?></td>
    <td align="right"><?php echo $footermenu_user; ?></td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
exit();
}



function footer_login_exit($lang,$message)
{
	echo $message;
	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";

	if($lang == 'rus')
	{
		$login_form_session_exp = "Ваш аккаунт был неактивен в течении 20 минут. Войдите в систему заново для продолжения работы!";
		$login_form_username = "Введите ваш е-маил";
		$login_form_passwd = "Введите ваш пароль";
		$login_form_reg = "Создать аккаунт";
		$login_form_forg_pass = "Восстановить пароль";
		$login_form_button = "Войти";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{	//perevesti na lat
		$login_form_session_exp = "Jūsu konts bija neaktīvs 20 minūtes. Lūdzu ienāciet sistēmā no jauna, lai turpinātu darbu!";
		$login_form_username = "Ievadiet savu e-pastu";
		$login_form_passwd = "Ievadiet savu paroli";
		$login_form_reg = "Izveidot kontu";
		$login_form_forg_pass = "Atjaunināt paroli";
		$login_form_button = "Ienākt";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}


?>
<br /><hr />
<table width="400px" align="center" border="0" cellpadding="0" cellspacing="0">
<form action="login.php?lang=<?php echo $lang; ?>" method="post">
<tr>
<td><p><?php echo $login_form_username; ?>: </p></td>
<td><input type="text" name="login" size="20" maxlength="50"/></td>
</tr>
<tr>
<td><p><?php echo $login_form_passwd; ?>: </p></td>
<td><input type="password" name="passwd" maxlength="20" size="20" /></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo $login_form_button; ?>" /></td>
</tr>
</form>
</table>
<p><a href="users/reg_user.php?lang=<?php echo $lang; ?>"><?php echo $login_form_reg; ?></a></p>
<p><a href="users/forgot_pass.php?lang=<?php echo $lang; ?>"><?php echo $login_form_forg_pass; ?></a></p>
    </div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <td align="left" valign="middle"><?php echo $footercoopyrights; ?></td>
    <td align="right"><?php echo $footermenu_user; ?></td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
exit();
}



function reg_user_exit($lang,$message,$nick,$login)
{
	echo $message;
	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";
	
	if($lang == 'rus')
	{
		$reg_form_nick = "Введите ник";
		$reg_form_mail = "Введите е-маил";
		$reg_form_passwd = "Введите пароль";
		$reg_form_passwd2 = "Введите подтверждение пароля";
		$reg_form_code = "Введите код картинки";
		$reg_form_button = "Зарегистрироваться";
		
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{	//perevesti na lat
		$reg_form_nick = "Ievadiet lietotāja vārdu";
		$reg_form_mail = "Ievadiet e-pastu";
		$reg_form_passwd = "Ievadiet paroli";
		$reg_form_passwd2 = "Paroles apstiprinājums";
		$reg_form_code = "Ievadiet kodu no attēla";
		$reg_form_button = "Piereģistrēties";
		
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
?>
<br /><hr />
<table align="center" border="0" width="500px" cellpadding="0px">
<form action="reg_user.php?lang=<?php echo $lang; ?>" method="post">
<tr>
<td colspan="3"><input type="hidden" name="hidden" size="6" maxlength="6" /></td>
<tr>
<td><p><?php echo $reg_form_nick; ?>: </p></td>
<td colspan="2"><input type="text" name="nick" size="20" maxlength="20" value="<?php echo $nick; ?>" /></td>
</tr>
<tr>
<td><p><?php echo $reg_form_mail; ?>: </p></td>
<td colspan="2"><input type="text" name="login" size="20" maxlength="50" value="<?php echo $login; ?>" /></td>
</tr>
<tr>
<td><p><?php echo $reg_form_passwd; ?>: </p></td>
<td colspan="2"><input type="password" name="passwd" maxlength="20" size="20" /></td>
</tr>
<tr>
<td><p><?php echo $reg_form_passwd2; ?>: </p></td>
<td colspan="2"><input type="password" name="passwd2" maxlength="20" size="20" /></td>
</tr>
<tr>
<td><p><?php echo $reg_form_code; ?>: </p></td>
<td><input type="text" name="code" size="4" maxlength="4" /></td>
<td align="left"><img src="../codegen/code.php" /></td>
</tr>
<tr>
<td colspan="3" align="center"><input name="submit" type="submit" value="<?php echo $reg_form_button; ?>" /></td>
</tr>
</form>
</table>    
    </div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <td align="left" valign="middle"><?php echo $footercoopyrights; ?></td>
    <td align="right"><?php echo $footermenu_user; ?></td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
exit();
}




function forgot_pass_exit($lang,$message,$login)
{
	echo $message;
	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";
	
	if($lang == 'rus')
	{
		$forgot_pass_mail = "Введите е-маил";
		$forgot_pass_button = "Восстановить";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{	
		$forgot_pass_mail = "Ievadiet e-pastu";
		$forgot_pass_button = "Atjaunināt";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
?>
<br /><hr />
<table border="0" align="center" width="400px">
<form action="forgot_pass.php?lang=<?php echo $lang; ?>" method="post">
<tr>
<td><p><?php echo $forgot_pass_mail; ?>: </p></td>
<td><input type="text" name="login" size="20" maxlength="20" value="<?php echo $login; ?>"></td>
</tr>
<tr>
<td align="center" colspan="2"><input name="submit" type="submit" value="<?php echo $forgot_pass_button; ?>"></td>
</tr>
</form>
</table>    
    </div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("../block/footer_user.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
exit();
}



function profile_footer($lang,$message)
{
	echo $message;
	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";

	if($lang == 'rus')
	{
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{	
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
?>
 </div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("../block/footer_user.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
exit();
}


function change_user_nick_exit($lang,$message)
{
	echo $message;
	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";

	if($lang == 'rus')
	{
		$change_user_nick_tlt = "Изменение данных профиля";
		$change_user_nick = "Введите новый ник";
		$profile_change_button = "Изменить";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{	
		$change_user_nick_tlt = "Mainīt profila datus";
		$change_user_nick = "Ievadiet jaunu lietotāja vārdu";
		$profile_change_button = "Nomainīt";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
?>
<br /><hr />
	<table width="400px" align="center" border="0" cellpadding="0" cellspacing="0">
	<form action="change_user_info.php?lang=<?php echo $lang; ?>" method="post">
	<tr>
	<td align="center" colspan="2"><h3><?php echo $change_user_nick_tlt; ?></h3></td>
	</tr>
	<tr><td colspan="2"><input type="hidden" name="hidden" maxlength="6" size="6" /></td>
	</tr>
	<tr>
	<td><?php echo "<p>".$change_user_nick." :</p>"; ?> </td>
	<td><input type="text" name="new_nick" size="20" maxlength="20" /></td>
	</tr>
	<tr>
	<td align="center" colspan="2"><input name="submit" type="submit" value="<?php echo $profile_change_button; ?>" /></td>
	</tr>
	</form>
	</table>
    </div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("../block/footer_user.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
exit();
}



function change_user_login_exit($lang,$message)
{
	echo $message;

	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";

	if($lang == 'rus')
	{
		$change_user_nick_tlt = "Изменение данных профиля";
		$change_user_mail = "Введите новый е-маил";
		$change_user_mail_warn = "Внимание! После изменения даных, необходимо вновь активировать аккаунт!";
		$profile_change_button = "Изменить";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{	
		$change_user_nick_tlt = "Mainīt profila datus";
		$change_user_mail = "Ievadiet jaunu e-pasta adresi";
		$change_user_mail_warn = "Uzmanību! Pēc datu maiņas nepieciešams vēlreiz aktivizēt kontu!";
		$profile_change_button = "Nomainīt";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
?>
<br /><hr />
	<table width="400px" align="center" border="0" cellpadding="0" cellspacing="0">
	<form action="change_user_info.php?lang=<?php echo $lang; ?>" method="post">
	<tr>
	<td align="center" colspan="2"><h3><?php echo $change_user_nick_tlt; ?></h3></td>
	<tr>
	<td align="center" colspan="2"><p><strong><?php echo $change_user_mail_warn; ?></strong></p></td>
	</tr>
	<tr><td colspan="2"><input type="hidden" name="hidden" maxlength="6" size="6" /></td>
	</tr>
	<tr>
	<td><p><?php echo $change_user_mail; ?>: </p></td>
	<td><input type="text" name="login" size="20" maxlength="50" /></td>
	</tr>
	<tr>
	<td align="center" colspan="2"><input name="submit" type="submit" value="<?php echo $profile_change_button; ?>" /></td>
	</tr>
	</form>
	</table>
    </div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("../block/footer_user.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
exit();
}



function change_user_passwd_exit($lang,$message)
{
	echo $message;

	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";

	if($lang == 'rus')
	{
		$change_user_nick_tlt = "Изменение данных профиля";
		$change_user_passwd = "Введите новый пароль";
		$change_user_passwd2 = "Введите подтверждение пароля";
		$profile_change_button = "Изменить";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{
		$change_user_nick_tlt = "Mainīt profila datus";
		$change_user_passwd = "Ievadiet jaunu paroli";
		$change_user_passwd2 = "Apstipriniet paroli";
		$profile_change_button = "Nomainīt";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
?>
<br /><hr />
	<table width="450px" align="center" border="0" cellpadding="0" cellspacing="0">
	<form action="change_user_info.php?lang=<?php echo $lang; ?>" method="post">
	<tr>
	<td align="center" colspan="2"><h3><?php echo $change_user_nick_tlt; ?></h3></td>
	</tr>
	<tr><td colspan="2"><input type="hidden" name="hidden" maxlength="6" size="6" /></td>
	</tr>
	<tr>
	<td><p><?php echo $change_user_passwd; ?>:</p> </td>
	<td><input type="password" name="new_passwd" size="20" maxlength="20" /></td>
	</tr>
	<tr>
	<td><p><?php echo $change_user_passwd2; ?>:</p> </td>
	<td><input type="password" name="new_passwd2" size="20" maxlength="20" /></td>
	</tr>
	<tr>
	<td align="center" colspan="2"><input name="submit" type="submit" value="<?php echo $profile_change_button; ?>" /></td>
	</tr>
	</form>
	</table>
    </div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("../block/footer_user.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
exit();
}



function change_user_avatar_exit($lang,$message)
{
	echo $message;

	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";

	if($lang == 'rus')
	{
		$change_user_nick_tlt = "Изменение данных профиля";
		$change_user_avatar = "Выберите изображение";
		$profile_change_button = "Изменить";
		$change_user_avatar_info = "Внимание! Вы можете загрузить изображения с расширением .jpg и максимальным размером 2мб.";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{	
		$change_user_nick_tlt = "Mainīt profila datus";
		$change_user_avatar = "Izvēlieties attēlu";
		$profile_change_button = "Nomainīt";
		$change_user_avatar_info = "Uzmanību! Ielādēt atļauts attēlus jpg formātā ar maksimālo izmēru 2mb.";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
	?>
    <br /><hr />
	<table width="450px" align="center" border="0" cellpadding="0" cellspacing="0">
	<form action="change_user_info.php?lang=<?php echo $lang; ?>" method="post" enctype="multipart/form-data">
	<tr>
	<td align="center" colspan="2"><h3><?php echo $change_user_nick_tlt; ?></h3></td>
	</tr>
    <tr>
    <td colspan="2"><p><strong><?php echo $change_user_avatar_info; ?></strong></p></td>
	<tr>
	<tr>
	<td><p><?php echo $change_user_avatar; ?>:</p> </td>
	<td><p><input type="file" name="fupload" /></p></td>
    </tr>
    <tr>
    <td colspan="2" align="center" height="60px"><input name="submit" type="submit" value="<?php echo $profile_change_button; ?>" /></td>
	</tr>
	</form>
	</table>
    </div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("../block/footer_user.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
	<?php
exit();
}




function empty_one_lang_form($lang,$message,$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo)
{
	echo $message;
	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";
	
	if($lang == 'rus')
	{
		$ltd_create_mand = "Обязательные поля для заполнения обозначены *";
		$ltd_create_pvn = "Введите регистрационный номер";
		$ltd_create_name = "Введите название фирмы";
		$ltd_create_descr = "Введите описание фирмы";
		$ltd_create_web = "Введите вебсайт фирмы";
		$ltd_create_phone = "Введите телефонные номера";
		$ltd_create_fax = "Введите факс";
		$ltd_create_addres = "Введите адрес";
		$ltd_create_city = "Выберите город";
		$ltd_create_post = "Введите почтовый индекс";
		$ltd_create_descr_offer = "Введите описание акции/скидки";
		$ltd_create_dates = "Выберите даты действия акции/скидки";
		$ltd_create_dates_from = "От";
		$ltd_create_dates_till = "До";
		$ltd_create_opt_but = "Продолжить";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{
		$ltd_create_mand = "Obligāti aizpildāmie lauki apzīmēti ar *";
		$ltd_create_pvn = "Ievadiet reģistrācijas numuru";
		$ltd_create_name = "Ievadiet kompānijas nosaukumu";
		$ltd_create_descr = "Ievadiet kompānijas aprakstu";
		$ltd_create_web = "Ievadiet kompānijas mājas lapu";
		$ltd_create_phone = "Ievadiet tālruņa numurus";
		$ltd_create_fax = "Ievadiet faksu";
		$ltd_create_addres = "Ievadiet adresi";
		$ltd_create_city = "Izvēlieties pilsētu";
		$ltd_create_post = "Ievadiet pasta indeksu";
		$ltd_create_descr_offer = "Ievadiet akciju/atlaižu aprakstu";
		$ltd_create_dates = "Izvēlieties akciju/atlaižu datumus";
		$ltd_create_dates_from = "No";
		$ltd_create_dates_till = "Līdz";
		$ltd_create_opt_but = "Turpināt";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
	?>
    	<br /><hr />
				<table align="center" border="0" cellpadding="2" cellspacing="0">
				<form action="ltd_create.php?lang=<?php echo $lang; ?>" method="post">
				<tr>
				<td colspan="3"><input type="hidden" name="hidden" size="3" maxlength="3"></td>
				</tr>
                <tr>
                <td colspan="3" align="left"><p class="stats"><?php echo $ltd_create_mand; ?></p></td>
                </tr>
                <tr>
                <td><p><?php echo $ltd_create_pvn; ?> <strong style="color:#F00">*</strong></p></td>
                <td align="right"></td>
                <td><input type="text" name="pvn" size="20" maxlength="16" value="<?php echo $pvn; ?>" /></td>
                </tr>
				<tr>
				<td><p><?php echo $ltd_create_name; ?> <strong style="color:#F00">*</strong></p></td>
                <td width="50px" align="right"></td>
				<td><input type="text" name="sh_name" size="20" maxlength="50" value="<?php echo $sh_name; ?>" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_descr; ?></p></td>
                <td align="right"></td>
				<td><textarea name="descr_sh" cols="40" rows="10"><?php echo htmlspecialchars_decode($descr_sh); ?></textarea>
                </td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_web; ?></p></td>
                <td align="right"><p>www.</p></td>
				<td><input type="text" name="web_sh" size="20" maxlength="40" value="<?php echo $web_sh; ?>" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_phone; ?></p></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="phone_sh" size="8" maxlength="8" value="<?php echo $phone_sh; ?>" /></td>
                </tr>
                <tr>
                <td></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="phone_sh_2" size="8" maxlength="8" value="<?php echo $phone_sh_2; ?>" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_fax; ?></p></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="fax_sh" size="8" maxlength="8" value="<?php echo $fax_sh; ?>" /></td>
				</tr>	
				<tr>
				<td><p><?php echo $ltd_create_addres; ?></p></td>
                <td align="right"></td>
				<td><input type="text" name="address_sh" size="20" maxlength="60" value="<?php echo $address_sh; ?>" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_city; ?></p></td>
                <td align="right"></td>
				<td><select name="city"><?php if($lang == 'rus')
				{
					?>
					<option value="Рига">Рига</option>
						<option value="Юрмала">Юрмала</option>
						<option value="Рижский р-он">Рижский р-он</option>
						<option value="Айзкраукле и р-он">Айзкраукле и р-он</option>
						<option value="Алуксне и р-он">Алуксне и р-он</option>
						<option value="Балви и р-он">Балви и р-он</option>
						<option value="Бауска и р-он">Бауска и р-он</option>
						<option value="Валка и р-он">Валка и р-он</option>
						<option value="Валмиера и р-он">Валмиера и р-он</option>
						<option value="Вентспилс и р-он">Вентспилс и р-он</option>
						<option value="Гулбене и р-он">Гулбене и р-он</option>
						<option value="Даугавпилс и р-он">Даугавпилс и р-он</option>
						<option value="Добеле и р-он">Добеле и р-он</option>
						<option value="Екабпилс и р-он">Екабпилс и р-он</option>
						<option value="Елгава и р-он">Елгава и р-он</option>
						<option value="Краславa и р-он">Краславa и р-он</option>
						<option value="Кулдыга и р-он">Кулдыга и р-он</option>
						<option value="Лиепая и р-он">Лиепая и р-он</option>
						<option value="Лимбажи и р-он">Лимбажи и р-он</option>
						<option value="Лудза и р-он">Лудза и р-он</option>
						<option value="Мадона и р-он">Мадона и р-он</option>
						<option value="Огре и р-он">Огре и р-он</option>
						<option value="Преили и р-он">Преили и р-он</option>
						<option value="Резекне и р-он">Резекне и р-он</option>
						<option value="Салдус и р-он">Салдус и р-он</option>
						<option value="Талси и р-он">Талси и р-он</option>
						<option value="Тукумс и р-он">Тукумс и р-он</option>
						<option value="Цесис и р-он">Цесис и р-он</option>
                <?php
				}
				else
				{
				?>
					<option value="Rīga">Rīga</option>
						<option value="Jūrmala">Jūrmala</option>
						<option value="Rīgas rajons">Rīgas rajons</option>
						<option value="Aizkraukle un raj">Aizkraukle un raj</option>
						<option value="Alūksne un raj">Alūksne un raj</option>
						<option value="Balvi un raj">Balvi un raj</option>
						<option value="Bauska un raj">Bauska un raj</option>
						<option value="Cēsis un raj">Cēsis un raj</option>
						<option value="Daugavpils un raj">Daugavpils un raj</option>
						<option value="Dobele un raj">Dobele un raj</option>
						<option value="Gulbene un raj">Gulbene un raj</option>
						<option value="Jēkabpils un raj">Jēkabpils un raj</option>
						<option value="Jelgava un raj">Jelgava un raj</option>
						<option value="Krāslava un raj">Krāslava un raj</option>
						<option value="Kuldīga un raj">Kuldīga un raj</option>
						<option value="Liepāja un raj">Liepāja un raj</option>
						<option value="Limbaži un raj">Limbaži un raj</option>
						<option value="Ludza un raj">Ludza un raj</option>
						<option value="Madona un raj">Madona un raj</option>
						<option value="Ogre un raj">Ogre un raj</option>
						<option value="Preiļi un raj">Preiļi un raj</option>
						<option value="Rēzekne un raj">Rēzekne un raj</option>
						<option value="Saldus un raj">Saldus un raj</option>
						<option value="Talsi un raj">Talsi un raj</option>
						<option value="Tukums un raj">Tukums un raj</option>
						<option value="Valka un raj">Valka un raj</option>
						<option value="Valmiera un raj">Valmiera un raj</option>
						<option value="Ventspils un raj">Ventspils un raj</option>
                <?php 
				} ?>
                </select></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_post; ?></p></td>
                <td align="right"><p>LV -</p></td>
				<td><input type="text" name="post_sh" size="4" maxlength="4" value="<?php echo $post_sh; ?>" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_descr_offer; ?> <strong style="color:#F00">*</strong></p></td>
                <td align="right"></td>
				<td><textarea name="descr_offer" cols="40" rows="10"><?php echo $descr_offer; ?></textarea>
                </td>
				</tr>	
				<tr>
				<td><p><?php echo $ltd_create_dates; ?></p></td>
                <td align="right"><p><?php echo $ltd_create_dates_from; ?>: <strong style="color:#F00">*</strong></p></td>
				<td><input type="text" name="from_date_offer" size="20" maxlength="12" class="date_input" value="<?php echo $date_from; ?>" /></td>
                </tr>
                <tr>
                <td></td>
                <td align="right"><p><?php echo $ltd_create_dates_till; ?>: <strong style="color:#F00">*</strong></p></td>
				<td><input type="text" name="till_date_offer" size="20" maxlength="12" class="date_input" value="<?php echo $date_till; ?>" /></td>
				</tr>
                <tr>
                <td colspan="3"><input type="hidden" name="lang_choise" value="one_lang" /></td>
				<tr>
                <td><input type="hidden" name="def" value="<?php echo $def; ?>" /></td>
                <td><input type="hidden" name="b_def" value="<?php echo $b_def; ?>" /></td>
                <td><input type="hidden" name="photo_choise" value="<?php echo $photo; ?>" /></td>
                </tr>
                <tr>
				<td align="center" colspan="3"><p><input name="ltd_create" type="submit" value="<?php echo $ltd_create_opt_but; ?>" /></p></td>
				</tr>
				</form>
				</table>
                </div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("../block/footer_user.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
                
	<?php
exit();
}




function ltd_create_succes_photo($lang,$message,$sh_name)
{	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";
	
	if($lang == 'rus')
	{
		$ltd_create_opt_but = "Продолжить";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{	
		$ltd_create_opt_but = "Turpināt";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
?>
<table align="center" border="0" cellpadding="0" cellspacing="0">
<form action="upload.php?lang=<?php echo $lang;?>" method="post">
<tr>
<td><p><?php echo $message; ?></p></td>
<td><input type="hidden" name="sh_name" value="<?php echo $sh_name; ?>" /></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" name="upload" value="<?php echo $ltd_create_opt_but; ?>" /></td>
</tr>
</form>
</table>

</div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <td align="left" valign="middle"><?php echo $footercoopyrights; ?></td>
    <td align="right"><?php echo $footermenu_user; ?></td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
exit();
}





function empty_two_lang_form($lang,$message,$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo)
{
	echo $message;
	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";
	
	if($lang == 'rus')
	{
		$ltd_create_mand = "Обязательные поля для заполнения обозначены *";
		$ltd_create_pvn = "Введите регистрационный номер";
		$ltd_create_name = "Введите название фирмы";
		$ltd_create_descr = "Введите описание фирмы";
		$ltd_create_web = "Введите вебсайт фирмы";
		$ltd_create_phone = "Введите телефонные номера";
		$ltd_create_fax = "Введите факс";
		$ltd_create_addres = "Введите адрес";
		$ltd_create_city = "Выберите город";
		$ltd_create_post = "Введите почтовый индекс";
		$ltd_create_descr_offer = "Введите описание акции/скидки";
		$ltd_create_dates = "Выберите даты действия акции/скидки";
		$ltd_create_dates_from = "От";
		$ltd_create_dates_till = "До";
		$ltd_create_descr_sec_lang = "Введите описание фирмы на втором языке";
		$ltd_create_descr_offer_sec_lang = "Введите описание акции/скидки на втором языке";
		$ltd_create_opt_but = "Продолжить";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{
		$ltd_create_mand = "Obligāti aizpildāmie lauki apzīmēti ar *";
		$ltd_create_pvn = "Ievadiet reģistrācijas numuru";
		$ltd_create_name = "Ievadiet kompānijas nosaukumu";
		$ltd_create_descr = "Ievadiet kompānijas aprakstu";
		$ltd_create_web = "Ievadiet kompānijas mājas lapu";
		$ltd_create_phone = "Ievadiet tālruņa numurus";
		$ltd_create_fax = "Ievadiet faksu";
		$ltd_create_addres = "Ievadiet adresi";
		$ltd_create_city = "Izvēlieties pilsētu";
		$ltd_create_post = "Ievadiet pasta indeksu";
		$ltd_create_descr_offer = "Ievadiet akciju/atlaižu aprakstu";
		$ltd_create_dates = "Izvēlieties akciju/atlaižu datumus";
		$ltd_create_dates_from = "No";
		$ltd_create_dates_till = "Līdz";
		$ltd_create_descr_sec_lang = "Ievadiet kompānijas aprakstu otrā valodā";
		$ltd_create_descr_offer_sec_lang = "Ievadiet akciju/atlaižu aprakstu otrā valodā";
		$ltd_create_opt_but = "Turpināt";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
	?>
    	<br /><hr />
				<table align="center" border="0" cellpadding="2" cellspacing="0">
				<form action="ltd_create.php?lang=<?php echo $lang; ?>" method="post">
				<tr>
				<td colspan="3"><input type="hidden" name="hidden" size="3" maxlength="3"></td>
				</tr>
                <tr>
                <td colspan="3" align="left"><p class="stats"><?php echo $ltd_create_mand; ?></p></td>
                </tr>
                <tr>
                <td><p><?php echo $ltd_create_pvn; ?> <strong style="color:#F00">*</strong></p></td>
                <td align="right"></td>
                <td><input type="text" name="pvn" size="20" maxlength="16" value="<?php echo $pvn; ?>" /></td>
                </tr>
				<tr>
				<td><p><?php echo $ltd_create_name; ?> <strong style="color:#F00">*</strong></p></td>
                <td width="50px" align="right"></td>
				<td><input type="text" name="sh_name" size="20" maxlength="50" value="<?php echo $sh_name; ?>" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_descr; ?></p></td>
                <td align="right"></td>
				<td><textarea name="descr_sh" cols="40" rows="10"><?php echo $descr_sh; ?></textarea>
                </td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_web; ?></p></td>
                <td align="right"><p>www.</p></td>
				<td><input type="text" name="web_sh" size="20" maxlength="40" value="<?php echo $web_sh; ?>" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_phone; ?></p></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="phone_sh" size="8" maxlength="8" value="<?php echo $phone_sh; ?>" /></td>
                </tr>
                <tr>
                <td></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="phone_sh_2" size="8" maxlength="8" value="<?php echo $phone_sh_2; ?>" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_fax; ?></p></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="fax_sh" size="8" maxlength="8" value="<?php echo $fax_sh; ?>" /></td>
				</tr>	
				<tr>
				<td><p><?php echo $ltd_create_addres; ?></p></td>
                <td align="right"></td>
				<td><input type="text" name="address_sh" size="20" maxlength="60" value="<?php echo $address_sh; ?>" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_city; ?></p></td>
                <td align="right"></td>
				<td><select name="city"><?php if($lang == 'rus')
				{
					?>
					<option value="Рига">Рига</option>
						<option value="Юрмала">Юрмала</option>
						<option value="Рижский р-он">Рижский р-он</option>
						<option value="Айзкраукле и р-он">Айзкраукле и р-он</option>
						<option value="Алуксне и р-он">Алуксне и р-он</option>
						<option value="Балви и р-он">Балви и р-он</option>
						<option value="Бауска и р-он">Бауска и р-он</option>
						<option value="Валка и р-он">Валка и р-он</option>
						<option value="Валмиера и р-он">Валмиера и р-он</option>
						<option value="Вентспилс и р-он">Вентспилс и р-он</option>
						<option value="Гулбене и р-он">Гулбене и р-он</option>
						<option value="Даугавпилс и р-он">Даугавпилс и р-он</option>
						<option value="Добеле и р-он">Добеле и р-он</option>
						<option value="Екабпилс и р-он">Екабпилс и р-он</option>
						<option value="Елгава и р-он">Елгава и р-он</option>
						<option value="Краславa и р-он">Краславa и р-он</option>
						<option value="Кулдыга и р-он">Кулдыга и р-он</option>
						<option value="Лиепая и р-он">Лиепая и р-он</option>
						<option value="Лимбажи и р-он">Лимбажи и р-он</option>
						<option value="Лудза и р-он">Лудза и р-он</option>
						<option value="Мадона и р-он">Мадона и р-он</option>
						<option value="Огре и р-он">Огре и р-он</option>
						<option value="Преили и р-он">Преили и р-он</option>
						<option value="Резекне и р-он">Резекне и р-он</option>
						<option value="Салдус и р-он">Салдус и р-он</option>
						<option value="Талси и р-он">Талси и р-он</option>
						<option value="Тукумс и р-он">Тукумс и р-он</option>
						<option value="Цесис и р-он">Цесис и р-он</option>
                <?php
				}
				else
				{
				?>
					<option value="Rīga">Rīga</option>
						<option value="Jūrmala">Jūrmala</option>
						<option value="Rīgas rajons">Rīgas rajons</option>
						<option value="Aizkraukle un raj">Aizkraukle un raj</option>
						<option value="Alūksne un raj">Alūksne un raj</option>
						<option value="Balvi un raj">Balvi un raj</option>
						<option value="Bauska un raj">Bauska un raj</option>
						<option value="Cēsis un raj">Cēsis un raj</option>
						<option value="Daugavpils un raj">Daugavpils un raj</option>
						<option value="Dobele un raj">Dobele un raj</option>
						<option value="Gulbene un raj">Gulbene un raj</option>
						<option value="Jēkabpils un raj">Jēkabpils un raj</option>
						<option value="Jelgava un raj">Jelgava un raj</option>
						<option value="Krāslava un raj">Krāslava un raj</option>
						<option value="Kuldīga un raj">Kuldīga un raj</option>
						<option value="Liepāja un raj">Liepāja un raj</option>
						<option value="Limbaži un raj">Limbaži un raj</option>
						<option value="Ludza un raj">Ludza un raj</option>
						<option value="Madona un raj">Madona un raj</option>
						<option value="Ogre un raj">Ogre un raj</option>
						<option value="Preiļi un raj">Preiļi un raj</option>
						<option value="Rēzekne un raj">Rēzekne un raj</option>
						<option value="Saldus un raj">Saldus un raj</option>
						<option value="Talsi un raj">Talsi un raj</option>
						<option value="Tukums un raj">Tukums un raj</option>
						<option value="Valka un raj">Valka un raj</option>
						<option value="Valmiera un raj">Valmiera un raj</option>
						<option value="Ventspils un raj">Ventspils un raj</option>
                <?php 
				} ?>
                </select></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_post; ?></p></td>
                <td align="right"><p>LV -</p></td>
				<td><input type="text" name="post_sh" size="4" maxlength="4" value="<?php echo $post_sh; ?>" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_descr_offer; ?> <strong style="color:#F00">*</strong></p></td>
                <td align="right"></td>
				<td><textarea name="descr_offer" cols="40" rows="10"><?php echo $descr_offer; ?></textarea>
                </td>
				</tr>	
				<tr>
				<td><p><?php echo $ltd_create_dates; ?></p></td>
                <td align="right"><p><?php echo $ltd_create_dates_from; ?>: <strong style="color:#F00">*</strong></p></td>
				<td><input type="text" name="from_date_offer" size="20" maxlength="12" class="date_input" value="<?php echo $date_from; ?>" /></td>
                </tr>
                <tr>
                <td></td>
                <td align="right"><p><?php echo $ltd_create_dates_till; ?>: <strong style="color:#F00">*</strong></p></td>
				<td><input type="text" name="till_date_offer" size="20" maxlength="12" class="date_input" value="<?php echo $date_till; ?>" /></td>
				</tr>
                <tr>
				<td><p><?php echo $ltd_create_descr_sec_lang; ?></p></td>
                <td></td>
				<td><textarea name="descr_sh_sec_lang" cols="40" rows="10"><?php echo $descr_sh_sec_lang; ?></textarea>
                </td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_descr_offer_sec_lang; ?> <strong style="color:#F00">*</strong></p></td>
                <td></td>
				<td><textarea name="descr_offer_sec_lang" cols="40" rows="10"><?php echo $descr_offer_sec_lang; ?></textarea>
                </td>
				</tr>
                <tr>
                <td colspan="3"><input type="hidden" name="lang_choise" value="two_lang" /></td>
				<tr>
                <td><input type="hidden" name="def" value="<?php echo $def; ?>" /></td>
                <td><input type="hidden" name="b_def" value="<?php echo $b_def; ?>" /></td>
                <td><input type="hidden" name="photo_choise" value="<?php echo $photo; ?>" /></td>
                </tr>
                <tr>
				<td align="center" colspan="3"><p><input name="ltd_create" type="submit" value="<?php echo $ltd_create_opt_but; ?>" /></p></td>
				</tr>
				</form>
				</table>
                </div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("../block/footer_user.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
                
	<?php
exit();
}




function upload_footer($lang,$message)
{
	echo $message;
	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";
	
	if($lang == 'rus')
	{
		$upload_button = "Загрузить";
		$form_pict = "Форма для загрузки фотографий:";
		$picture = "Фотография";
		$form_logo = "Форма для загрузки логотипа:";
		$logo = "Логотип:";
		$upload_message = "Внимание! Вы можете загрузить файлы только с расширением .jpg и максимальным размером 2мб. <br>Каждая ячейка соответствует порядку изображния в галерее!";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{	
		$upload_button = "Lejupielādēt";
		$form_pict = "Forma fotogrāfiju lejupielādei:";
		$picture = "Fotogrāfija";
		$form_logo = "Forma logotipa lejupielādei:";
		$logo = "Logotips:";
		$upload_message = "Uzmanību! Ielādēt ir atļauts tikai failus ar formātu .jpg un maksimālo izmēru 2mb. <br>Fotogrāfijas tiek ielādētas secīgā kārtībā!";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
?>
<Br /><hr>
<form action='upload.php?lang=<?php echo $lang; ?>' method='post' enctype='multipart/form-data' >
            <table width='500' border='0' cellpadding="0" cellspacing="0" align='center'>
              <tr>
                <td colspan='2'><h4 align="center"><?php echo $form_pict; ?></h4></td>
              </tr>
              <tr>
              <td colspan="2"><p><strong><?php echo $upload_message; ?></strong></p></td>
              </tr>
              <tr>
                <td><p><?php echo $picture; ?> 1: </p></td>
                <td><input type='file' name='userfile' /></td>
                </td>
              </tr>
              <tr>
                <td><p><?php echo $picture; ?> 2: </p></td>
                <td><input type='file' name='userfile1' /></td>
                </tr>
              <tr>
                <td><p><?php echo $picture; ?> 3: </p></td>
                <td><input type='file' name='userfile2' /></td>
                </tr>
              <tr>
                <td><p><?php echo $picture; ?> 4: </p></td>
                <td><input type='file' name='userfile3' /></td>
                </tr>
              <tr>
                <td colspan='2'><h4 align="center"><?php echo $form_logo; ?></h4></td>
              </tr>
              <tr>
                <td><p><?php echo $logo; ?></p></td>
                <td><input type='file' name='userfile4' /></td>
                </tr>
              <tr>
              <td colspan="2"><input type="hidden" name="sh_name" value="<?php echo $sh_name; ?>" /></td>
              </tr>
              <tr>
              <td style="padding-top:20px" align='center' colspan="2"><input name="doUpload" type='submit' value='<?php echo $upload_button; ?>' /></td>
              </tr>
            </table>
            </form>
</div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <td align="left" valign="middle"><?php echo $footercoopyrights; ?></td>
    <td align="right"><?php echo $footermenu_user; ?></td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
exit();
}





function change_ltd($lang,$message,$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch)
{
	echo $message;
	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";
	
	if($lang == 'rus')
	{
		$change_ltd_name_warn = "Внимание изменение поля \"название фирмы\" деактивирует страницу для проверки данных!";
		$change_ltd_pvn_warn = "Внимание изменение поля \"регистрационный номер\" деактивирует страницу для проверки данных!";
		$ltd_create_mand = "Обязательные поля для заполнения обозначены *";
		$ltd_create_pvn = "Введите регистрационный номер";
		$ltd_create_name = "Введите название фирмы";
		$ltd_create_descr = "Введите описание фирмы";
		$ltd_create_web = "Введите вебсайт фирмы";
		$ltd_create_phone = "Введите телефонные номера";
		$ltd_create_fax = "Введите факс";
		$ltd_create_addres = "Введите адрес";
		$ltd_create_city = "Выберите город";
		$ltd_create_post = "Введите почтовый индекс";
		$ltd_create_descr_offer = "Введите описание акции/скидки";
		$ltd_create_dates = "Выберите даты действия акции/скидки";
		$ltd_create_dates_from = "От";
		$ltd_create_dates_till = "До";
		$ltd_create_descr_sec_lang = "Введите описание фирмы на втором языке";
		$ltd_create_descr_offer_sec_lang = "Введите описание акции/скидки на втором языке";
		$ltd_create_opt_but = "Продолжить";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{
		$change_ltd_name_warn = "Uzmanību! Izmaiņas laukā \"kompānijas nosaukums\" deaktivizēs lapu datu pārbaudei!";
		$change_ltd_pvn_warn = "Uzmanību! Izmaiņas laukā \"reģistrācijas numurs\" deaktivizēs lapu datu pārbaudei!";
		$ltd_create_mand = "Obligāti aizpildāmie lauki apzīmēti ar *";
		$ltd_create_pvn = "Ievadiet reģistrācijas numuru";
		$ltd_create_name = "Ievadiet kompānijas nosaukumu";
		$ltd_create_descr = "Ievadiet kompānijas aprakstu";
		$ltd_create_web = "Ievadiet kompānijas mājas lapu";
		$ltd_create_phone = "Ievadiet tālruņa numurus";
		$ltd_create_fax = "Ievadiet faksu";
		$ltd_create_addres = "Ievadiet adresi";
		$ltd_create_city = "Izvēlieties pilsētu";
		$ltd_create_post = "Ievadiet pasta indeksu";
		$ltd_create_descr_offer = "Ievadiet akciju/atlaižu aprakstu";
		$ltd_create_dates = "Izvēlieties akciju/atlaižu datumus";
		$ltd_create_dates_from = "No";
		$ltd_create_dates_till = "Līdz";
		$ltd_create_descr_sec_lang = "Ievadiet kompānijas aprakstu otrā valodā";
		$ltd_create_descr_offer_sec_lang = "Ievadiet akciju/atlaižu aprakstu otrā valodā";
		$ltd_create_opt_but = "Turpināt";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
?>
<br /><hr />
		<table align="center" border="0" cellpadding="2" cellspacing="0">
		<form action="change_ltd.php?lang=<?php echo $lang; ?>" method="post">
        <tr>
        <td colspan="3" align="left"><p class="stats"><?php echo $ltd_create_mand; ?></p></td>
        </tr>
		<tr>
		<td colspan="3"><input type="hidden" name="hidden" size="3" maxlength="3"></td>
		</tr>
		<?php
		if(isset($pvn_ch))
		{
			?>
            <tr>
            <td align="center" colspan="3"><p><strong><?php echo $change_ltd_pvn_warn; ?></strong></p></td>
            </tr>
            <tr>
            <td><p><?php echo $ltd_create_pvn; ?> <strong style="color:#F00">*</strong></p></td>
            <td align="right"></td>
            <td><input type="text" name="pvn" size="20" maxlength="16" value="<?php echo $pvn; ?>" /></td>
            </tr>
            <?php
		}
		
		if(isset($sh_name_ch))
		{
			?>
            <tr>
            <td align="center" colspan="3"><p><strong><?php echo $change_ltd_name_warn; ?></strong></p></td>
            </tr>
            <tr>
			<td><p><?php echo $ltd_create_name; ?>  <strong style="color:#F00">*</strong></p></td>
            <td width="50px" align="right"></td>
			<td><input type="text" name="sh_name" size="20" maxlength="50" value="<?php echo $sh_name; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($descr_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_descr; ?></p></td>
            <td align="right"></td>
			<td><textarea name="descr_sh" cols="40" rows="10"><?php echo $descr_sh; ?></textarea>
            </td>
			</tr>
            <?php	
		}

		if(isset($web_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_web; ?></p></td>
            <td align="right"><p>www.</p></td>
			<td><input type="text" name="web_sh" size="20" maxlength="40" value="<?php echo $web_sh; ?>" /></td>
			</tr>
            <?php	
		}
		
		if(isset($phone_1_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_phone; ?></p></td>
            <td align="right"><p>+ 371</p></td>
			<td><input type="text" name="phone_sh" size="8" maxlength="8" value="<?php echo $phone_sh; ?>" /></td>
            </tr>
            <?php
		}
		
		if(isset($phone_2_ch))
		{
			?>
            <tr>
            <td></td>
            <td align="right"><p>+ 371</p></td>
			<td><input type="text" name="phone_sh_2" size="8" maxlength="8" value="<?php echo $phone_sh_2; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($fax_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_fax; ?></p></td>
            <td align="right"><p>+ 371</p></td>
			<td><input type="text" name="fax_sh" size="8" maxlength="8" value="<?php echo $fax_sh; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($address_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_addres; ?></p></td>
            <td align="right"></td>
			<td><input type="text" name="address_sh" size="20" maxlength="60" value="<?php echo $address_sh; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($city_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_city; ?></p></td>
            <td align="right"></td>
			<td><select name="city"><?php if($lang == 'rus')
			{
				?>
				<option value="Рига">Рига</option>
				<option value="Юрмала">Юрмала</option>
				<option value="Рижский р-он">Рижский р-он</option>
				<option value="Айзкраукле и р-он">Айзкраукле и р-он</option>
				<option value="Алуксне и р-он">Алуксне и р-он</option>
				<option value="Балви и р-он">Балви и р-он</option>
				<option value="Бауска и р-он">Бауска и р-он</option>
				<option value="Валка и р-он">Валка и р-он</option>
				<option value="Валмиера и р-он">Валмиера и р-он</option>
				<option value="Вентспилс и р-он">Вентспилс и р-он</option>
				<option value="Гулбене и р-он">Гулбене и р-он</option>
				<option value="Даугавпилс и р-он">Даугавпилс и р-он</option>
				<option value="Добеле и р-он">Добеле и р-он</option>
				<option value="Екабпилс и р-он">Екабпилс и р-он</option>
				<option value="Елгава и р-он">Елгава и р-он</option>
				<option value="Краславa и р-он">Краславa и р-он</option>
				<option value="Кулдыга и р-он">Кулдыга и р-он</option>
				<option value="Лиепая и р-он">Лиепая и р-он</option>
				<option value="Лимбажи и р-он">Лимбажи и р-он</option>
				<option value="Лудза и р-он">Лудза и р-он</option>
				<option value="Мадона и р-он">Мадона и р-он</option>
				<option value="Огре и р-он">Огре и р-он</option>
				<option value="Преили и р-он">Преили и р-он</option>
				<option value="Резекне и р-он">Резекне и р-он</option>
				<option value="Салдус и р-он">Салдус и р-он</option>
				<option value="Талси и р-он">Талси и р-он</option>
				<option value="Тукумс и р-он">Тукумс и р-он</option>
				<option value="Цесис и р-он">Цесис и р-он</option>
                <?php
			}
			else
			{
				?>
				<option value="Rīga">Rīga</option>
				<option value="Jūrmala">Jūrmala</option>
				<option value="Rīgas rajons">Rīgas rajons</option>
				<option value="Aizkraukle un raj">Aizkraukle un raj</option>
				<option value="Alūksne un raj">Alūksne un raj</option>
				<option value="Balvi un raj">Balvi un raj</option>
				<option value="Bauska un raj">Bauska un raj</option>
				<option value="Cēsis un raj">Cēsis un raj</option>
				<option value="Daugavpils un raj">Daugavpils un raj</option>
				<option value="Dobele un raj">Dobele un raj</option>
				<option value="Gulbene un raj">Gulbene un raj</option>
				<option value="Jēkabpils un raj">Jēkabpils un raj</option>
				<option value="Jelgava un raj">Jelgava un raj</option>
				<option value="Krāslava un raj">Krāslava un raj</option>
				<option value="Kuldīga un raj">Kuldīga un raj</option>
				<option value="Liepāja un raj">Liepāja un raj</option>
				<option value="Limbaži un raj">Limbaži un raj</option>
				<option value="Ludza un raj">Ludza un raj</option>
				<option value="Madona un raj">Madona un raj</option>
				<option value="Ogre un raj">Ogre un raj</option>
				<option value="Preiļi un raj">Preiļi un raj</option>
				<option value="Rēzekne un raj">Rēzekne un raj</option>
				<option value="Saldus un raj">Saldus un raj</option>
				<option value="Talsi un raj">Talsi un raj</option>
				<option value="Tukums un raj">Tukums un raj</option>
				<option value="Valka un raj">Valka un raj</option>
				<option value="Valmiera un raj">Valmiera un raj</option>
				<option value="Ventspils un raj">Ventspils un raj</option>
                <?php 
			} ?>
            </select></td>
			</tr>
            <?php
		}
		
		if(isset($post_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_post; ?></p></td>
            <td align="right"><p>LV -</p></td>
			<td><input type="text" name="post_sh" size="4" maxlength="4" value="<?php echo $post_sh; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($offer_descr_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_descr_offer; ?> <strong style="color:#F00">*</strong></p></td>
            <td align="right"></td>
			<td><textarea name="descr_offer" cols="40" rows="10"><?php echo $descr_offer; ?></textarea>
            </td>
			</tr>
            <?php
		}
		
		if(isset($dates_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_dates; ?></p></td>
            <td align="right"><p><?php echo $ltd_create_dates_from; ?>: <strong style="color:#F00">*</strong></p></td>
			<td><input type="text" name="from_date_offer" size="20" maxlength="12" class="date_input" value="<?php echo $date_from; ?>" /></td>
            </tr>
            <tr>
            <td></td>
            <td align="right"><p><?php echo $ltd_create_dates_till; ?>: <strong style="color:#F00">*</strong></p></td>
			<td><input type="text" name="till_date_offer" size="20" maxlength="12" class="date_input" value="<?php echo $date_till; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($descr_sec_lang_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_descr_sec_lang; ?></p></td>
            <td></td>
			<td><textarea name="descr_sh_sec_lang" cols="40" rows="10"><?php echo $descr_sh_sec_lang; ?></textarea></td>
			</tr>
            <?php
		}
		
		if(isset($offer_descr_sec_lang_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_descr_offer_sec_lang; ?> <strong style="color:#F00">*</strong></p></td>
            <td></td>
			<td><textarea name="descr_offer_sec_lang" cols="40" rows="10"><?php echo $descr_offer_sec_lang; ?></textarea></td>
			</tr>
            <?php
		}
		?>
        <tr>
        <td colspan="3">
        <?php if(isset($sh_name_ch))
		{
        	echo "<input type='hidden' name='sh_name_ch' value='1' />";
		}
		if(isset($pvn_ch))
		{
        	echo "<input type='hidden' name='pvn_ch' value='2' />";
		}
		if(isset($descr_ch))
		{
        	echo "<input type='hidden' name='descr_ch' value='3' />";
		}
		if(isset($web_ch))
		{
        	echo "<input type='hidden' name='web_ch' value='4' />";
		}
		if(isset($phone_1_ch))
		{
        	echo "<input type='hidden' name='phone_1_ch' value='5' />";
		}
		if(isset($phone_2_ch))
		{
        	echo "<input type='hidden' name='phone_2_ch' value='6' />";
		}
		if(isset($fax_ch))
		{
        	echo "<input type='hidden' name='fax_ch' value='7' />";
		}
		if(isset($address_ch))
		{
        	echo "<input type='hidden' name='address_ch' value='8' />";
		}
		if(isset($city_ch))
		{
        	echo "<input type='hidden' name='city_ch' value='9' />";
		}
		if(isset($post_ch))
		{
        	echo "<input type='hidden' name='post_ch' value='10' />";
		}
		if(isset($offer_descr_ch))
		{
        	echo "<input type='hidden' name='offer_descr_ch' value='11' />";
		}
		if(isset($dates_ch))
		{
        	echo "<input type='hidden' name='dates_ch' value='12' />";
		}
		if(isset($descr_sec_lang_ch))
		{
        	echo "<input type='hidden' name='descr_sec_lang_ch' value='13' />";
		}
		if(isset($offer_descr_sec_lang_ch))
		{
        	echo "<input type='hidden' name='offer_descr_sec_lang_ch' value='14' />";
		}
		?>
		</td>
        </tr>
        <tr>
        <td colspan="3"><input type="hidden" name="ltd" value="<?php echo $old_sh_name; ?>" /></td>
        </tr>
		<tr>
		<td align="center" colspan="3"><p><input name="ltd_create" type="submit" value="<?php echo $ltd_create_opt_but; ?>" /></p></td>
		</tr>
		</form>
		</table>

<?php
exit();
}




function erase_no_info($lang,$message,$sh_name)
{
	echo $message;
	
	$footercoopyrights = "<p class='pfc'>&copy;economLV ".date('Y').". Powered by <a href='#'>SH.</a></p>";
	
	if($lang == 'rus')
	{
		$erase_ltd_opt_h = "Удаление данных фирмы";
		$erase_ltd_opt_descr = "Очистить описание фирмы";
		$erase_ltd_opt_web = "Очистить вебсайт фирмы";
		$erase_ltd_opt_phone_1 = "Очистить номер телефона";
		$erase_ltd_opt_phone_2 = "Очистить дополнительный номер телефона";
		$erase_ltd_opt_fax = "Очистить номер факса";
		$erase_ltd_opt_address = "Очистить адрес";
		$erase_ltd_opt_post = "Очистить почтовый индекс";
		$erase_ltd_opt_sec_lang_h = "Удаление данных на втором языке";
		$erase_ltd_opt_sec_lang_descr_ltd = "Очистить описание фирмы на втором языке";
		$ltd_create_opt_but = "Продолжить";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=rus'>Ограничение Ответственности</a>  <a href='../about_us.php?lang=rus'>О Нас</a>  <a href='../contact_us.php?lang=rus'>Контакты</a></p>";
	}
	else
	{	
		$erase_ltd_opt_h = "Dzēst kompānijas datus";
		$erase_ltd_opt_descr = "Dzēst kompānijas aprakstu";
		$erase_ltd_opt_web = "Dzēst kompānijas mājas lapu";
		$erase_ltd_opt_phone_1 = "Dzēst tālruņa numuru";
		$erase_ltd_opt_phone_2 = "Dzēst papildus tālruņa numurus";
		$erase_ltd_opt_fax = "Dzēst faksa numuru";
		$erase_ltd_opt_address = "Dzēst adresi";
		$erase_ltd_opt_post = "Dzēst pasta indeksu";
		$erase_ltd_opt_sec_lang_h = "Dzēst datus, kuri ievadīti otrā valodā";
		$erase_ltd_opt_sec_lang_descr_ltd = "Dzēst kompānijas aprakstu otrā valodā";
		$ltd_create_opt_but = "Turpināt";
		$footermenu_user = "<p class='pfm'><a href='../disclaimer.php?lang=lat'>Atbildības Ierobežojums</a> <a href='../about_us.php?lang=lat'>Par Mums</a> <a href='../contact_us.php?lang=lat'>Kontakti</a></p>";
	}
?>
<table align="center" border="0" cellpadding="0" cellspacing="0">
        <form action="erase_ltd.php?lang=<?php echo $lang; ?>" method="post">
        <tr>
        <td colspan="2"><h4><?php echo $erase_ltd_opt_h; ?></h4></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $erase_ltd_opt_descr; ?></p></td>
        <td align="center"><input type="checkbox" name="descr_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $erase_ltd_opt_web; ?></p></td>
        <td align="center"><input type="checkbox" name="web_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $erase_ltd_opt_phone_1; ?></p></td>
        <td align="center"><input type="checkbox" name="phone_1_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $erase_ltd_opt_phone_2; ?></p></td>
        <td align="center"><input type="checkbox" name="phone_2_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $erase_ltd_opt_fax; ?></p></td>
        <td align="center"><input type="checkbox" name="fax_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $erase_ltd_opt_address; ?></p></td>
        <td align="center"><input type="checkbox" name="address_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $erase_ltd_opt_post; ?></p></td>
        <td align="center"><input type="checkbox" name="post_ch" /></td>
        </tr>
        <tr>
        <td colspan="2"><h4><?php echo $erase_ltd_opt_sec_lang_h; ?></h4></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $erase_ltd_opt_sec_lang_descr_ltd; ?></p></td>
        <td align="center"><input type="checkbox" name="descr_sec_lang_ch" /></td>
        </tr>
        <tr>
        <td colspan="2"><input type="hidden" name="ltd" value="<?php echo $sh_name; ?>" /></td>
        </tr>
        <tr>
        <td colspan="2" align="center"><p><input type="submit" name="submit" value="<?php echo $ltd_create_opt_but; ?>" /></p></td>
        </tr>
        </form>
        </table></div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <td align="left" valign="middle"><?php echo $footercoopyrights; ?></td>
    <td align="right"><?php echo $footermenu_user; ?></td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<?php
exit();
}





?>