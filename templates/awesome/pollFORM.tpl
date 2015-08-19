
	        <table width="100%"><tr><td class="menu">[_qu]</td></tr></table><br>
	    <form id="f_poll" action="index.php" method="post" name="f_poll">
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
            <div style="padding-right: 8px; padding-top: 8px;" align="right">
			<input class="vote_do" title="Голосовать" type="submit" />
			<div style="padding-right: 8px; padding-top: 4px;" align="right" > <a onclick="document.getElementById('queRESULT').style.display = 'block';document.getElementById('queFORM').style.display = 'none';">Результаты голосования</a> </div>
			</div>
        </form>