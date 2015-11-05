<?php
/**
 * Created by PhpStorm.
 * User: mproietti
 * Date: 04/04/14
 * Time: 12.50
 */
?>

<div class="table-responsive">

	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Data</th>
				<th>Ora inizio</th>
				<th>Ora fine</th>
				<th>Motivazione</th>
				<th>Pagamento/Recupero</th>
				<th>Approvato (S/N)</th>
				<th>Data approvazione</th>
				<th>Area</th>
			</tr>
		</thead>
	<tbody>
		<tr>
			<td><a href='<?=$percorso_relativo?>modifica.php?id=<?=$straordinario->getIdStraordinario()?>'> <?=$straordinario->getDataRichiesta()?> </a> </td>
			<td> <?=$straordinario->getOraInizio()?> </td>
			<td> <?=$straordinario->getOraFine()?></td>
			<td> <?=$straordinario->getMotivazione()?></td>
			<td> <?=($straordinario->getPagamentoRecupero()=="p")?"Pagamento":"Recupero"?></td>
			<td> <?=$straordinario->getApprovato()==""?"In Attesa":$straordinario->getApprovato()?></td>
			<td> <?=($straordinario->getDataApprovazione()=="0000-00-00" OR $straordinario->getDataApprovazione()=="")?"In Attesa":$straordinario->getDataApprovazione()?></td>
			<td> <?=$straordinario->getObjArea()->getArea()?></td>
		</tr>
	</tbody>
	</table>

</div>

<!-- Colori per riga tr class= $class='warning, danger, success' -->