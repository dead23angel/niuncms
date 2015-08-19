
<div class="h1">Обратная связь с администрацией сайта</div>
[_error]
<form action="[_action]" method="post" class="inp" name="form2">
<input class="inpu" style="width:600px;" name="author_contact" id="author_contact" onclick="if(document.getElementById('author_contact').value == 'Введите имя*')document.getElementById('author_contact').value = '';" type="text" value="Введите имя*">
<br>
<input class="inpu" style="width:600px;" name="email_contact" id="email_contact" onclick="if(document.getElementById('email_contact').value == 'E-mail*')document.getElementById('email_contact').value = '';" type="text" value="E-mail*">
<br>
<input class="inpu" style="width:600px;" name="them_contact" id="them_contact" onclick="if(document.getElementById('them_contact').value == 'Тема*')document.getElementById('them_contact').value = '';" type="text" value="Тема*">
<br>
<textarea class="inpu" style="width:600px;" name="txt_contact" id="txt_contact" onclick="if(document.getElementById('txt_contact').value == 'Введите текст*')document.getElementById('txt_contact').value = '';" rows="10">Введите текст*</textarea>
<br><br>
<p style="margin:0px;">Если вы человек, то нажмите на картинку "<span style="font-weight:bold;">[_q]</span>"</p>
<br>
<input id="code_comm" name="code_contact" type="hidden" value="">
<input name="hashC" type="hidden" value="[_hash]">
<table width="160px" height="40px" cellpadding="0" cellspacing="0" border="0px">
	<tr>
		<td>
			<img id="cp1OK" style="position:absolute;display:none;" src="<?php echo $server_root ?>templates/system/images/capcha/done.png" border="0px">
			<img style="cursor:pointer;" onclick="capcha(1,'[_code0]');" src="[_img0]" border="0px">
		</td>
		<td>
			<img id="cp2OK" style="position:absolute;display:none;" src="<?php echo $server_root ?>templates/system/images/capcha/done.png" border="0px">
			<img style="cursor:pointer;" onclick="capcha(2,'[_code1]');" src="[_img1]" border="0px">
		</td>
		<td>
			<img id="cp3OK" style="position:absolute;display:none;" src="<?php echo $server_root ?>templates/system/images/capcha/done.png" border="0px">
			<img style="cursor:pointer;" onclick="capcha(3,'[_code2]');" src="[_img2]" border="0px">
		</td>
		<td>
			<img id="cp4OK" style="position:absolute;display:none;" src="<?php echo $server_root ?>templates/system/images/capcha/done.png" border="0px">
			<img style="cursor:pointer;" onclick="capcha(4,'[_code3]');" src="[_img3]" border="0px">
		</td>
	</tr>
</table>
<br>
<p><input class="button small" type="submit" value="Отправить сообщение"></p>
</form>