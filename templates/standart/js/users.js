function footer()
{
	var windowH = $(window).height();//определяем высоту рабочей области
	var tableH = $(".table").height();//определяем высоту главной таблицы
	if(windowH < tableH)document.getElementById("img_right_bottom").style.top = (tableH-20)+"px";
	else document.getElementById("img_right_bottom").style.top = (windowH-20)+"px";
	document.getElementById("img_right_bottom").style.display = "block";
}
//--------------------------------------
window.onload = function()
{
footer();
}
//--------------------------------------
function galery(title,txt,link,step)
{
var scroll_window = $("html,body").scrollTop();//определяем позицию скролла всех браузеров кроме гугла
if(scroll_window == 0)scroll_window = $("body").scrollTop();//определяем позицию скролла у гугл хрома
scroll_window += 50;
if(step == 0)
{
	document.getElementById('bigimggal').innerHTML = "<img src='"+link+"' border='0'>";
	document.getElementById('titlegal').innerHTML = title;
	document.getElementById('txtgal').innerHTML = txt;
	document.getElementById('galeryBIG').style.top = scroll_window+"px";
	$("#bggal").fadeTo(500,0.5);
	$("#galeryBIG").fadeTo(500,1.0);
}
else
{
	$("#galeryBIG").fadeOut(500,0.0,function(){document.getElementById('galeryBIG').style.display = "none";});
	$("#bggal").fadeOut(500,0.0,function(){document.getElementById('bggal').style.display = "none";});
}
}
//--------------------------------------
function capcha(v,val)
{
document.getElementById("code_comm").value = "";
	for(var i=1;i<=4;i++)document.getElementById("cp"+i+"OK").style.display = "none";
	
	document.getElementById("cp"+v+"OK").style.display = "block";
	document.getElementById("code_comm").value = val;	
}
//--------------------------------------
function reqcomm(id,author,step)
{
	if(step == 0)
	{
		document.getElementById("recomm").value = id;
		document.getElementById("reauthor").innerHTML = author;
		document.getElementById("messFROM").style.display = "block";
		jQuery.scrollTo('#messFROM',1000);
	}
	if(step == 1)
	{
		document.getElementById("recomm").value = id;
		document.getElementById("reauthor").innerHTML = author;
		document.getElementById("messFROM").style.display = "none";
	}
	footer();
}
//--------------------------------------
function reader(el,step)
{
	if(step == 0)$("#"+el).animate({marginLeft:"5px"},100);
	if(step == 1)$("#"+el).animate({marginLeft:"20px"},100);
}
