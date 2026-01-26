{literal}
<script type="text/javascript">
function toggleDiv(id,flagit) {
if (flagit=="1"){
if (document.layers) document.layers[''+id+''].visibility = "show"
else if (document.all) document.all[''+id+''].style.visibility = "visible"
else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "visible"
}
else
if (flagit=="0"){
if (document.layers) document.layers[''+id+''].visibility = "hide"
else if (document.all) document.all[''+id+''].style.visibility = "hidden"
else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "hidden"
}
}
</script>
<style type="text/css">#div1, #div2, #div3 {position:absolute; top: 100; left: 200; width:200; visibility:hidden}</style>
{/literal}

<a href="#" onMouseOver="toggleDiv('div1',1)" onMouseOut="toggleDiv('div1',0)">Link 1!</a> |

<a href="#" onMouseOver="toggleDiv('div2',1)" onMouseOut="toggleDiv('div2',0)">Link 2</a> |

<a href="#" onMouseOver="toggleDiv('div3',1)" onMouseOut="toggleDiv('div3',0)">Link 3</a>

<div id="div1">Link 1 text! I've restrained the div size to 200px wide in the style declaration. Modify this to suit yourself.</div>

<div id="div2">Link 2 text! You can add all the usual style options, and position it to suit yourself!</div>

<div id="div3">Link 3 text! Use it to explain terms or further describe your linked pages, whatever!</div>
