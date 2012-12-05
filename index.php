<?php include "config.php"; ?>
<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Wahrheitstafeln generieren</title>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.snippet.min.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.snippet.min.js"></script>
<script type="text/javascript" src="js/sh_latex.min.js"></script>
<script type="text/javascript" src="js/logparser.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#help").accordion({collapsible:true,active: false,heightStyle: "content"});
	$("#output").accordion({collapsible:true,active:1,heightStyle: "content"});
	$("pre.latex").snippet("latex",{style:"rand01",showNum:false});
	$('.snippet-text').off('click');
	$(".snippet-text").click(function(){SelectText('latex');});
});

</script>
</head>
<body>
<div id="container" class="ui-widget">
<h2>Wahrheitstafel generieren</h2>
Hier kannst du für eine logische Formel eine Wahrheitstabelle berechnen lassen.<br/>
<div class="accordion" id="help">
	<h3>Eingabesyntax</h3>
	<div>
	Als Alphabet sind [A-Za-z] zulässig.<br/>
	Desweiteren sind die Ausdrücke VER für verum und FAL für falsum verfügbar.<br/>
	Die Eingabe erfolgt Infix und mit folgender Syntax.<br/>
	<table class="exp">
	<tr><td>Operation</td><td>"Normale" Syntax</td><td>"Eingabe"-Syntax</td><td>Gatter-Typ</td></tr>
	<tr><td>Negation</td><td>&not;p</td><td>~p</td><td>NOT</td></tr>
	<tr><td>Konjunktion (Und)</td><td>p&and;q</td><td>p&amp;q</td><td>AND</td></tr>
	<tr><td>Disjunktion (Oder)</td><td>p&or;q</td><td>p+q</td><td>OR</td></tr>
	<tr><td>Implikation</td><td>p&rarr;q</td><td>p-&gt;q</td><td></td></tr>
	<tr><td>Äquivalenz</td><td>p&harr;q</td><td>p&lt;-&gt;q</td><td>XNOR</td></tr>
	<tr><td>Antivalenz (Ex. Oder)</td><td>p&oplus;q</td><td>p?q</td><td>XOR</td></tr>
	<tr><td>Sheffer-Funktion</td><td>p|q</td><td>p|q</td><td>NAND</td></tr>
	<tr><td>Peirce-Funktion</td><td>p&darr;q</td><td>p!q</td><td>NOR</td></tr>
	<tr><td>Tautologie (verum)</td><td>&#x22a4;</td><td>VER</td><td></td></tr>
	<tr><td>Kontradiktion (falsum)</td><td>&perp;</td><td>FAL</td><td></td></tr>
	</table>
	So wird Beispielsweise aus &not;(p&rarr;(p&and;q))&harr;p&or;q einfach <a href="<?php echo htmlspecialchars ($_SERVER['PHP_SELF']); echo "?log=".urlencode("~(p->(p&q))<->p+q")?>">~(p->(p&amp;q))&lt;-&gt;p+q</a>.
	</div>
	<h3>Ausgabeoptionen</h3>
	<div>
	Es gibt zwei Modi für die Operatorpriorität:
	<ul>
	<li>Theoretisch: Negation prior zu Konjunktion und Disjunktion prior zu Rest</li>
	<li>Technisch: Negation prior zu Konjunktion prior zu Restlichen Operatoren</li>
	</ul>
	Der Unterschied zwischen beiden kann einfach an folgender Formel nachvollzogen werden:<br/>
	<a href="<?php echo htmlspecialchars ($_SERVER['PHP_SELF']); ?>?log=p%2Bq%26p">p&or;q&and;p</a><br/><br/>
	Um den Latexoutput zu nutzen, musst du <code>\usepackage[table]{xcolor}</code> benutzen. Du kannst wahlweise eine Minimaldokument ausgeben.<br/>
	Es gibt jetzt auch zwei unterschiedliche Tabellentypen:
	<table class="exp">
	<tr><td></td><td>Standard</td><td>Latex</td></tr>
	<tr><td>Tabelle 1</td><td><img src="img/tab1std.png"/></td><td><img src="img/tab1lat.png"/></td></tr>
	<tr><td>Tabelle 2</td><td><img src="img/tab2std.png"/></td><td><img src="img/tab2lat.png"/></td></tr>
	</table>
	</div>
	<h3>Funktionsweise/Kontakt/GitHub</h3>
	<div>
	Mit Hilfe des <a href="https://en.wikipedia.org/wiki/Shunting-yard_algorithm">Shunting-yard Algorithmus</a> wird die Infixe Eingabe in eine Postfixe umgewandelt. Danach wird die Aussage interpretiert. Keine Magie also.<br/>
	Der Quellcode ist auf <a href="https://github.com/leipert/logparser">GitHub</a> zu finden. <br/>
	Solltet ihr einen Fehler finden, meldet ihn doch: <a href="mailto:<?php echo $email; ?>?<? echo "subject=".urlencode("Bugreport Logparser")."&body=".urlencode("Hallo ".$name.",\nich habe folgende Fehlerhafte Formel:\n\n".$_GET["log"]."\n\nentdeckt.\nWeitere Kommentare:\n\n");?>"><?php echo $email; ?></a> <br/>
	Oder noch besser, ihr helft direkt:
	<div id="github">
	<iframe src="http://ghbtns.com/github-btn.html?user=leipert&amp;repo=logparser&amp;type=fork&amp;count=true" frameborder="0" scrolling="NO" width="95" height="20"></iframe>
	</div>
	</div>
