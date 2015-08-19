function open_mess(id)
{
	var IDmess = document.getElementById("mess_"+id);
	if(IDmess.style.display == "none")IDmess.style.display = "block";
	else IDmess.style.display = "none";
}
//------------------------------------------
function selectCHBOX()
{
	for(var i=list;document.getElementById("checkbox_"+i);i++)
	{
		if(document.getElementById("checkbox_"+i).checked == false) document.getElementById("checkbox_"+i).checked = true;
		else document.getElementById("checkbox_"+i).checked = false;
	}
	if(document.getElementById("divSELall").innerHTML == "Выделить все файлы") document.getElementById("divSELall").innerHTML = "Снять выделение"
	else document.getElementById("divSELall").innerHTML = "Выделить все файлы"
}
//------------------------------------------
function selectPOST(link,step)
{
	if(step == 'edd')document.getElementById('href_p').value = link;
	if(step == 'add')document.getElementById('addhref_p').value = link;
}

function ajax_blog(step)
{
	if(step == "add")var link = "admin.php?page=ajax_post_add";
	if(step == "edd")var link = "admin.php?page=ajax_post_edd";
                $.ajax({
                        type: "GET",
                        url: link,
                        cache: false,
                        success: function(list)
							{
								document.getElementById("listmenu").style.display = "block";
								document.getElementById("sublistmenu").style.display = "none";
								document.getElementById("listmenu").innerHTML = list;
							}
                });

}
//------------------------------------------------------
function open_new_window(url,width,height)
{
	windowVar=window.open(url,"", "width="+width+",height="+height+ 
	",status=no,toolbar=no,menubar=no,directories=no,location=no,resizable=yes,scrollbars=yes");
}