<script type="text/javascript">
   $(document).ready(function(){
       var today=new Date();
      // alert(today);
      // alert(today.getMonth()+1);
       var today_str = today.getFullYear()+"-"+(today.getMonth()+1)+"-"+today.getDate();
      // alert(today.getMonth());
       if ($('input[name="data_richiesta"]').val()=="") {
            $('input[name="data_richiesta"]').val(today_str);
       }

       $("#myForm").submit(function(event){
           var myDate=new Date();

          myDate.setMonth(myDate.getMonth()-1);
          //  alert (myDate.getMonth());
           $('input[name="data_richiesta"]').prop('disabled', false);
           if ((new Date($('input[name="data_richiesta"]').val()) < myDate) || ($('input[name="data_richiesta"]').val()=="")){
             alert('ERRORE: DATA non valida');
             $('input[name="data_richiesta"]').prop('disabled', true);
				event.preventDefault(); //blocca l'invio del form
                return false;
			    //return true;
           }
           var data1=$('#orainizio > input[name="ora_inizio"]');
           var data2=$('#orafine > input[name="ora_fine"]');

           data1.prop('disabled', false);
           data2.prop('disabled', false);

           if(data2.val() <= data1.val() && data2.val()!="" && data1.val()!="")  {
               alert('ERRORE: controlla gli ORARI inseriti');
               data1.prop('disabled', true);
               data2.prop('disabled', true);
               $('input[name="data_richiesta"]').prop('disabled', true);
               event.preventDefault();
           }
       })
   })


</script>


<div class="form-group">
	<label class="control-label" for="area">Seleziona area</label>
	<select name="area" class="form-control"  id="area" required>
        <option value=""> </option>
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
        echo $sql;
        echo $_SESSION['idArea'];

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
	<b>Data straordinario</b>  <small>CLICCARE SULLE RELATIVE ICONE PER INSERIRE DATA/ORA</small>
	<div class='input-group date' id="data_richiesta">
		<input type='text' class="form-control" disabled name="data_richiesta" data-format="YYYY-MM-DD" required value="<?=$straordinario->getDataRichiesta()?>"/>
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
            	<input type='text' class="form-control" name="ora_inizio" required disabled value="<?=$straordinario->getOraInizio()?>"/>
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
            	<input type='text' class="form-control" name="ora_fine" required disabled value="<?=$straordinario->getOraFine()?>"  />
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
if ($tmp == "r") {
	$chr = "checked";
	$chp = "";
}
elseif ($tmp == "p") {
	$chp = "checked";
	$chr = "";
}
else {
	$chr = "checked";
	$chp = "";
}
?>

<div class="form-group">
	<label class="control-label">Modalit&agrave; di recupero</label>
	<div class="radio">
		<label class="control-label" for="p">Pagamento</label>
    	<input type="radio" name="optrecupero" id="p" value="p" <?=$chp?>>
	</div>
	<div class="radio">
		<label class="control-label" for="r">Recupero ore</label>
    	<input type="radio" name="optrecupero" id="r" value="r" <?=$chr?> >

	</div>
</div>

<input type="hidden" name="id_straordinario" value="<?=$straordinario->getIdStraordinario()?>" >

	 
			
