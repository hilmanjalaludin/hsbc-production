<script>


/**
 * Enigma User Interface
 *
 * An open source application development framework for Web 2.0 or newer
 *
 * @package		Enigma User Interface *.js
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2017, razaki, Inc.
 * @license		http://razakitechnology.com/user_guide/license.html
 * @link		http://razakitechnology.com
 * @since		Version 1.3.20
 * @filesource
 */
 
 // ----------------------------------------------------------------------------------------
 
 /**
  * [_getDetailCustomer description]
  * @param  [type] $CustomerId [description]
  * @return [type]             [@overider]
  */
  
  	
Ext.DOM.getLoan = function(val){
	
	var CustomerId = Ext.Cmp('CustomerId').getValue(),
	    protectData = Ext.EventUrl( new Array('ProductInfoPilx','getLoanPerVariable') );
	  
// please overider by spiner plugin dont event by ext.Ajax 
// cause have the "bugs ", load not perfected .
// will be cache not clear .
	  
	  $('#loans').Spiner ({
		  
		 url  	: protectData.Apply(),
		 method : 'GET',
		 param 	: {
				loansvar : val, 
				CustomerId:CustomerId
		 },
		 complete : function( protectedHtml ){
			$( protectedHtml ).css({ "height" : "100%" });
				// this must be selector replace by html 
				// class jQuery.  
		 }
	  });	
	   
	}
 /**
  * [_getDetailCustomer description]
  * @param  [type] $CustomerId [description]
  * @return [type]             [@overider]
  */
	Ext.DOM.IncomingColSet = function (){
		var incomecol = Ext.Cmp('incomecol').getValue();
		console.log( window.sprintf("incomecol : %s ...", incomecol));
		
		if(incomecol=="Belum Ada Income Doc"){
			Ext.Cmp('incomecol_yn').disabled(false);
			Ext.Cmp('incomecol_tp').disabled(true);
			Ext.Cmp('incomecol_tp_rng').disabled(true);
			Ext.Cmp('incomecol_tp_fix').disabled(true);
		}else{
			Ext.Cmp('incomecol_yn').disabled(true);
			Ext.Cmp('incomecol_tp').disabled(true);
			Ext.Cmp('incomecol_tp_rng').disabled(true);
			Ext.Cmp('incomecol_tp_fix').disabled(true);
		}
	}
 /**
  * [_getDetailCustomer description]
  * @param  [type] $CustomerId [description]
  * @return [type]             [@overider]
  */	
	Ext.DOM.IncomingCol = function(){
		var incomecol = Ext.Cmp('incomecol_yn').getValue();
			console.log( window.sprintf("incomecol_yn : %s", incomecol) );
			
		if(incomecol == "Y"){
			Ext.Cmp('incomecol_tp').disabled(false);
			Ext.Cmp('incomecol_tp_rng').disabled(true);
			Ext.Cmp('incomecol_tp_fix').disabled(true);
		}else if(incomecol == "N"){
			Ext.Cmp('incomecol_tp').disabled(true);
			Ext.Cmp('incomecol_tp_rng').disabled(true);
			Ext.Cmp('incomecol_tp_fix').disabled(true);
			Ext.Cmp('incomecol_tp').setValue('');
			Ext.Cmp('incomecol_tp_rng').setValue('');
			Ext.Cmp('incomecol_tp_fix').setValue('');
		}
	}
 /**
  * [_getDetailCustomer description]
  * @param  [type] $CustomerId [description]
  * @return [type]             [@overider]
  */	
	Ext.DOM.IncomingType = function(){
		var incomingtype = Ext.Cmp('incomecol_tp').getValue();
		if(incomingtype=="Fix"){
			Ext.Cmp('incomecol_tp_rng').disabled(true);
			Ext.Cmp('incomecol_tp_fix').disabled(false);
			Ext.Cmp('incomecol_tp_rng').setValue('');
		}else if(incomingtype=="Range"){
			Ext.Cmp('incomecol_tp_rng').disabled(false);
			Ext.Cmp('incomecol_tp_fix').disabled(true);
			Ext.Cmp('incomecol_tp_fix').setValue('');
		}
	}
 /**
  * [_getDetailCustomer description]
  * @param  [type] $CustomerId [description]
  * @return [type]             [@overider]
  */	
