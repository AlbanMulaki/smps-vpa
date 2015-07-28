@extends('printa4v')

@section('content')

<p>
	<span style="text-transform:uppercase;">
	Zyra për sigurimin e cilësisë
	</span>
</p>
<p>
	<span style="text-transform:uppercase;">
Pyetësor për personelin akademik
	</span>
</p>
<br><br>
<p>
Në këtë pyetësor duhet të marrin pjesë të gjith mësimdhënësit e <b>Kolegjit universitar "VPA"</b>Pyetësori është formuluar me qëillim që të mblidhen pikëpamjet e personelit akademik të kolegjit universitar "VPA" për cshtje që kanë të bëjnë me cilësin e punës së tyre, punë së administratës, dekanateve, rektoratit dhe punës së universitetit në tërësi. Përgjigjet tuaja janë shumë të rëndësishme për ne, dhe sidomos të rëndësishme janë edhe sygjerimet për përmirësime, ndryshime apo implementime të ndryshme që do të mundësojn një ngritje të cilësisë së përgjithsme.<br><br>
Përgjigjet e grumbulluara nga ju do të shërbejnë në planifikimin e zhvillimit strategjik të universiteti, në organizimet e brendshme, në hartimin apo përmirësimet në rregullore të ndryshme, në mbështetjen e stafit akademik për hulumtime dhe mbështetje në përgjithësi, me qëllim t ngritjes së cilësisë së punës dhe mbarvajtjes akademike në universitetin tonë. 
</p>
<br>
<span style="text-transform:uppercase;">
<b>Të gjithë ata që plotësojn këtë pyetësor, do të mbeten plotësisht anonimë</b>
</span>
<br><br>
Udhezim:<br>
Secilës pyetje duhet t'i përgjigjeni duke rrumbullakësuar njërën nga përgjigjet e mundshme

<br><br>
Të gjitha pyetjet duhet të plotësohen
@foreach($questions as $value)
<p><b> {{$i++}} {{$value['question']}}</b></p><br>
	<table style="width:100%;">
		<tr>
			<td><input type="radio">[ ] Pajtohem plotësisht</td>
			<td><input type="checkbox">[ ] Pajtohem</td>
			<td><input type="checkbox">[ ] Neutral</td>
			<td><input type="checkbox">[ ] Nuk pajtohem</td>
			<td><input type="checkbox">[ ] Nuk pajtohem aspak</td>
		</tr>
	</table><br><hr>
@endforeach
@stop