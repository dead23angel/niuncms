
<div class="block01">
Опрос
</div>
<div class="block03">
<form id="f_poll" action="index.php" method="post" name="f_poll">
<table align="center"> <td>[_qu]</td> </table>
<table>
[_while]
<tr>
<td>
<input type="radio" name="quePOLL" value="[_sub]"[_checked]/>
</td>
<td>
[_val]
</td>
</tr>
[_while]
</table>
<table align="center">
<td>
<input class="input small" type="submit" value="Голосовать">
</td>
<td>
<div style="cursor:pointer;" onclick="document.getElementById('queRESULT').style.display = 'block';document.getElementById('queFORM').style.display = 'none';">
<input class="input small" type="button" value="Результаты">
</div>
</td>
</table>
</form>
</div>
<p>