Ext.DOM.CashbackSet = function () {
	var cashback = Ext.Cmp('cashback').getValue();
	
	console.log( window.sprintf("CashbackSet value : %s", cashback ));
	if( cashback =='YES' ){
		Ext.Cmp('cashback_yn').disabled(false);
	}else{
		Ext.Cmp('cashback_yn').disabled(true);
	}
}

 /**
  * [_getDetailCustomer description]
  * @param  [type] $CustomerId [description]
  * @return [type]             [@overider]
  */	
	Ext.DOM.IncomeDocSet = function (){
		var cashback = Ext.Cmp('cashback').getValue();
		console.log( cashback );
		
		if(cashback=="YES"){
			Ext.Cmp('incomedoccollec').disabled(true);
		}else{
			Ext.Cmp('incomedoccollec').disabled(true);
		}
	}
	
Ext.DOM.getVerificationStatus = function (){
	var CustomerId = Ext.Cmp('CustomerId').getValue();
	console.log(CustomerId);
	Ext.Ajax({
		url		: Ext.EventUrl(new Array('ProductInfoTop', 'getVerificationStatus')).Apply(),
		method	:'POST',
		param	:{CustomerId:CustomerId},
		ERROR  : function(fn){
			Ext.Util(fn).proc(function(Result){
				console.log("Result test :", Result.ver_result);
				if(Result.ver_result==1){
		$('#ButtonUserSave').show()
	}else{
		$('#ButtonUserSave').hide()
	}
			});
		}
	}).post();
}
	
 /**
  * [_getDetailCustomer description]
  * @param  [type] $CustomerId [description]
  * @return [type]             [@overider]
  */
  
Ext.DOM.saveProductInfoPiltop = function (){

		// var isVerif = Ext.DOM.getVerificationStatus();
		// if(!isVerif){
		// 	alert('Verifikasi Belum Lengkap!');
		// 	return false;
		// }
		var checkLengthBenefbank = $("#benefaccount").val();
		checkLengthBenefbank = parseInt(checkLengthBenefbank.length)
		var minLenBenef = $("#benefaccount").attr("minlength");
		minLenBenef = parseInt(minLenBenef);


		if ( checkLengthBenefbank < minLenBenef ) {
			alert("Length benef Account is not more than " + minLenBenef + " minimal (" + minLenBenef + " length)" );
			return false;
		}


		if(Ext.Cmp('benefname').getValue()==""){
			alert('Benef Name is empty!');
			return false;
		}else if(Ext.Cmp('benefbank').getValue()==""){
			alert('Benef Bank is empty!');
			return false;
		}else if(Ext.Cmp('benefaccount').getValue()==""){
			alert('Benef Account is empty!');
			return false;
		}else if(Ext.Cmp('benefbranch').getValue()==""){
			alert('Benef Branch is empty!');
			return false;
		}else if($('input[name=key_tenor]:checked').val()==null){
			alert('Tenor is empty!');
			return false;
		}else{
			var select_tenor = $('input[name=key_tenor]:checked').val();
			var loan_amount = document.getElementById("LoanAmount_"+select_tenor).textContent;
			var Installment = document.getElementById("Installment_"+select_tenor).textContent;
			var Rate = document.getElementById("Rate_"+select_tenor).textContent;
			// var DisburseAmount = document.getElementById("DisburseAmount_"+select_tenor).textContent;
			var pilprotect = document.getElementById("pilprotect").value;
			var r = confirm("Proccessing The Loan as !\nTenor : "+select_tenor+"\nLoan : "+loan_amount+
							"\nInstallment : "+Installment+"\nRate : "+Rate+
							"\nPil Protection : "+pilprotect+"\nAre You Sure?");
			if (r == true) {
				Ext.Ajax({
					url		: Ext.EventUrl(new Array('ProductInfoTop', 'saveLoan')).Apply(),
					method	:'POST',
					param	:Ext.Join(new Array( 
								Ext.Serialize('formProductInfo1').getElement(),
								Ext.Serialize('formProductInfo2').getElement(),
								Ext.Serialize('formProductInfo3').getElement(),
								Ext.Serialize('formProductInfo4').getElement()
							)).object(),
					ERROR  : function(fn){
						Ext.Util(fn).proc(function(save){
							if( save.success ) {
								Ext.Msg("Save Product Info").Success();
								Ext.Cmp('isSave').setValue('1');
								Ext.Cmp('InputForm').setValue('1');
							}else{
								Ext.Msg("Save Product Info").Failed();
							}
						});
					}
				}).post();
			} else {
				return false
			}
		}
	}
	
 /**
  * [_getDetailCustomer description]
  * @param  [type] $CustomerId [description]
  * @return [type]             [@overider]
  */
  
  	
