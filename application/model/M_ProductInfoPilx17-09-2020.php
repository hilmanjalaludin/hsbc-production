<?php 
class M_ProductInfoPilx extends EUI_Model
{
	private static $Instance = null;
	var $income_reason = array();
	public static function & Instance(){
		if( is_null(self::$Instance)){
			self::$Instance = new self();
		}
		return self::$Instance;
	}

	function __construct(){
		$this->load->model(array('M_ProductForm','M_SysUser'));
		$this->income_reason = array(
			'Fix'=>'Outbound Income Update Recorded',
			'Range'=>'Range',
			'HouseWife'=>'Outbound Recorded - Housewife'
		);
	}
	
	/**
	 * (F) _get_data_form description]
	 * @param  Int $_cust_id
	 * query-mssql	[OK]
	 */
	function _get_data_form($_cust_id)
	{
		$_datas = array();
		
		// $sql = "SELECT a.*, b.Recsource FROM t_gn_attr_pil_xsell a
		// 		left join t_gn_customer b ON a.CustomerId = b.CustomerId
		// 		WHERE a.CustomerId = '".$_cust_id."'";
		$sql = "SELECT a.*,c.tnc, b.Recsource FROM t_gn_attr_pil_xsell a
				left join t_gn_customer b ON a.CustomerId = b.CustomerId
				left join t_gn_frm_pil_xsel c ON c.CustomerId = b.CustomerId
				WHERE a.CustomerId = '".$_cust_id."'";
				
		$qry = $this->db->query($sql);
		
		#var_dump($this->db->last_query());die();
		if($qry->num_rows()>0)
		{
			$_datas = $qry->result_first_assoc();
		}
		
		return $_datas;
	}
	
	function _get_ver_result($_cust_id)
	{
		$_datas = array();
		// SELECT a.ver_result from t_gn_ver_result a WHERE a.cust_id = '890394'
		$sql = "SELECT a.ver_result from t_gn_ver_status a
				WHERE a.cust_id = '".$_cust_id."'";
				
		$qry = $this->db->query($sql);
		
		// echo $sql;
		// var_dump($this->db->last_query()); //die();
		if($qry->num_rows()>0){
			$_datas = $qry->result_first_assoc();
		}else{
			$_datas = array("ver_result"=>0);
		}
		// var_dump($_datas);
		return $_datas;
	}
	
	function _get_data_inc_frm($_cust_id)
	{
		$_datas = array();
		// $sql = "SELECT * FROM t_gn_frm_pil_xsel a WHERE a.CustomerId = '".$_cust_id."'";
		
		$condition = "if(b.flagCashback = 1, 'Y', 'N') as isCashback, "; // mode mysql

		if ( QUERY == 'mssql' ) {
			$condition = "CASE WHEN b.flagCashback = 1 THEN 'Y' ELSE 'N' END AS isCashback, ";
		}

		$sql = "SELECT a.*, 
				{$condition}				
				c.Collection, c.CollectionType, c.Amount as incAmount
				
				FROM t_gn_frm_pil_xsel a
				left join t_gn_incomecash b ON a.CustomerId = b.CustomerId
				left join t_gn_incomecolldoc c ON a.CustomerId = c.CustomerId
				WHERE a.CustomerId = '".$_cust_id."'";
		$qry = $this->db->query($sql);
		
		#var_dump($this->db->last_query());die();
		if($qry->num_rows()>0){
			$_datas = $qry->result_first_assoc();
		}
		
		return $_datas;
	}
	
	/**
	 * (F) _get_data_loans description]
	 * @param  Int $custid
	 * @param  Int $tenor
	 * query-mssql [OK]
	 */
	function _get_data_loans($custid, $tenor = NULL){
		$_datap = array();
		//$sql = "select * from t_gn_loan_tiering a where a.CustomerId = '".$custid."'";
		//edit irul - jika loanamount nya 0 maka tidak tampil di product info
		$sql = "select * from t_gn_loan_tiering a where a.CustomerId = '".$custid."' AND a.LoanAmount>0 ";
		//tutup edit irul
		if($tenor!=NULL){
			$sql.=" AND a.Tenor=".$tenor;
		}
		$qry = $this->db->query($sql);

		#var_dump( $this->db->last_query() );die();
		foreach( $qry -> result_assoc() as $rows ) {
			$_datap[$rows['Tenor']]['LoanAmount'] = $rows['LoanAmount'];
		//edit hilman andi start
			$_datap[$rows['Tenor']]['Installment'] = $rows['Installment'];
			$_datap[$rows['Tenor']]['AdminFee'] = $rows['AdminFee'];
			$_datap[$rows['Tenor']]['DisburseAmount'] = $rows['DisburseAmount'];
		//edit hilman andi end

			$_datap[$rows['Tenor']]['Rate'] = $rows['Rate'];
			$_datap[$rows['Tenor']]['Tenor'] = $rows['Tenor'];
			$_datap[$rows['Tenor']]['CustomerId'] = $rows['CustomerId'];
		}
		return $_datap;
	}
	