</div>

<?php
$ww=array("checked='checked'","");
$tm=array("checked='checked'","");
$filter=array("checked='checked'","","");
$opp=array("checked='checked'","");
$doc=array("checked='checked'","");
$mod=true;
if(isset($_GET['ww'])){if($_GET['ww']==1){$ww=array("","checked='checked'");}}
if(isset($_GET['tm'])){if($_GET['tm']==1){$tm=array("","checked='checked'");$mod=false;}}
if(isset($_GET['opp'])){if($_GET['opp']==1){$opp=array("","checked='checked'");}}
if(isset($_GET['doc'])){if($_GET['doc']==1){$doc=array("","checked='checked'");}}
if(isset($_GET['filter'])){
if($_GET['filter']==1){$filter=array("","checked='checked'","");}
elseif($_GET['filter']==2){$filter=array("","","checked='checked'");}
}
?>

<form action="<?php echo htmlspecialchars ($_SERVER['PHP_SELF']); ?>" method="get">
<p>
<input name="log" value="<?if(isset($_GET['log'])){echo htmlspecialchars($_GET['log']);}?>"/>
<input type="submit" value="Wahrheitstafel generieren"/><br/></p>
<h4>Optionen</h4>
<ul>
<li>Wahrheitswerte: 
<input type="radio" name="ww" value="0" <?php echo $ww[0];?>/> W&amp;F
<input type="radio" name="ww" value="1" <?php echo $ww[1];?>/> 1&amp;0
</li>
<li>Operatorenpriorität: 
<input type="radio" name="opp" value="0" <?php echo $opp[0];?>/> Theoretisch
<input type="radio" name="opp" value="1" <?php echo $opp[1];?>/> Technisch
</li><li>Filtere Zeilen: 
<input type="radio" name="filter" value="0" <?php echo $filter[0];?>/> Beide
<input type="radio" name="filter" value="1" <?php echo $filter[1];?>/> WAHR
<input type="radio" name="filter" value="2" <?php echo $filter[2];?>/> FALSCH
</li><li>Latex:
<input type="radio" name="doc" value="0" <?php echo $doc[0];?>/> Zeige nur Tabelle
<input type="radio" name="doc" value="1" <?php echo $doc[1];?>/> Zeige Minimaldokument
</li>
<li>Tabellenaussehen:
<input type="radio" name="tm" value="0" <?php echo $tm[0];?>/> Tabelle 1
<input type="radio" name="tm" value="1" <?php echo $tm[1];?>/> Tabelle 2
</li>
</ul>
</form>
<?php
$ww=array();
$ww[TRUE]="W";$ww[FALSE]="F";