$(function() {
	
	console.log( "document on ready ..." );
	
// benef bank
	$("#benefbank").change(function(){
		
		var valueBenef    = $(this).val(),
			BenefAccounts = $("#benefaccount"),
			protectDataSendurl = Ext.EventUrl( new Array('SrcCustomerList','getDigitBank', valueBenef) );  
				
				// Ext.DOM.INDEX + "/SrcCustomerList/getDigitBank/" + valueBenef;
			
			var getDigit = {
				url  	 : protectDataSendurl.Apply() , 
				type 	 : "POST" , 
				dataType : 'json' , 
				success  : function (digit) {

					console.log(digit);

					var MinDigit = digit.minlength;
					var MaxDigit = digit.maxlength;

					$(BenefAccounts).attr('minlength',MinDigit);
					$(BenefAccounts).attr('maxlength',MaxDigit);
				}
			};
			
			$.ajax(getDigit);
		});

	
	$("#benefaccount").keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A, Command+A
				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
				 // Allow: home, end, left, right, down, up
				(e.keyCode >= 35 && e.keyCode <= 40)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		
		$('#benefname').bind("cut copy paste",function(e) {
			e.preventDefault();
		});
		$('#benefaccount').bind("cut copy paste",function(e) {
			e.preventDefault();
		});
		$('#benefbranch').bind("cut copy paste",function(e) {
			e.preventDefault();
		});
		
		Ext.DOM.IncomingColSet();
		Ext.DOM.CashbackSet();
		Ext.DOM.IncomeDocSet();
		Ext.DOM.getVerificationStatus();
		
// 	.money 
	
$(".money").keyup(function(){
	var id = $(this).attr('id');
	var text = Ext.Cmp(id).getValue();
	
	if(text!=''){
		text = Ext.Money(text).ToInt();
		Ext.Cmp(id).setValue(Ext.Money(text).ToDollar());
	}
	else{
		Ext.Cmp(id).setValue(0);
		}
});
			
// customize css untuk produck pill topup 
// test aja dulu.
			
	$('.ui-widget-cell1').css({"width" : "30%"});
	$('.ui-widget-cell2').css({"width" : "2%"});
	$('.ui-widget-cell3').css({"width" : "50%"});
	$('.ui-customize-max').addClass("auto");
	
});
	
</script>


<?php
	$newDate = date("d-m-Y", strtotime($param['CustomerDOB']));
	
	/* COMBO-COMBO */
	$coverage = array(2=>"Main Card Holder",4=>"Main & Spouse",3=>"Main & Child",1=>"Main & Family");
	$plan 	  = array(1=>"Infinite",2=>"Advance",3=>"Premiere");
	$sex 	  = array(1=>"Pria",2=>"Wanita");
	$incomecol= array('Y'=>'Yes', 'N'=>'No');
	$incomecol_tp = array('Fix'=>'Fix','Range'=>'Range');
	$incomecol_tp_range = array();
	for($i=1;$i<10;$i++){
		if($i == 1){
			$incomecol_tp_range[$i] = "< 3 Juta";
			$i+=1;
		}else{
			$incomecol_tp_range[$i] = $i." Juta";
		}
	}
	for($i=10;$i<=60;$i+=10){
		if($i > 10){
			if($i==60){
				$incomecol_tp_range['>50 Juta'] = ">50 Juta";
			}else{
				$incomecol_tp_range[($i-9)."-".$i." Juta"] = ($i-9)."-".$i." Juta";
			}
		}else{
			$incomecol_tp_range[$i." Juta"] = $i." Juta";
		}
	}
	/* END OF COMBO-COMBO */
	
?>