	function _get_list_bank(){
		$_datap = array();
		$sql = "select * from t_lk_bank a";
		if($tenor!=NULL){
			$sql.=" WHERE a.Tenor=".$tenor;
		}
		$qry = $this->db->query($sql);

		#var_dump( $this->db->last_query() );die();
		foreach( $qry -> result_assoc() as $rows ) {
			$_datap[$rows['BankId']] = $rows['BankName'];
		}
		return $_datap;
	}
	
	function _select_personal_premi( $arr_cond = array() ){
		$out = new EUI_Object( $arr_cond );
		$totals = array( 'ProductPlanId' => 0, 'ProductPlanPremium' => 0);
		
		$this->db->reset_select();
		$this->db->select('a.ProductPlanId, a.ProductPlanPremium');
		$this->db->from('t_gn_productplan a');
		
	// --------- ProductId  --------------		
		// $this->db->where('a.ProductId', $out->get_value('ProductId','intval'), FALSE);
		$this->db->where('a.PremiumGroupId', $out->get_value('Coverage','intval'), FALSE);
		// $this->db->where('a.PayModeId', $out->get_value('PayMode','intval'), FALSE);
		$this->db->where('a.ProductPlan', $out->get_value('Plan','intval'), FALSE);
		// $this->db->where('a.GenderId', $out->get_value('GenderId','intval'), FALSE);
		// $this->db->where('a.PremiTypeId', $out->get_value('PremiTypeId','intval'), FALSE);
		if($out->get_value('premiAge','intval')!="child"){
			$this->db->where("{$out->get_value('premiAge','intval')} BETWEEN a.ProductPlanAgeStart AND a.ProductPlanAgeEnd", NULL , FALSE);
		}
		
		
		$rs = $this->db->get();
		
		// echo $this->db->last_query();
		 if( $rs->num_rows() == 1 )
		{
			return (array)$rs->result_first_assoc();
		} 	
		
		return new EUI_Object($totals);
	}
	
