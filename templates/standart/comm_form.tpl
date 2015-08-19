
<div class="h1" style="margin-top:10px">Оставить комментарий</div>
[_error]
<p style="font-size:14px;color:red;">[_messWL]</p>
<form action="[_action]#bottom" method="post" name="form">
<input name="id_comm" type="hidden" value="[_id]">
<input name="recomm" id="recomm" type="hidden" value="0">
<br>
<input class="inpu" style="width:600px;" name="author_comm" id="author_comm" onclick="if(document.getElementById('author_comm').value == 'Автор*')document.getElementById('author_comm').value = ''" type="text" value="Автор*">
<br>
<input class="inpu" style="width:600px;" name="email_comm" id="email_comm" onclick="if(document.getElementById('email_comm').value == 'E-Mail* (не публикуется)')document.getElementById('email_comm').value = ''" type="text" value="E-Mail* (не публикуется)">
<br>
<input class="inpu" style="width:600px;" name="site_comm" id="site_comm" type="text" value="http://">
<p>

<div id="messFROM" class="inp" style="display:none;width:600px;">
<div style="text-align:right;position:relative;margin-bottom:-15px;font-size:10px;cursor:pointer;" onclick="reqcomm(0,'',1);"><img src="templates/standart/img/close.png"></div>
Ваш ответ для <span id="reauthor" style="font-weight:bold"></span>.<br>Хотите написать новый комментарий? закройте форму!
</div>
<p>

<textarea class="inpu" style="width:600px;" name="txt_comm" id="txt_comm" onclick="if(document.getElementById('txt_comm').value == 'Введите текст*')document.getElementById('txt_comm').value = ''" rows="10">Введите текст*</textarea>
<br>
<p style="margin:0px;">Если вы человек, то нажмите на картинку "<span style="font-weight:bold;">[_q]</span>"</p>
<br>
<input id="code_comm" name="code_comm" type="hidden" value="">
<input name="hash" type="hidden" value="[_hash]">
<table width="160px" height="40px" cellpadding="0" cellspacing="0" border="0px">
	<tr>
		<td>
			<img id="cp1OK" style="position:absolute;display:none;" src="static/images/capcha/done.png" border="0px">
			<img style="cursor:pointer;" onclick="capcha(1,'[_code0]');" src="[_img0]" border="0px">
		</td>
		<td>
			<img id="cp2OK" style="position:absolute;display:none;" src="static/images/capcha/done.png" border="0px">
			<img style="cursor:pointer;" onclick="capcha(2,'[_code1]');" src="[_img1]" border="0px">
		</td>
		<td>
			<img id="cp3OK" style="position:absolute;display:none;" src="static/images/capcha/done.png" border="0px">
			<img style="cursor:pointer;" onclick="capcha(3,'[_code2]');" src="[_img2]" border="0px">
		</td>
		<td>
			<img id="cp4OK" style="position:absolute;display:none;" src="static/images/capcha/done.png" border="0px">
			<img style="cursor:pointer;" onclick="capcha(4,'[_code3]');" src="[_img3]" border="0px">
		</td>
	</tr>
</table>
<br><input class="input small" type="submit" value="Оставить комментарий">
</form>
<a name="bottom">&nbsp;</a>
<div class="clear"></div>