<fieldset class="corner" style="margin-bottom:15px;">
	<?php echo form()->legend(lang("Product Info"), "fa-tasks");?>
	<?php echo form()->hidden('isSave',NULL,(is_array($result)&&count($result)>0?1:0));?>
	<?php echo form()->hidden('Mode',NULL,$param['Mode']);?>
	<form name="formProductInfo1">
	<?php echo form()->hidden('CustomerId',NULL, $param['CustomerId'] );?>
	<div class="ui-widget-form-table-compact" style="width:99%;margin-top:-5px;">
		<div class="ui-widget-form-row">
			<div class="ui-widget-form-cell text_caption"><?php echo lang("Use NPWP");?></div>
			<div class="ui-widget-form-cell text_caption">:</div>
			<div class="ui-widget-form-cell"><?php echo form()->combo("typexsell", "select  tolong", array('Y'=>'YES','N'=>'NO'),'Y',null,array('disabled'=>'disabled'));?></div>
			
			<div class="ui-widget-form-cell text_caption"><?php echo lang("PIL Protection");?></div>
			<div class="ui-widget-form-cell text_caption">:</div>
			<div class="ui-widget-form-cell"><?php echo form()->combo("pilprotect", "select tolong", array('Y'=>'Y','N'=>'N'),'N',null,array('disabled'=>'disabled'));?></div>
			
		</div>
	</div>
	
	
	</form>



<fieldset class="corner" style="margin-bottom:15px;border:0px solid #000;">
	<?php echo form()->hidden('isSave',NULL,(is_array($result)&&count($result)>0?1:0));?>
	<?php echo form()->hidden('Mode',NULL,$param['Mode']);?>
	
	<form name="formProductInfo2">
	<div id="loans">
	<?php 
		$arr_header = array(
			"Tenor"=> lang("Tenor"),
			"LoanAmount" => lang("Loan Amount"),
			"Installment" => lang("Monthly Installment"),
			"DisburseAmount"=> lang("Disburse Amount"),
			"Rate"=> lang("Rate"),
			"NeedNPWP"=> lang("Perlu NPWP/Tidak"),
			"OutstandingTenor"=> lang("Outstanding Tenor"),
			"PilProPremi"=> lang("Pil Pro Premium"),
			"TotalTenorNew"=> lang("Total Tenor New")
		);
		$arr_class = array(
			"Tenor"=> "content-middle",
			"LoanAmount" => "content-middle",
			"Installment" => "content-middle",
			"DisburseAmount"=> "content-middle",
			"Rate"=> "content-middle",
			"NeedNPWP"=> "content-middle",
			"OutstandingTenor"=> "content-middle",
			"PilProPremi"=> "content-middle",
			"TotalTenorNew"=> "content-lasted"
		);
		
		echo	"<table border=0 cellspacing=1 width=\"100%\">".
				"<tr height=\"30\"> ".
				"<!-- t h class=\"ui-corner-top ui-state-default center th-first\" width=\"2%\" nowrap>". lang("label_data_no") ."</t h -->".
				"<th class=\"ui-corner-top ui-state-default center th-first\" width=\"2%\" nowrap>#</th>";
		foreach( $arr_header as $field => $value ){
				echo "<th class=\"ui-corner-top ui-state-default th-lasted {$arr_align[$field]}\" width=\"{$arr_width[$field]}\"><span class=\"header_order\" title=\"Sort By {$value}\" onclick=\"Ext.DOM.CallHistory({page:0, orderby:'{$field}', type:'{$next_order}' });\">&nbsp;{$value}</span></th>";
		}
		echo "</tr>";

		$arr_num =1; $n = 0;
		// print_r($loans);
		if( is_array($loans) ){
			$no = 1;
			$tenor = 0;
			foreach( $loans as $num => $rows ){
				$row = new EUI_Object( $rows );
				$tenor = $row->get_value('Tenor',$arr_function['Tenor']);
				$back_color = ( $num%2!=0 ? '#FFFFFF' :'#FFFEEE');
				if($frm['Tenor']==$tenor){
					$checkedtenor = array("checked"=>"checked");
				}else{
					$checkedtenor = NULL;
				}

				if ($tenor[0] == 3) {
					$font_color = 'blue';
				} else if ($tenor[0] == 6 || $tenor[0] ==12) {
					$font_color = 'black';
				} else if ($tenor[0] == 18) {
					$font_color = 'magenta';
				} else if ($tenor[0] == 24) {
					$font_color = 'red';
				} else {
					$font_color = 'green';
				}

				echo	"<tr bgcolor=\"{$back_color}\" style=\"color:{$font_color}\" class=\"onselect\" height=\"35\">".
						"<!-- t d class=\"content-first\" nowrap>{$no}</t d -->".
						"<td class=\"content-first\" nowrap>".form()->radio( "key_tenor", "content-first", $tenor,null, $checkedtenor)."</td>";
				foreach( array_keys($arr_header) as $k => $fields ){
					if(strtolower($fields) == 'tenor'){
						$numbers = $row->get_value($fields,$arr_function[$fields]);
					}else{
						if(strtolower($fields) == 'rate'){
							$numbera = $row->get_value($fields,$arr_function[$fields])*100;
							$numbers = number_format($numbera, 2, '.', ',')."%";
						}else if(strtolower($fields) == 'neednpwp'){
							$numbers = $row->get_value($fields,$arr_function[$fields]);
						}else{
							$numbers = number_format($row->get_value($fields,$arr_function[$fields]), 0, '.', ',');
						}
					}
					echo  "<td align='right' id=\"".$fields."_".$tenor."\" class=\"".$arr_class[$fields]." ui-widget-unselect-order ".$arr_align[$fields]."\" ".$arr_wrap[$fields].">".$numbers."</td>";
				}
				echo "</tr>";
				$no++;
			}
		}
		echo "</table>";
	?>
	</div>
	</form>
