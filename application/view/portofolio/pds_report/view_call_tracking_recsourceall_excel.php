<?php 

 function _convertDate($date){
	$exDate = explode("/",$date);
	$imDate = $exDate[2]."-".$exDate[0]."-".$exDate[1];
	$date = " ".$imDate." ";
	return $date;
 }
 // echo "<pre>";
 // print_r($RowData2);
 // echo "</pre>";
 
 $arr_title = "Call Tracking Summary by Recsource Periode of "._convertDate($param['start_date']) ."to". _convertDate($param['end_date']);
 $arr_printedby = "Printed By: "._get_session('Username');
 $arr_printdate = "Print Date: ".date('m/d/Y H:i:s');
 $base_file_tmp = "Call_Tracking_Summary_perSpv".date('YmdHis').".xls";
 $base_file_name = "/opt/enigma/webapps/reporting/application/temp/".$base_file_tmp;
 
 
// read excel  ---------------------------------------------------------

 $workbook =& new writeexcel_workbook($base_file_name);
 $worksheet =& $workbook->addworksheet();
 
/** pack header format every file **/

 $header_format =& $workbook->addformat();
 $header_format ->set_bold();
 $header_format->set_size(10);
 $header_format->set_color('white');
 $header_format->set_align('left');
 $header_format->set_align('vcenter');
 $header_format->set_pattern();
 $header_format->set_fg_color('blue');
 
 $header1_format =& $workbook->addformat();
 $header1_format ->set_bold();
 $header1_format->set_size(10);
 $header1_format->set_color('white');
 $header1_format->set_align('center');
 $header1_format->set_align('vcenter');
 $header1_format->set_pattern();
 $header1_format->set_fg_color('blue');
 // $header1_format->set_border(1,1,1,1);
 
 $title_format =& $workbook->addformat();
 $title_format ->set_bold();
 $title_format->set_size(14);
 $title_format->set_color('black');
 $title_format->set_align('left');
 $title_format->set_align('vcenter');
 
 $bootom_format =& $workbook->addformat();
 $bootom_format ->set_bold();
 $bootom_format->set_size(10);
 $bootom_format->set_color('white');
 $bootom_format->set_align('right');
 $bootom_format->set_align('vcenter');
 $bootom_format->set_pattern();
 $bootom_format->set_fg_color('blue');
 
 $agent_format =& $workbook->addformat();
 $agent_format ->set_bold();
 $agent_format->set_size(12);
 $agent_format->set_color('black');
 $agent_format->set_align('left');
 $agent_format->set_align('vcenter');
/* pack header format every file --------------------------------------- */
//-------------------------------------------------------------------------

$arr_rows = 0;
$worksheet->write_string($arr_rows, 0, $arr_title, $title_format);
$worksheet->write_string($arr_rows+=1, 0, $arr_printedby, $title_format);
$worksheet->write_string($arr_rows+=1, 0, $arr_printdate, $title_format);