if(isset($_GET['ww'])){if($_GET['ww']==1){$ww[TRUE]="1";$ww[FALSE]="0";}}
$alphabet=ARRAY("%","$","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
$operators=ARRAY("~","&","+",">","<","=","?","|","!");
$asso=ARRAY("~"=>"R","&"=>"L","+"=>"L",">"=>"R","<"=>"R","="=>"R","?"=>"L","|"=>"L","!"=>"L");
$pre=ARRAY("~"=>"3","&"=>"2","+"=>"2",">"=>"1","<"=>"1","="=>"1","?"=>"1","|"=>"1","!"=>"1");
if(isset($_GET['opp'])){if($_GET['opp']==1){$pre["+"]=1;}}
if(isset($_GET['log'])){
if($_GET['log']!=""){
$f=$_GET['log'];
$f=preg_replace("/<->/","=",$f);
$f=preg_replace("/->/",">",$f);
$f=preg_replace("/<-/","<",$f);
$f=preg_replace("/VER/","%",$f);
$f=preg_replace("/FAL/","$",$f);
echo "Deine Eingabe: ".getLogOperator($f).'<br/>';
$arr = str_split($f);
$stack=array();
$r=0;
$c=-1;
$table=array();
foreach($arr as $token){
	$c++;
	if(in_array($token,$alphabet)){
		$output[]=Array($token,$c);
		if($token!="%"&&$token!="$"){$letters[]=$token;}
	}else if(in_array($token,$operators)){
			if(count($stack)>0){
			if(in_array($stack[0][0],$operators)){
				if(($asso[$token]=="L"&&$pre[$token]<=$pre[$stack[0][0]])||($pre[$token]<$pre[$stack[0][0]])){
					$output[]=array_shift($stack);
				}
			}
			}
			array_unshift($stack,Array($token,$c));
	}
	if($token=="("){
		array_unshift($stack,Array($token,$c));
	}
	if($token==")"){
		while(count($stack)>0){
		if($stack[0][0]!="("){
		$output[]=array_shift($stack);
		} else {
		array_shift($stack);
		break;
		}
		}
	}
}
foreach($stack as $la){
if($la[0]=="("||$la[0]==")"){exit("Klammerfehler! Bitte überprüfe deine Formel.");}
$output[]=array_shift($stack);
}
$letters = array_unique($letters);
sort($letters);
$b=array("%"=>TRUE,"$"=>FALSE);
$test="";
foreach($output as $la){
$test.=$la[0];
}
for($i=0;$i<count($arr);$i++){
$remove[$i]=false;
if($i>0){
if($arr[$i]=="("||$arr[$i]==")"){
if($arr[$i]==substr($arr[$i-1],0,1)){
$arr[$i].=$arr[$i-1];
$arr[$i-1]="";
$remove[$i-1]=true;
}}}
}
if(count($letters)>7){exit("Gib bitte eine Formel mit höchstens sieben Parametern an.");}
$tablecode="";$cols="";$th="";
$tables = goThrough($letters,$output,$b,count($arr));
foreach($letters as $token){
$tablecode.= "<th class='right'>".getLogOperator($token)."</th>";
$cols.="c|";
$th.=$token."&amp;";
} 
$replace=Array();
if($mod){
foreach($arr as $token){
if($token!=""){
$tablecode.= "<th>".getLogOperator($token)."</th>";
$cols.="c";
$th.=getLatexOperator($token,false)."&amp;";
}
}}else{
$klik=Array();
foreach($tables[3] as $key=>$token){
if($token[0]!="~"){
if(isset($klik[$token[1]])){$token[1]="(".$klik[$token[1]].")";}else{$token[1]=$arr[$token[1]];}
if(isset($klik[$token[2]])){$token[2]="(".$klik[$token[2]].")";}else{$token[2]=$arr[$token[2]];}
$klik[$key]=$token[1]." ".$token[0]." ".$token[2];
}else{
if(isset($klik[$token[1]])){$token[1]=$klik[$token[1]];}else{$token[1]=$arr[$token[1]];}
$klik[$key]=$token[0]." ".$token[1]."}";
}
}
$done=Array();
foreach($klik as $key=>$token){
if(!in_array($token,$done)){
$tablecode .= "<th class='right'>".getLogOperator($token)."</th>";
$cols.="|c";
$th.=getLatexOperator($token,true)."&amp;";
$done[]=$token;
}else{
$replace[$key]="";
}
}
}
$th = substr($th, 0, -5)."\\\\";
$latexcode="
\[
 \begin{array}{".$cols."}
  ".$th."
  \hline\hline";
foreach($tables[0] as $row){
if($mod){$row=array_replace($row,$replace);}
$latexcode .= implode("",$row);
}
$latexcode .= "
 \\end{array}
\]";
if($doc[1]=="checked='checked'"){$latexcode="\documentclass[10pt,a4paper]{article}
\usepackage[german]{babel}
\usepackage[T1]{fontenc}
\usepackage[utf8]{inputenc}
\usepackage[table]{xcolor}
\begin{document}".$latexcode."
\\end{document}";}
echo "Postfixnotation deiner Eingabe: ".getLogOperator($test)."<br/>";
echo "<div class='accordion' id='output'> <h3>Latexcode</h3><div><pre id='latex' class='latex'>";
echo $latexcode;
echo "</pre></div><h3>Standardausgabe</h3><div><table><tr class='first'>";
echo $tablecode."</tr>";
foreach($tables[1] as $row){
if($mod){$row=array_replace($row,$replace);}
echo implode("",$row);
}
echo "</table></div></div>";
}}



function getLogOperator($s){
$normal=ARRAY("/&/","/\~/","/\+/","/>/","/</","/=/","/\?/","/!/","/%/","/\\$/","/\}/","/ /");
$replace=ARRAY("&and;","&not;","&or;","&rarr;","&larr;","&harr;","&oplus;","&darr;","&#x22a4;","&perp;"," ","");
return preg_replace($normal,$replace,$s);
}
function getLatexOperator($s,$overline){
$normal=ARRAY("/&/","/\~/","/\+/","/>/","/</","/=/","/\?/","/!/","/%/","/\\$/","/\}/");
$replace=ARRAY("\wedge","\\neg","\\vee","\\rightarrow","\leftarrow","\leftrightarrow","\oplus","\downarrow","\\top","\perp","");
if($overline){
$replace[1]="\overline{";
array_pop($normal);array_pop($replace);
}
return preg_replace($normal,$replace,$s);
}

function goThrough($letters,$output,$b,$count){
$c=array_shift($letters);
if(count($letters)>=1){
$b[$c]=FALSE;
$ret = goThrough($letters,$output,$b,$count);
$echo[0]=$ret[0];
$echo[1]=$ret[1];
$echo[2]=$ret[2];
$echo[3]=$ret[3];
$b[$c]=TRUE;
$ret = goThrough($letters,$output,$b,$count);
$echo[0]=array_merge($echo[0],$ret[0]);
$echo[1]=array_merge($echo[1],$ret[1]);
$echo[2]=$ret[2];
$echo[3]=$ret[3];
}else{
$b[$c]=FALSE;
$ret = printrow(tablerow($output,$b),$b,$count);
$echo[0][]=$ret[0];
$echo[1][]=$ret[1];
$echo[2]=$ret[2];
$echo[3]=$ret[3];
$b[$c]=TRUE;
$ret = printrow(tablerow($output,$b),$b,$count);
$echo[0][]=$ret[0];
$echo[1][]=$ret[1];
$echo[2]=$ret[2];
$echo[3]=$ret[3];
}
return $echo;
}

function printrow($r,$b,$count){
global $filter,$ww,$remove,$mod;
$echo=Array();
$echo[1]=Array();$echo[0]=Array();
$val=$r[end($r["e"])];
if($filter[0]=="checked='checked'"||($filter[1]=="checked='checked'"&&$val)||($filter[2]=="checked='checked'"&&!$val)){
$echo[1][] = "<tr>";$echo[0][]="\n  ";
foreach($b as $key=>$token){
if($key!="%"&&$key!="$"){
$echo[1]["0".$key] = "<td class='right'>".$ww[$token]."</td>";
$echo[0]["0".$key] = $ww[$token]."&amp;";
}}
if($mod){
for($i=0;$i<$count;$i++){
$key=$i;
if($i==0){$key="b";}
if (isset($r[$i])){
$class="";
$latex=$ww[$r[$i]]."&amp;";
if($i==end($r["e"])){
$class="class='last'";
$latex='\multicolumn{1}{|c|}{\cellcolor[gray]{0.8}\mathbf{'.$ww[$r[$i]].'}}&amp;';
}
$echo[0][$key] = $latex;
$echo[1][$key] = "<td $class>".$ww[$r[$i]]."</td>";
}else{
if(!$remove[$i]){
$echo[0][$key] = "&amp;";
$echo[1][$key] = "<td class='small'></td>";}
}
}
array_pop($echo[0]);
$echo[0][]= "\\\\";
$echo[1][]= "</tr>";
}else{
foreach($r["a"] as $key=>$token){
$class="class='right'";
$latex=$ww[$r[$key]]."&amp;";
if($key==end($r["e"])){
$class="class='last'";
$latex='\multicolumn{1}{|c|}{\cellcolor[gray]{0.8}\mathbf{'.$ww[$r[$key]].'}}';
}
$echo[0][$key]= $latex;
$echo[1][$key]= "<td $class>".$ww[$r[$key]]."</td>";
}
//array_pop($echo[0]);
$echo[0][]= "\\\\";
$echo[1][]= "</tr>";
}
$echo[2]=$r["e"];
$echo[3]=$r["a"];
return $echo;
}else{
return array("","","");
}
}


function tablerow($output,$bed){
global $alphabet;
$k["e"]=Array();
$k["a"]=Array();
$stack=array();$k=Array();$r="";
foreach($output as $token){
	$c=$token[1];
	if(in_array($token[0] ,$alphabet)){
	$token[0]=$bed[$token[0]];
	array_unshift($stack,$token);
	$k[$token[1]]=$token[0];
	}else{
	if($token[0]=="~"){
	$aa=array_shift($stack);
	$b=$aa[0];
	$r=!$b;
	$k[$c]=$r;
	$arr=Array($token[0],$aa[1]);
	$k["a"][$token[1]]=$arr;
	$k["e"][]=$c;
	array_unshift($stack,Array($r,$c));
	}else{
	$ab=array_shift($stack);
	$aa=array_shift($stack);
	$b=$ab[0];
	$a=$aa[0];
	$c=$token[1];
	$arr=Array($token[0],$aa[1],$ab[1]);
	if($token[0]=="&"){$r=$a&&$b;}
	if($token[0]=="+"){$r=$a||$b;}
	if($token[0]==">"){$r=(!$a||$b);}
	if($token[0]=="<"){$r=($a||!$b);}
	if($token[0]=="="){$r=(($a&&$b)||(!$a&&!$b));}
	if($token[0]=="?"){$r=((!$a&&$b)||($a&&!$b));}
	if($token[0]=="|"){$r=!($a&&$b);}
	if($token[0]=="!"){$r=!($a||$b);}
	$k[$c]=$r;
	if($token[0]=="("){
	unset($k[$c]);
	}else{
	$k["e"][]=$c;
	$k["a"][$token[1]]=$arr;
	}
	array_unshift($stack,Array($r,$c));
	}}
}
//$k["e"]=$c;
ksort($k);
//var_dump($k);
//echo '<br/>'.'<br/>';
return ($k);
}

?>
<p>
<a href="#" onclick="impressum()">Impressum</a>
    <a href="http://validator.w3.org/check?uri=referer"><img
      src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
</p>
</div>
</body>
</html>