</fieldset>

<fieldset class="corner" style="margin-bottom:15px;border:0px solid #000;">
	<?php echo form()->hidden('isSave',NULL,(is_array($result)&&count($result)>0?1:0));?>
	<?php echo form()->hidden('Mode',NULL,$param['Mode']);?>
	
	<form name="formProductInfo3">
	<div class="ui-widget-form-table" style="margin-top:-5px;width:99%;">
		<div class="ui-widget-form-row">
			<div class="ui-widget-form-cell ui-widget-cell1 text_caption left"><?php echo lang("Benef Name");?></div>
			<div class="ui-widget-form-cell ui-widget-cell2 text_caption center">:</div>
			<div class="ui-widget-form-cell ui-widget-cell3 left"><?php echo form()->input("benefname", "input_text  tolong ui-customize-max", $frm['NewBenefName'],null,null);?></div>
			
			<div class="ui-widget-form-cell ui-widget-cell1 text_caption left"><?php echo lang("Benef Name (Ori)");?></div>
			<div class="ui-widget-form-cell ui-widget-cell2 text_caption center">:</div>
			<div class="ui-widget-form-cell ui-widget-cell3 left"><?php echo form()->input("benefnameori", "input_text  tolong ui-customize-max", $result['Transfer_Name'],null,array("disabled"=>"disabled"));?></div>
		</div>
		
		<div class="ui-widget-form-row">
			<div class="ui-widget-form-cell ui-widget-cell1 text_caption left"><?php echo lang("Benef Bank");?></div>
			<div class="ui-widget-form-cell ui-widget-cell2 text_caption center">:</div>
			<div class="ui-widget-form-cell ui-widget-cell3 left"><?php echo form()->combo("benefbank", "select  tolong ui-customize-max", $listbank,$frm['NewBenefBank'],null);?></div>
		
			<div class="ui-widget-form-cell ui-widget-cell1 text_caption left"><?php echo lang("Benef Bank (Ori)");?></div>
			<div class="ui-widget-form-cell ui-widget-cell2 text_caption center">:</div>
			<div class="ui-widget-form-cell ui-widget-cell3 left"><?php echo form()->input("benefbankori", "input_text  tolong ui-customize-max", $result['Transfer_Bank'],null,array("disabled"=>"disabled"));?></div>
		</div>
		
		<div class="ui-widget-form-row">
			<div class="ui-widget-form-cell ui-widget-cell1 text_caption left"><?php echo lang("Benef Account");?></div>
			<div class="ui-widget-form-cell ui-widget-cell2 text_caption center">:</div>
			<div class="ui-widget-form-cell ui-widget-cell3 left"><?php echo form()->input("benefaccount", "input_text  tolong ui-customize-max",$frm['NewBenefAccount']);?></div>
		
			<div class="ui-widget-form-cell ui-widget-cell1 text_caption left"><?php echo lang("Benef Account (Ori)");?></div>
			<div class="ui-widget-form-cell ui-widget-cell2 text_caption center">:</div>
			<div class="ui-widget-form-cell ui-widget-cell3 left"><?php echo form()->input("benefaccountori", "input_text  tolong ui-customize-max",$result['Transfer_AccNo'],null,array("disabled"=>"disabled"));?></div>
		</div>
		
		<div class="ui-widget-form-row">
			<div class="ui-widget-form-cell ui-widget-cell1 text_caption left"><?php echo lang("Benef branch");?></div>
			<div class="ui-widget-form-cell ui-widget-cell2 text_caption">:</div>
			<div class="ui-widget-form-cell ui-widget-cell3 left"><?php echo form()->input("benefbranch", "input_text  tolong ui-customize-max",$frm['NewBenefBranch']);?></div>
		
			<div class="ui-widget-form-cell ui-widget-cell1 text_caption left"><?php echo lang("Benef branch (Ori)");?></div>
			<div class="ui-widget-form-cell ui-widget-cell2 text_caption center">:</div>
			<div class="ui-widget-form-cell ui-widget-cell3 left"><?php echo form()->input("benefbranchori", "input_text  tolong ui-customize-max",$result['Transfer_Branch'],null,array("disabled"=>"disabled"));?></div>
		</div>
		
	</div>
	
	
	<?php
		if($param['Mode']!='VIEW'){
		?>
		<div class="ui-widget-form-row" align="Right">
			<div class="ui-widget-form-cell">&nbsp;</div>
			<div class="ui-widget-form-cell">&nbsp;</div>
			<div class="ui-widget-form-cell" align="Right">
				<?php //echo form()->button("ButtonUserSave", "button save", lang('Save Prod. Info'), array('click' => 'Ext.DOM.saveProductInfoPiltop();'));?>
				<?php //if(_get_session('HandlingType')!=3){
					//echo form()->button("ButtonUserSave", "button save", lang('Save Prod. Info'), array('click' => 'Ext.DOM.saveProductInfoPiltop();'));
				//}?>
			</div>
		</div>
		<?php
		}
		?>
	</form>