/* ------------------------------------------------------------------------------------ */
$arr_rows+=2;
// foreach($LoopUser as $ID => $rows){
	// agent title
	$arr_rows+=1;
	// table
	$worksheet->write_string($arr_rows, 0, "agen : ".$rows['id'], $agent_format );
	$worksheet->write_string($arr_rows, 3, "Call Initiated", $header1_format );
	$worksheet->merge_cells($arr_rows, 3, $arr_rows, 9);
	$worksheet->write_string($arr_rows, 10, "Contacted",  $header1_format );
	$worksheet->merge_cells($arr_rows, 10, $arr_rows, 18);
	$worksheet->write_string($arr_rows, 19, "Not Contacted", $header1_format );
	$worksheet->merge_cells($arr_rows, 19, $arr_rows, 26);
	$arr_rows+=1;
	$worksheet->write_string($arr_rows, 0, "Recsource", $header_format );
	$worksheet->write_string($arr_rows, 1, "Data Size", $header_format );
	$worksheet->write_string($arr_rows, 2, "Utilized",  $header_format );
	$worksheet->write_string($arr_rows, 3, "Contacted", $header_format );
	$worksheet->write_string($arr_rows, 4, "Freq call/lead", $header_format );
	$worksheet->write_string($arr_rows, 5, "Un Contacted",  $header_format );
	$worksheet->write_string($arr_rows, 6, "Freq call/lead", $header_format );
	$worksheet->write_string($arr_rows, 7, "Total", $header_format );
	$worksheet->write_string($arr_rows, 8, "Freq call/lead",  $header_format );
	$worksheet->write_string($arr_rows, 9, "% Utilized",  $header_format );
	$worksheet->write_string($arr_rows, 10, "D", $header_format );
	$worksheet->write_string($arr_rows, 11, "ST", $header_format );
	$worksheet->write_string($arr_rows, 12, "B", $header_format );
	$worksheet->write_string($arr_rows, 13, "TBO", $header_format );
	$worksheet->write_string($arr_rows, 14, "INC", $header_format );
	$worksheet->write_string($arr_rows, 15, "INC_UNVER", $header_format );
	$worksheet->write_string($arr_rows, 16, "INC_NOTPASS_VER", $header_format );
	$worksheet->write_string($arr_rows, 17, "Total", $header_format );
	$worksheet->write_string($arr_rows, 18, "%", $header_format );
	
	$worksheet->write_string($arr_rows, 19, "NP", $header_format );
	$worksheet->write_string($arr_rows, 20, "BT", $header_format );
	$worksheet->write_string($arr_rows, 21, "NA", $header_format );
	$worksheet->write_string($arr_rows, 22, "MV", $header_format );
	$worksheet->write_string($arr_rows, 23, "WN", $header_format );
	$worksheet->write_string($arr_rows, 24, "ID", $header_format );
	$worksheet->write_string($arr_rows, 25, "Total", $header_format );
	$worksheet->write_string($arr_rows, 26, "%", $header_format );
	
	$dl_columns=26;
	foreach($LoopDL as $Disagree => $row){
		$worksheet->write_string($arr_rows, $dl_columns+=1, $row, $header_format );
	}
	
	$worksheet->write_string($arr_rows, $dl_columns+=1, "Lain-lain", $header_format );
	$worksheet->write_string($arr_rows, $dl_columns+=1, "Amount",  $header_format );
	$worksheet->write_string($arr_rows, $dl_columns+=1, "Total Registration",  $header_format );
	$worksheet->write_string($arr_rows, $dl_columns+=1, "Product",  $header_format );
	$worksheet->write_string($arr_rows, $dl_columns+=1, "Total BestBill Registration",  $header_format );
	$arr_rows +=1;
	
	foreach($RowData1 as $Data => $rows1){
		$Recsource		= ($Data ? $Data : 0);
		$Datasize		= ($rows1['datasize'] ? $rows1['datasize'] : 0);
		$Utilize		= ($RowData3[$Data]['new_util'] ? $RowData3[$Data]['new_util'] : 0);
		
		// Contacted
		$D				= ($RowData3[$Data]['D'] ? $RowData3[$Data]['D'] : 0);
		$ST				= ($RowData3[$Data]['ST'] ? $RowData3[$Data]['ST'] : 0);
		$CB				= ($RowData3[$Data]['CB'] ? $RowData3[$Data]['CB'] : 0);
		$INC			= ($RowData3[$Data]['INC'] ? $RowData3[$Data]['INC'] : 0);
		
		$B				= ($RowData3[$Data]['B'] ? $RowData3[$Data]['B'] : 0);
		$TotalContact	= ($D + $ST + $CB + $INC + $B);
		$TotalContactInit	= ($RowData4[$Data]['tot_connect'] ? $RowData4[$Data]['tot_connect'] : 0);
		$PercentageCont	= round(($TotalContact / $Utilize) * 100,2);
		
		// Uncontacted
		$NP				= ($RowData3[$Data]['NP'] ? $RowData3[$Data]['NP'] : 0);
		$BT				= ($RowData3[$Data]['BT'] ? $RowData3[$Data]['BT'] : 0);
		$NA				= ($RowData3[$Data]['NA'] ? $RowData3[$Data]['NA'] : 0);
		$MV				= ($RowData3[$Data]['MV'] ? $RowData3[$Data]['MV'] : 0);
		$WN				= ($RowData3[$Data]['WN'] ? $RowData3[$Data]['WN'] : 0);
		$IDR			= ($RowData3[$Data]['ID'] ? $RowData3[$Data]['ID'] : 0);
		$TotalUncontact	= ($NP + $BT + $NA + $MV + $WN + $IDR);
		$TotalUncontactInit	= ($RowData4[$Data]['tot_notconnect'] ? $RowData4[$Data]['tot_notconnect'] : 0);
		$PercentageUn	= round(($TotalUncontact / $Utilize) * 100,2);
		
		$DL0			= ($RowData3[$Data]['DL0'] ? $RowData3[$Data]['DL0'] : 0);
		$DL1			= ($RowData3[$Data]['DL1'] ? $RowData3[$Data]['DL1'] : 0);
		$DL2			= ($RowData3[$Data]['DL2'] ? $RowData3[$Data]['DL2'] : 0);
		$DL3			= ($RowData3[$Data]['DL3'] ? $RowData3[$Data]['DL3'] : 0);
		$DL4			= ($RowData3[$Data]['DL4'] ? $RowData3[$Data]['DL4'] : 0);
		$DL5			= ($RowData3[$Data]['DL5'] ? $RowData3[$Data]['DL5'] : 0);
		$DL6			= ($RowData3[$Data]['DL6'] ? $RowData3[$Data]['DL6'] : 0);
		$DL7			= ($RowData3[$Data]['DL7'] ? $RowData3[$Data]['DL7'] : 0);
		$DL8			= ($RowData3[$Data]['DL8'] ? $RowData3[$Data]['DL8'] : 0);
		$DL9			= ($RowData3[$Data]['DL9'] ? $RowData3[$Data]['DL9'] : 0);
		$DL10			= ($RowData3[$Data]['DL10'] ? $RowData3[$Data]['DL10'] : 0);
		$DL11			= ($RowData3[$Data]['DL11'] ? $RowData3[$Data]['DL11'] : 0);
		$DL12			= ($RowData3[$Data]['DL12'] ? $RowData3[$Data]['DL12'] : 0);
		$DL13			= ($RowData3[$Data]['DL13'] ? $RowData3[$Data]['DL13'] : 0);
		$DL14			= ($RowData3[$Data]['DL14'] ? $RowData3[$Data]['DL14'] : 0);
		$Amount			= ($amount[$Data]['Amount'] ? $amount[$Data]['Amount'] : 0);

		$Total			= $TotalContactInit + $TotalUncontactInit;
		$Freq_1			= $TotalContactInit/$Utilize; //$TotalContact;
		$Freq_2			= $TotalUncontactInit/$Utilize; //$TotalUncontact;
		$Freq_3			= ($Total/($TotalContact+$TotalUncontact));
		$PercentageUtil	= (($Utilize / $Datasize) * 100);
		
		$worksheet->write_string($arr_rows, 0, $Recsource);
		$worksheet->write_number($arr_rows, 1, $Datasize);
		$worksheet->write_number($arr_rows, 2, $Utilize);
		$worksheet->write_number($arr_rows, 3, $TotalContactInit);
		$worksheet->write_number($arr_rows, 4, round($Freq_1,1));
		$worksheet->write_number($arr_rows, 5, $TotalUncontactInit);
		$worksheet->write_number($arr_rows, 6, round($Freq_2,1));
		$worksheet->write_number($arr_rows, 7, $Total);
		$worksheet->write_number($arr_rows, 8, round($Freq_3,1));
		$worksheet->write_string($arr_rows, 9, round($PercentageUtil,2)."%");
		$worksheet->write_number($arr_rows, 10, $D);
		$worksheet->write_number($arr_rows, 11, $ST+$CB);
		$worksheet->write_number($arr_rows, 12, $CB);
		$worksheet->write_number($arr_rows, 13, $SA);
		$worksheet->write_number($arr_rows, 14, $INC);
		$worksheet->write_number($arr_rows, 15, $GPU);
		$worksheet->write_number($arr_rows, 16, $CPGP);
		$worksheet->write_number($arr_rows, 17, $TotalContact);
		$worksheet->write_string($arr_rows, 18, $PercentageCont."%");
		$worksheet->write_number($arr_rows, 19, $NP);
		$worksheet->write_number($arr_rows, 20, $BT);
		$worksheet->write_number($arr_rows, 21, $NA);
		$worksheet->write_number($arr_rows, 22, $MV);
		$worksheet->write_number($arr_rows, 23, $WN);
		$worksheet->write_number($arr_rows, 24, $IDR);
		$worksheet->write_number($arr_rows, 25, $TotalUncontact);
		$worksheet->write_string($arr_rows, 26, $PercentageUn."%");
		
		$loopcol = 26;
		foreach($LoopDL as $Dis => $baris){
			$sDL[$baris]	+= $RowData3[$Data][$baris];
			$DL				= ($RowData3[$Data][$baris] ? $RowData3[$Data][$baris] : 0);
			$worksheet->write_number($arr_rows, $loopcol+=1, $DL);
		}
		
		$worksheet->write_number($arr_rows, $loopcol+=1, 0);
		$worksheet->write_number($arr_rows, $loopcol+=1, $Amount);
		$worksheet->write_number($arr_rows, $loopcol+=1, $INC);
		$worksheet->write_string($arr_rows, $loopcol+=1, $product[_get_post('Campaign')]);
		$worksheet->write_number($arr_rows, $loopcol+=1, 0);
		$arr_rows+=1;
		
		$sDataSize['sDataSize']	+= $Datasize;
		$sUtilize['sUtilize']		+= $Utilize;
		$sAmount['sAmount']		+= $Amount;

		$sContacted['sContacted']	+= $TotalContact;
		$sContactedInit['sContacted']	+= $TotalContactInit;

		$sUncontact['sUncontact']	+= $TotalUncontact;
		$sUncontactInit['sUncontact']	+= $TotalUncontactInit;

		$sD['sD']					+= $D;
		$sST['sST']				+= $ST;
		$sB['sB']					+= $B;
		$sTBO['sTBO']				+= $TBO;
		$sINC['sINC']				+= $INC;
		$sINC_UNVER['sINC_UNVER']	+= $INC_UNVER;
		$sINC_NOTPASS['sINC_NOTPASS']	+= $INC_NOTPASS;

		$sNP['sNP']			+= $NP;
		$sBT['sBT']			+= $BT;
		$sNA['sNA']			+= $NA;
		$sMV['sMV']			+= $MV;
		$sWN['sWN']			+= $WN;
		$sID['sID']			+= $IDR;
		$sAddOn['sAddOn']		+= $AddOn;
	}
	
	$sFreq_1['sFreq_1']		= $sContactedInit['sContacted']/$sUtilize['sUtilize']; //$sContacted['sContacted'];
	$sFreq_2['sFreq_2']		= $sUncontactInit['sUncontact']/$sUtilize['sUtilize']; //$sUncontact['sUncontact'];
	$sTotal['sTotal']			= ($sContactedInit['sContacted'] + $sUncontactInit['sUncontact']);
	$sFreq_3['sFreq_3']		= ($sTotal['sTotal']/($sContacted['sContacted']+$sUncontact['sUncontact']));

	$sPerUtil['sPerUtil']		= (($sUtilize['sUtilize'] /$sDataSize['sDataSize'] ) * 100);
	$sPerContact['sPerContact']	= (($sContacted['sContacted'] / $sUtilize['sUtilize']) * 100);
	$sPerUncontact['sPerUncontact']	= (($sUncontact['sUncontact'] / $sUtilize['sUtilize']) * 100);
	
	$worksheet->write_string($arr_rows, 0, "Total", $header_format);
	$worksheet->write_number($arr_rows, 1, $sDataSize['sDataSize'], $header_format);
	$worksheet->write_number($arr_rows, 2, $sUtilize['sUtilize'], $header_format);
	$worksheet->write_number($arr_rows, 3, $sContactedInit['sContacted'], $header_format);
	$worksheet->write_number($arr_rows, 4, round($sFreq_1['sFreq_1'],1), $header_format);
	$worksheet->write_number($arr_rows, 5, $sUncontactInit['sUncontact'], $header_format);
	$worksheet->write_number($arr_rows, 6, round($sFreq_2['sFreq_2'],1), $header_format);
	$worksheet->write_number($arr_rows, 7, $sTotal['sTotal'], $header_format);
	$worksheet->write_number($arr_rows, 8, round($sFreq_3['sFreq_3'],1), $header_format);
	$worksheet->write_string($arr_rows, 9, round($sPerUtil['sPerUtil'],2)." %", $header_format);
	$worksheet->write_number($arr_rows, 10, $sD['sD'], $header_format);
	$worksheet->write_number($arr_rows, 11, $sST['sST']+$sCB['sCB'], $header_format);
	$worksheet->write_number($arr_rows, 12, $sB['sB'], $header_format);
	$worksheet->write_number($arr_rows, 13, $sTBO['sTBO'], $header_format);
	$worksheet->write_number($arr_rows, 14, $sINC['sINC'], $header_format);
	$worksheet->write_number($arr_rows, 15, $sINC_UNVER['sINC_UNVER'], $header_format);
	$worksheet->write_number($arr_rows, 16, $sINC_NOTPASS['sINC_NOTPASS'], $header_format);
	$worksheet->write_number($arr_rows, 17, $sContacted['sContacted'], $header_format);
	$worksheet->write_string($arr_rows, 18, round($sPerContact['sPerContact'],2)." %", $header_format);
	$worksheet->write_number($arr_rows, 19, $sNP['sNP'], $header_format);
	$worksheet->write_number($arr_rows, 20, $sBT['sBT'], $header_format);
	$worksheet->write_number($arr_rows, 21, $sNA['sNA'], $header_format);
	$worksheet->write_number($arr_rows, 22, $sMV['sMV'], $header_format);
	$worksheet->write_number($arr_rows, 23, $sWN['sWN'], $header_format);
	$worksheet->write_number($arr_rows, 24, $sID['sID'], $header_format);
	$worksheet->write_number($arr_rows, 25, $sUncontact['sUncontact'], $header_format);
	$worksheet->write_string($arr_rows, 26, round($sPerUncontact['sPerUncontact'],2)." %", $header_format);
	$totcols = 26;
	foreach($LoopDL as $keys => $DLx){
		$worksheet->write_number($arr_rows, $totcols+=1, $sDL[$DLx], $header_format);
	}
	$worksheet->write_number($arr_rows, $totcols+=1, 0, $header_format);
	$worksheet->write_number($arr_rows, $totcols+=1, $sAmount['sAmount'], $header_format);
	$worksheet->write_number($arr_rows, $totcols+=1, $sINC['sINC'], $header_format);
	$worksheet->write_string($arr_rows, $totcols+=1, "-", $header_format);
	$worksheet->write_number($arr_rows, $totcols+=1, 0, $header_format);
	$arr_rows+=2;
// }

 $workbook->close(); // end book 
 
 if( file_exists($base_file_name))
{
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Content-Type: application/force-download");
  header("Content-Type: application/octet-stream");
  header("Content-Type: application/download");
  header("Content-type: application/vnd.ms-excel; charset=utf-16");
  header("Content-Disposition: attachment; filename=". basename($base_file_name));
  header("Content-Transfer-Encoding: binary");
  header("Content-Length: " . filesize($base_file_name));
  readfile($base_file_name); 
  @unlink($base_file_name);
}
?>