	public function _set_row_save_pilx($out=null) {
		if( !$out->fetch_ready() OR !_get_is_login() ){
			return (bool)FALSE;
		}
		
		$tenor = $out->get_value('key_tenor','intval');
		$loans = $this->_get_data_loans($out->get_value('CustomerId','intval'),$out->get_value('key_tenor','intval'));
		$customer = $this->_get_data_form($out->get_value('CustomerId','intval'));
		$obloans =new EUI_Object($loans);
		$obcustomer =new EUI_Object($customer);
		

		$loan = ($out->get_value('vartiering','intval')>0?(($loans[$tenor]['LoanAmount']*$out->get_value('vartiering','intval'))/100):$loans[$tenor]['LoanAmount']);
		
		// $inst =  $loans[$tenor]['Installment'];
		 // var_dump('inst',$inst);

		//edit hilman andi start
		$var_teiring = $out->get_value('vartiering'); 

		 // var_dump('vartiering',$var_teiring);
		// $onehunder=100;
		// $reduce	 = ($inst * $var_teiring) / $onehunder;
  //       // var_dump('result',$reduce);


  // // 		var_dump('kurangin',$reduce);
		// // var_dump('inst',$inst);
		// // die;
		// $Installment = $inst - $reduce;
		
		$inst	  =  $loans[$tenor]['Installment'];
		// var_dump('inst',$inst);
		// $reduce	 = ($inst * $var_tiering) / 100;
        // $Installment = $inst - $reduce;
		// var_dump('hasil',$kurangin);
		// die;

		$hasil=($var_teiring / 100) * $inst;
		$Installment= $hasil;

		// var_dump($hasil);
		// die;

		//$Installment =  $loans[$tenor]['Installment'];		
		
		$AF=($var_teiring / 100) * $loans[$tenor]['AdminFee'];
		 
		$AdminFee		=$AF ;	
		// var_dump($AdminFee);die();
		// $AdminFee =  $loans[$tenor]['AdminFee'];		
		$Disbu =  $loans[$tenor]['DisburseAmount'];
		


        $Disburse=($var_teiring / 100) * $Disbu;
		$DisburseAmount = $Disburse;
		//edit hilman andi end
         
		// var_dump($DisburseAmount);
		// die;

		$obOut   =& get_class_instance('M_SysUser');
		$obUsr   =& Objective($obOut->_getUserDetail(_get_session('UserId')));
		$obnpwp = $obcustomer->get_value('NEED_NPWP_PIL');
		// echo $obnpwp;
		$NPWP = "YES";
		if($obnpwp=="Sudah Punya NPWP" OR $obnpwp=="Sudah Punya NPWP SID"){
			$NPWP = 'Y';
		}else if($obnpwp=="Belum Punya NPWP"){
			$NPWP = 'N';
		}

		
		
		// print_r($out);echo $out->get_value('benefaccount','intval');

		$this->db->reset_write();
		//edit hilman andi start
		$this->db->set('Installment'			,$Installment);
		// $this->db->set('AdminFee'				,$AdminFee);
		// $this->db->set('DisburseAmount'			,$DisburseAmount);
		$this->db->set('tnc'	,$out->get_value('tnc'));
		

		$this->db->set('CustomerId'	,$obcustomer->get_value('CustomerId','intval'));
		$this->db->set('Custno'		,$obcustomer->get_value('Custno1','strtoupper')); 
		$this->db->set('Acct'		,$obcustomer->get_value('Accno','intval'));
		$this->db->set('Cardno'		,$obcustomer->get_value('cardno','intval')); 
		$this->db->set('SFID'		,$obcustomer->get_value('sex_main','strtoupper')); 
		$this->db->set('STPID'		,$obcustomer->get_value('STP_ID','strtoupper'));
		$this->db->set('NameOnCard'	,$obcustomer->get_value('CARD_HOLDER_NAME','strtoupper'));
		$this->db->set('FlexiMktCode'	,$obcustomer->get_value('mkt_code','strtoupper'));
		$this->db->set('FlexiLimit'	,$obcustomer->get_value('Limit','intval'));
		$this->db->set('ProdType'	,$obcustomer->get_value('PROG','strtoupper'));
		$this->db->set('NeedNPWP'	,$out->get_value('typexsell','strtoupper'));
		$this->db->set('BenefAccount'	,$out->get_value('benefaccount'));
		$this->db->set('BenefName'		,$out->get_value('benefname','strtoupper'));
		$this->db->set('BenefBank'		,$out->get_value('benefbank','strtoupper'));
		$this->db->set('BenefBranch'	,$out->get_value('benefbranch','strtoupper'));
		$this->db->set('PilProtection'	,$out->get_value('pilprotect','strtoupper'));
		$this->db->set('incomeDocs_collected'	,$out->get_value('incomeDoc_Collected','strtoupper'));
		$this->db->set('TaxIdNumber'	,$obcustomer->get_value('FIN_TAX_ID','intval'));
		$this->db->set('Loan'			,$loan);
		$this->db->set('Tenor'			,$tenor);
		$this->db->set('Rate'			,$loans[$tenor]['Rate']);
		$this->db->set('vartiering'		,$out->get_value('vartiering'));
		//edit hilman andi start
		$this->db->set('AdminFee'		,$AdminFee);
		$this->db->set('DisburseAmount'	,$DisburseAmount);
		//edit hilman andi end
		$this->db->set("AdditionalHPhone"	,$obcustomer->get_value('HOME_PHONE')); 
		$this->db->set('AdditionalOPhone'	,$obcustomer->get_value('OFF_PHONE'));
		$this->db->set('AdditionalMPhone'	,$obcustomer->get_value('MOBILE'));
		$this->db->set('GHI'		,$obcustomer->get_value('coverage'));
		$this->db->set("PunyaNPWP"	,$NPWP);
		$this->db->set("SubmitNPWP"	,$NPWP);
		$this->db->set("HomePhone"	,$obcustomer->get_value('PHONE1'));
		$this->db->set("OfficePhone",$obcustomer->get_value('PHONE2'));
		$this->db->set("MobilePhone",$obcustomer->get_value('mobile'));
		$this->db->set("CreateDate"	,date('Y-m-d H:i:s'));
		$this->db->set("CreateBy"	,$obUsr->get_value('UserId','intval'));
		$this->db->set("DLFlage"	,0);
		
		$this->db->insert('t_gn_frm_pil_xsel');
		// var_dump($this->db->last_query());
		// die;
		if( $this->db->affected_rows() > 0 ){
			$hospinid = $this->db->insert_id();
				/** Income Coll **/
				$this->db->reset_write();
				$this->db->set('CustomerId'	,$obcustomer->get_value('CustomerId','intval'));
				$this->db->set('Custno'		,$obcustomer->get_value('Custno1','strtoupper')); 
				$this->db->set('Cardno'		,$obcustomer->get_value('cardno','intval')); 
				$this->db->set('CampaignId'	,5);
				
				$this->db->set('Collection'		,$out->get_value('incomecol_yn'));
				if(strtolower($out->get_value('incomecol_yn'))=="y"){
					$reason = $this->income_reason[$out->get_value('incomecol_tp')];
					$this->db->set('CollectionType'	,$out->get_value('incomecol_tp'));
					if(strtolower($out->get_value('incomecol_tp'))=="fix"){
						$this->db->set('Amount'			,($out->get_value('incomecol_tp_fix')>0?str_replace(".","",$out->get_value('incomecol_tp_fix')):0));
					}else if(strtolower($out->get_value('incomecol_tp'))=="range"){
						$this->db->set('Amount'			,($out->get_value('incomecol_tp_rng')>0?$out->get_value('incomecol_tp_rng'):0));
					}
					$this->db->set('Reason'			,$reason);
				}else if(strtolower($out->get_value('incomecol_yn'))=="n"){
					$reason = $this->income_reason['HouseWife'];
					$this->db->set('CollectionType'	,'HouseWife');
					$this->db->set('Amount'			,0);
					$this->db->set('Reason'			,$reason);
				}
				
				$this->db->set('MaintenanceType',"C");
				$this->db->set('Remarks'		,"");
				$this->db->set('AOC'			,$obUsr->get_value('UserId','intval'));
				$this->db->set('IncomeDate'		,date('Y-m-d H:i:s'));
				$this->db->set('RecsourceName'	,$obcustomer->get_value('Recsource','strtoupper'));
				$this->db->set('Flag'			,0);
				
				if(strtolower($out->get_value('incomecol'))=="belum ada income doc"){
					if(strtolower($out->get_value('incomecol_yn'))=="y" || strtolower($out->get_value('incomecol_yn'))=="n"){
						$this->db->insert('t_gn_incomecolldoc');
					}
				}
				/** End of Income Coll **/
				
				/** Cashback **/
				if(strtolower($out->get_value('cashback_yn'))=="y"){
					$this->db->reset_write();
					$this->db->set('CustomerId'	, $obcustomer->get_value('CustomerId','intval'));
					$this->db->set('Custno'		, $obcustomer->get_value('Custno1','strtoupper')); 
					$this->db->set('Cardno'		, $obcustomer->get_value('cardno','intval')); 
					$this->db->set('CampaignId'	, 5);
					$this->db->set('Amount'		, 100000);
					$this->db->set('TC'			, "0422");
					$this->db->set('Narrative'	, "PIL Cashback 100rb (".date('md').") A");
					$this->db->set('AOC'		, $obUsr->get_value('UserId','intval'));
					$this->db->set('IncomingDate'	, date('Y-m-d H:i:s'));
					$this->db->set('flagCashback'			, 1);
					
					if($out->get_value('cashback')=="YES"){
						$this->db->insert('t_gn_incomecash');
					}
				}else{
					$this->db->reset_write();
					$this->db->set('CustomerId'	, $obcustomer->get_value('CustomerId','intval'));
					$this->db->set('Custno'		, $obcustomer->get_value('Custno1','strtoupper')); 
					$this->db->set('Cardno'		, $obcustomer->get_value('cardno','intval')); 
					$this->db->set('CampaignId'	, 5);
					$this->db->set('Amount'		, 100000);
					$this->db->set('TC'			, "0422");
					$this->db->set('Narrative'	, "PIL Cashback 100rb (".date('md').") A");
					$this->db->set('AOC'		, $obUsr->get_value('UserId','intval'));
					$this->db->set('IncomingDate'	, date('Y-m-d H:i:s'));
					$this->db->set('flagCashback'			, 0);

					if($out->get_value('cashback')=="YES"){
						$this->db->insert('t_gn_incomecash');
					}
				}
				/** End of Cashback **/
				
			// echo MYSQL_ERROR();
			return true;
		}else{
			$this->db->reset_write();
			//edit hilman andi start
			$this->db->set('Installment'			,$Installment);
			$this->db->set('tnc'	,$out->get_value('tnc'));
		
			// $this->db->set('AdminFee'			,$AdminFee);
			// $this->db->set('DisburseAmount'			,$DisburseAmount);

			$this->db->set('CustomerId'	,$obcustomer->get_value('CustomerId','intval'));
			$this->db->set('Custno'		,$obcustomer->get_value('Custno1','strtoupper')); 
			$this->db->set('Acct'		,$obcustomer->get_value('Acct','intval'));
			$this->db->set('Cardno'		,$obcustomer->get_value('cardno','intval')); 
			$this->db->set('SFID'		,$obcustomer->get_value('sex_main','strtoupper')); 
			$this->db->set('STPID'		,$obcustomer->get_value('STP_ID','strtoupper'));
			$this->db->set('NameOnCard'	,$obcustomer->get_value('CARD_HOLDER_NAME','strtoupper'));
			$this->db->set('FlexiMktCode'	,$obcustomer->get_value('mkt_code','strtoupper'));
			$this->db->set('FlexiLimit'	,$obcustomer->get_value('Limit','intval'));
			$this->db->set('ProdType'	,$obcustomer->get_value('PROG','strtoupper'));
			$this->db->set('NeedNPWP'	,$out->get_value('typexsell','strtoupper'));
			$this->db->set('BenefAccount'	,$out->get_value('benefaccount','strtoupper'));
			$this->db->set('BenefName'		,$out->get_value('benefname','strtoupper'));
			$this->db->set('BenefBank'		,$out->get_value('benefbank','strtoupper'));
			$this->db->set('BenefBranch'	,$out->get_value('benefbranch','strtoupper'));
			$this->db->set('PilProtection'	,$out->get_value('pilprotect','strtoupper'));
			$this->db->set('TaxIdNumber'	,$obcustomer->get_value('FIN_TAX_ID','intval'));
			$this->db->set('Loan'			,$loan);
			$this->db->set('Tenor'			,$tenor);
			$this->db->set('Rate'			,$loans[$tenor]['Rate']);
			$this->db->set('vartiering'		,$out->get_value('vartiering'));
			//edit hilman andi start
			$this->db->set('AdminFee'		,$AdminFee);
			$this->db->set('DisburseAmount'	,$DisburseAmount);
			//edit hilman andi end
			$this->db->set("AdditionalHPhone"	,$obcustomer->get_value('HOME_PHONE')); 
			$this->db->set('AdditionalOPhone'	,$obcustomer->get_value('OFF_PHONE'));
			$this->db->set('AdditionalMPhone'	,$obcustomer->get_value('MOBILE'));
			$this->db->set('GHI'		,$obcustomer->get_value('coverage'));
			$this->db->set("PunyaNPWP"	,$NPWP);
			$this->db->set("SubmitNPWP"	,$NPWP);
			$this->db->set("HomePhone"	,$obcustomer->get_value('PHONE1'));
			$this->db->set("OfficePhone",$obcustomer->get_value('PHONE2'));
			$this->db->set("MobilePhone",$obcustomer->get_value('mobile'));
			$this->db->set("CreateBy"	,$obUsr->get_value('UserId','intval'));
			$this->db->set('UpdateDate',date('Y-m-d H:i:s'));

			$this->db->where('CustomerId',$obcustomer->get_value('CustomerId'));
			$this->db->update('t_gn_frm_pil_xsel');
			
			if( $this->db->affected_rows() > 0 ){
				$this->db->reset_write();
					$this->db->set('Custno'		,$obcustomer->get_value('Custno1','strtoupper')); 
					$this->db->set('Cardno'		,$obcustomer->get_value('cardno','intval')); 
					$this->db->set('CampaignId'	,5);
					
					$this->db->set('Collection'		,$out->get_value('incomecol_yn'));
					if(strtolower($out->get_value('incomecol_yn'))=="y"){
						$reason = $this->income_reason[$out->get_value('incomecol_tp')];
						$this->db->set('CollectionType'	,$out->get_value('incomecol_tp'));
						if(strtolower($out->get_value('incomecol_tp'))=="fix"){
							$this->db->set('Amount'			,($out->get_value('incomecol_tp_fix')>0?str_replace(".","",$out->get_value('incomecol_tp_fix')):0));
						}else if(strtolower($out->get_value('incomecol_tp'))=="range"){
							$this->db->set('Amount'			,($out->get_value('incomecol_tp_rng')>0?$out->get_value('incomecol_tp_rng'):0));
						}
						$this->db->set('Reason'			,$reason);
					}else if(strtolower($out->get_value('incomecol_yn'))=="n"){
						$reason = $this->income_reason['HouseWife'];
						$this->db->set('CollectionType'	,'HouseWife');
						$this->db->set('Amount'			,0);
						$this->db->set('Reason'			,$reason);
					}
					
					$this->db->set('MaintenanceType',"C");
					$this->db->set('Remarks'		,"");
					$this->db->set('AOC'			,$obUsr->get_value('UserId','intval'));
					$this->db->set('IncomeDate'		,date('Y-m-d H:i:s'));
					$this->db->set('RecsourceName'	,$obcustomer->get_value('Recsource','strtoupper'));
					$this->db->set('Flag'			,0);
					
					$this->db->where('CustomerId',$obcustomer->get_value('CustomerId'));
					if($out->get_value('incomecol')=="Belum Ada Income Doc"){
						if(strtolower($out->get_value('incomecol_yn'))=="y" || strtolower($out->get_value('incomecol_yn'))=="n"){
							$this->db->update('t_gn_incomecolldoc');
						}
					}
					
					/** Cashback **/
					if(strtolower($out->get_value('cashback_yn'))=="y"){
						$this->db->reset_write();
						$this->db->set('CustomerId'	, $obcustomer->get_value('CustomerId','intval'));
						$this->db->set('Custno'		, $obcustomer->get_value('Custno1','strtoupper')); 
						$this->db->set('Cardno'		, $obcustomer->get_value('cardno','intval')); 
						$this->db->set('CampaignId'	, 5);
						$this->db->set('Amount'		, 100000);
						$this->db->set('TC'			, "0422");
						$this->db->set('Narrative'	, "PIL Cashback 100rb (".date('md').") A");
						$this->db->set('AOC'		, $obUsr->get_value('UserId','intval'));
						$this->db->set('IncomingDate'	, date('Y-m-d H:i:s'));
						$this->db->set('flagCashback'			, 1);
						
						$this->db->where('CustomerId',$obcustomer->get_value('CustomerId'));
						if($out->get_value('cashback')=="YES"){
							$this->db->update('t_gn_incomecash');
						}
					}else{
						$this->db->reset_write();
						$this->db->set('CustomerId'	, $obcustomer->get_value('CustomerId','intval'));
						$this->db->set('Custno'		, $obcustomer->get_value('Custno1','strtoupper')); 
						$this->db->set('Cardno'		, $obcustomer->get_value('cardno','intval')); 
						$this->db->set('CampaignId'	, 5);
						$this->db->set('Amount'		, 100000);
						$this->db->set('TC'			, "0422");
						$this->db->set('Narrative'	, "PIL Cashback 100rb (".date('md').") A");
						$this->db->set('AOC'		, $obUsr->get_value('UserId','intval'));
						$this->db->set('IncomingDate'	, date('Y-m-d H:i:s'));
						$this->db->set('flagCashback'			, 0);
						
						$this->db->where('CustomerId',$obcustomer->get_value('CustomerId'));
						if($out->get_value('cashback')=="YES"){
							$this->db->update('t_gn_incomecash');
						}
					}
					/** End of Cashback **/
					
					return (bool)TRUE;
			}else{
				return false;
			}
		}echo MYSQL_ERROR();
	}
}


?>