</fieldset>


<fieldset class="corner" style="margin-bottom:15px;border:0px solid #000;">
	<?php echo form()->hidden('incomecol',NULL,$result['Eligible_PIL_Protection']);?>
	<?php echo form()->hidden('cashback', NULL,$result['flag_dormant']);?>
	<form name="formProductInfo4">
	<?php  ?>
	<div class="ui-widget-form-table" style="margin-top:-5px;">
		<div class="ui-widget-form-row">
			<div class="ui-widget-form-cell text_caption"><?php echo lang("Income Collection");?></div>
			<div class="ui-widget-form-cell text_caption">:</div>
			<div class="ui-widget-form-cell"><?php echo form()->combo("incomecol_yn", "select  tolong", $incomecol,$frm['Collection'],array("change"=>"Ext.DOM.IncomingCol();"));?></div>
			<div class="ui-widget-form-cell" align="Right"><?php echo form()->combo("incomecol_tp", "select", $incomecol_tp,$frm['CollectionType'],array("change"=>"Ext.DOM.IncomingType();"));?></div>
			<div class="ui-widget-form-cell"><?php echo form()->input("incomecol_tp_fix", "input_text  middle money", $frm['incAmount'],null);?></div>
			<div class="ui-widget-form-cell"><?php echo form()->combo("incomecol_tp_rng", "select  middle", $incomecol_tp_range,$frm['incAmount'],null);?></div>
		</div>
		
		<div class="ui-widget-form-row">
			<div class="ui-widget-form-cell text_caption"><?php echo lang("Cash Back");?></div>
			<div class="ui-widget-form-cell text_caption">:</div>
			<div class="ui-widget-form-cell"><?php echo form()->combo("cashback_yn", "select  tolong", $incomecol,$frm['isCashback'],null);?></div>
			<div class="ui-widget-form-cell text_caption"></div>
			<div class="ui-widget-form-cell"></div>
			<?php
				if($param['Mode']!='VIEW'){
			?>
			<div class="ui-widget-form-cell" align="Right">
				<?php //echo form()->button("ButtonUserSave", "button save", lang('Save Prod. Info'), array('click' => 'Ext.DOM.saveProductInfoPiltop();'));?>
				<? if(_get_session('HandlingType')==4){
					echo form()->button("ButtonUserSave", "button save", lang('Save Prod. Info'), array('click' => 'Ext.DOM.saveProductInfoPiltop();'));
				}?>
			</div>
			<?php
				}
			?>
		</div>
	</div>
	</form>
</fieldset>

</fieldset>