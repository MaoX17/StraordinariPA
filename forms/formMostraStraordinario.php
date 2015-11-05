<div class="form-group">
	<label class="control-label" for="area">Seleziona area</label>
	<select name="area" class="form-control"  id="area">
		<?php
			$sql = "SELECT
					aree.id_area, aree.area, utenti.cognome_nome
					FROM
						aree
						INNER JOIN utenti on aree.id_dirigente = utenti.id_utente
						INNER JOIN ruoli on utenti.id_ruolo = ruoli.id_ruolo
					WHERE
						aree.abilitato = 'S'
						AND
						ruoli.ruolo = 'dirigente'
					ORDER BY aree.id_area";
			$rs = $db->query($sql);
			while ($row = $rs->fetchRow(MDB2_FETCHMODE_ASSOC))
			{
				$selected = "";
				if ($_SESSION['idArea'] == $row['id_area']) {
					$selected="selected";
				}
			?>
				<option value="<?= $row['id_area'] ?>" <?=$selected?> > <?=utf8_encode($row['area']) ?> <?=$row['cognome_nome'];?> </option>
			<?php

			} ?>

	</select>
</div>
	
<div class="form-group">
	<b>Data straordinario</b>
	<div class='input-group date' id="data_richiesta">
		<input type='text' class="form-control" name="data_richiesta" data-format="YYYY-MM-DD" required value="<?=$straordinario->getDataRichiesta()?>"/>
        <span class="input-group-addon">
			<span class="glyphicon glyphicon-time"></span>
        </span>
	</div>
</div>

<script type="text/javascript">
	$(function () {
    	$('#data_richiesta').datetimepicker({
        	pickTime: false,
            language:'it'
		});
	});
</script>

<div class="col-md-12">
	<div class="col-md-6">
		<div class="form-group">
			<b>Orario Inizio</b>
            <div class='input-group date' id='orainizio'>
            	<input type='text' class="form-control" name="ora_inizio" required  value="<?=$straordinario->getOraInizio()?>"/>
                <span class="input-group-addon">
					<span class="glyphicon glyphicon-time"></span>
                </span>
             </div>
        </div>
	</div>
    <script type="text/javascript">
    	$(function () {
        	$('#orainizio').datetimepicker({
            	pickDate: false,
            	language:'it'
			});
		});
	</script>
		
	<div class="col-md-6">
		<div class="form-group">
			<b>Orario fine</b>
            <div class='input-group date' id='orafine'>
            	<input type='text' class="form-control" name="ora_fine" required  value="<?=$straordinario->getOraFine()?>" />
                <span class="input-group-addon">
					<span class="glyphicon glyphicon-time"></span>
				</span>
            </div>
        </div>
	</div>
    <script type="text/javascript">
    	$(function () {
        	$('#orafine').datetimepicker({
            	pickDate: false,
            	language:'it'
			});
		});
	</script>
</div>
		
<div class="form-group" >
	<label class="control-label" for="motivazione">Motivazione</label>
	<input type="text" class="form-control" id="motivazione" name="motivazione" placeholder="Inserisci il motivo della richiesta straordinario" required  value="<?=$straordinario->getMotivazione()?>">
</div>

<?
$tmp = $straordinario->getPagamentoRecupero();

?>

<div class="form-group">
	<label class="control-label">Modalit&agrave; di recupero</label>
	<div class="radio">
		<label class="control-label" for="p">Pagamento</label>
    	<input type="radio" name="optrecupero" id="p" value="p">
	</div>
	<div class="radio">
		<label class="control-label" for="r">Recupero ore</label>
    	<input type="radio" name="optrecupero" id="r" value="r" checked >

	</div>
</div>



	 
			
