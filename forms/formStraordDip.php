	<div class="form-group">
		<label class="col-md-4 control-label" for="inputTel">Area di appartenenza</label>
			<div class="col-md-8">
				<input type="text" id="inputTel" class="form-control"  value="<?= $row['area'] ?>" name="<?=$row['id_area'] ?>" readonly="readonly"><br>
			</div>
	</div>
	
		<div class="col-md-12">
		<div class="col-md-4">
            <div class="form-group">
   				<b>DATA straordinario</b>       
                <div class='input-group date' id="data_richiesta">
                    <input type='text' class="form-control" name="data_richiesta" data-format="YYYY/MM/DD" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
            </div>
        </div>
        
        <script type="text/javascript">
            $(function () {
                $('#data_richiesta').datetimepicker({
                	datetimepicker.attr('readonly','readonly');
                    pickTime: false,
            		language:'it'             	
                });
            });
        </script>

        
        <div class="col-md-4">
		<div class="form-group">
		<b>ORA INIZIO</b>
                <div class='input-group date' id='orainizio'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
        </div>
        
        </div>
        <script type="text/javascript">
            $(function () {
                $('#orainizio').datetimepicker({
                	datetimepicker.attr('readonly','readonly');
                    pickDate: false,
            		language:'it'   
                });
            });
        </script>
		
		<div class="col-md-4">
		<div class="form-group">
		<b>ORA FINE</b>
            <div class='input-group date' id='orafine'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
            </div>
        </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#orafine').datetimepicker({
                	datetimepicker.attr('readonly','readonly');
                    pickDate: false,
            		language:'it'   
                });
            });
        </script>
        </div>
		
		<div class="form-group" >
			<!--  <label class="control-label" for="inputMotivazione">Motivazione</label> -->
			<!-- <div class="col-md-8">  -->
			<b>Motivazione</b>
				<textarea class="form-control" id="motivazione" name="motivazione" rows="7" readonly="readonly"></textarea>
			<!-- </div> -->
		</div>
	
		<div class="radio">
  			<label>
    			<input type="radio" name="optionsRadios" id="p" value="p">
    				<b>Pagamento</b>
 			 </label>
		</div>
		<div class="radio">
  			<label>
    			<input type="radio" name="optionsRadios" id="r" value="r">
   					 <b>Recupero</b>
  			</label>
		</div><br>
				<div class="radio">
  			<label>
    			<input type="radio" name="optionsRadios" id="p" value="p">
    				<b>Approva</b>
 			 </label>
		</div>
		<div class="radio">
  			<label>
    			<input type="radio" name="optionsRadios" id="r" value="r">
   					 <b>Non approva</b>
  			</label>
		</div>


	 
			
