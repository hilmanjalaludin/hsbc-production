<?php
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 
class M_Combo extends EUI_Model
{

/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
 
private static $Intance = null;

/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
 
public function M_Combo()
{
	$this -> load -> model(array(
		'M_SetCampaign', 'M_SetProduct', 'M_SetCallResult', 
		'M_SysUser', 'M_SetResultQuality','M_SetResultCategory','M_CtiSkill'
	));
}

 
public function	&get_instance()
{
	if(is_null(self::$Intance) )
	{
		self::$Intance = new self();
	}
	
	return self::$Intance;
}

/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
 










function _getMaried()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('MaritalStatusCode, MaritalStatusDesc');
	$this -> db -> from('t_lk_maritalstatus');
	foreach($this -> db ->get()->result_assoc() as $rows ) {
		$_conds[$rows['MaritalStatusCode']] = $rows['MaritalStatusDesc'];
	}
	
	return $_conds;
}

/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
 

function _getSmoking()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('SmokingCode, SmokingName');
	$this -> db -> from('t_lk_smoking');
	$this -> db -> where('SmokingFlagStatus',1);
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['SmokingCode']] = $rows['SmokingName'];
	}
	
	return $_conds;
	
}



/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
 

function _getComunication()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('CommChannelId,CommChannelDesc');
	$this -> db -> from('t_lk_communications_channel');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['CommChannelId']] = $rows['CommChannelDesc'];
	}
	
	return $_conds;
}


/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
 

function _getWorkType()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('OccId, OccDesc');
	// $this -> db -> select('OccCode, OccIndonesian, OccEnglish');
	// $this -> db -> from('t_lk_occupation_code');
	$this -> db -> from('t_lk_occupation');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		// $_conds[$rows['OccCode']] = $rows['OccIndonesian'];
		$_conds[$rows['OccId']] = $rows['OccDesc'];
	}
	
	return $_conds;
}


/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
 

function _getCountry()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('CountryCode, CountryName');
	$this -> db -> from('t_lk_country');
	$this -> db -> where('CountryFlagStatus',1);
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['CountryCode']] = $rows['CountryName'];
	}
	
	return $_conds;
}
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
 

function _getSponsor()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('SponsorCode, SponsorName');
	$this -> db -> from('t_lk_sponsor');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
	$_conds[$rows['SponsorCode']] = "{$rows['SponsorCode']} - {$rows['SponsorName']}";
	}
	
	return $_conds;
}


/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
 
function _getOutboundCategory()
{
	$_conds = array();
	$_conds = $this -> M_SetResultCategory->_getOutboundCategory();
	if( is_array($_conds) )
	{
		return $_conds;
	}
	else
		return null;
}	


/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
 
function _getInboundCategory()
{
	$_conds = array();
	$_conds = $this -> M_SetResultCategory->_getInboundCategory();
	if( is_array($_conds) )
	{
		return $_conds;
	}
	else
		return null;
}	

/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
 
// function _getComplaintCategory()
// {
	// $_conds = array();
	// $_conds = $this -> M_ComplaintCategory->_getComplaintCategory();
	// if( is_array($_conds) )
	// {
		// return $_conds;
	// }
	// else
		// return null;
// }	

/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */	
function _getGender()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('GenderId, GenderIndo');
	$this -> db -> from('t_lk_gender');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['GenderId']] = $rows['GenderIndo'];
	}
	
	return $_conds;
}	

//Commit b73f81a1db5023ca9080ec9a0c3398daf3ef38f2 23 januari 2020
 function _getAccStatus()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('CallReasonCategoryId, CallReasonCategoryName');
	$this -> db -> from('t_lk_callreasoncategory');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['CallReasonCategoryId']] = $rows['CallReasonCategoryName'];
	}
	
	return $_conds;
}
//END Commit b73f81a1db5023ca9080ec9a0c3398daf3ef38f2 23 januari 2020

  function _getReasonSchedule( $ReasonId = 0 )
 {
	$_conds = array();
	//return $ReasonId;
	$this ->db->reset_select();
	$this -> db -> select('*');
	$this -> db -> from('t_lk_reason_schedule a');
	if ( $ReasonId != 0 ) {
		$this->db->where( "a.IdReason" , $ReasonId );
		$row = $this->db->get()->result();
		return $row[0]->ReasonName;
	} else {
		foreach($this -> db ->get()->result_assoc() as $rows )
		{
			$_conds[$rows['IdReason']] = $rows['ReasonName'];
		}	
		return $_conds;
	}
	
 }	

/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getCallResultInbound()
{ 
	$arr = array();
	$sql = sprintf("select a.CallReasonId, a.CallReasonDesc 
				    from t_lk_callreason a where a.CallReasonStatusFlag =%s", 1);
	$qry = $this->db->query( $sql );
	if( $qry && $qry->num_rows() ) 
		foreach( $qry->result_assoc() as $row ){
		$arr[$row['CallReasonId']] = $row['CallReasonDesc'];
	}
	return $arr;
}	

/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 public function _getRecsource($filter=array()) 
{
 $ar_recsource = array();
 $this->db->reset_select();
 $this->db->select("a.Recsource", false);
 $this->db->from("t_gn_customer a");
 
 if(isset($filter['CampaignId']))
 {
	if(is_array($filter['CampaignId'])) 
	{
		if( count( $filter['CampaignId'] ) == 1  ){
			$this->db->where( sprintf("a.CampaignId=%d", end($filter['CampaignId'])), "", false );
		}else {
			$this->db->where_in('a.CampaignId', $filter['CampaignId']);
		}
	}
	else
	{
		$this->db->where('a.CampaignId', $filter['CampaignId']);
	}
	
	//optimalisasi filter kolom 'parameter' dari menu pull data
	//jika kolom 'parameter' kosong, parameter 'islike' tidak akan dijalankan
	//dan hanya akan dijalankan jika parameter kolom 'field data'='b.Recsource' 
	
	if(($filter['istext']) && ($filter['isfield'])=="b.Recsource"){
		if(($filter['islike'])=="LIKE"){$this->db->like('a.Recsource', $filter['istext']);}else{$this->db->not_like('a.Recsource', $filter['istext']);}
	}
 }
 
 
 $this->db->where( sprintf("a.expired_date>='%s'", date('Y-m-d')), "", false);
 $this->db->group_by("a.Recsource"); 
 
 if( mysql_errno() ){
	 return $ar_recsource();
 }
  // $this->db->print_out();
  // print_r($filter);
 $rs = $this->db->get();
 #var_dump( $this->db->last_query() );die();

 if( $rs->num_rows()>  0  ) 
	 foreach( $rs->result_assoc() as $rows )
 {
	$ar_recsource[$rows['Recsource']] = $rows['Recsource'];
 }
 return (array)$ar_recsource;
 
}


/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getCallResultOutbound()
{ 
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select("a.CallReasonId,a.CallReasonDesc"); 
	$this -> db -> from("t_lk_callreason  a ");
	$this -> db -> join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId","LEFT");
	$this -> db -> join("t_lk_outbound_goals c ","b.CallOutboundGoalsId=c.OutboundGoalsId","LEFT");
	$this -> db -> where("c.Name","outbound");
	
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['CallReasonId']] = $rows['CallReasonDesc'];
	}
	
	return $_conds;
}	


/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getPaymentMode()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('PayModeId, PayMode');
	$this -> db -> from('t_lk_paymode');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['PayModeId']] = $rows['PayMode'];
	}
	
	return $_conds;
}	
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
// function _getScoreStatus()
// {
	// $_conds = array();
	// $this -> db -> select('ScoreId, ScoreName');
	// $this -> db -> from('t_lk_score_status');
	// $this -> db -> where('ScoreFlags',1);
	
	// foreach($this -> db ->get()->result_assoc() as $rows )
	// {
		// $_conds[$rows['ScoreId']] = $rows['ScoreName'];
	// }
	
	// return $_conds;
// }
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getPaymentType()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('PaymentTypeId, PaymentTypeDesc');
	$this -> db -> from('t_lk_paymenttype');
	$this -> db -> where('Active',1);
	
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['PaymentTypeId']] = $rows['PaymentTypeDesc'];
	}
	
	return $_conds;
}	
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getCardType()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('CardTypeId, CardTypeDesc');
	$this -> db -> from('t_lk_cardtype');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['CardTypeId']] = $rows['CardTypeDesc'];
	}
	
	return $_conds;
}
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getPremiGroup()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('PremiumGroupId,PremiumGroupDesc');
	$this -> db -> from('t_lk_premiumgroup');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['PremiumGroupId']] = $rows['PremiumGroupDesc'];
	}
	
	return $_conds;
}
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getBank()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('BankId,BankName');
	$this -> db -> from('t_lk_bank');
	$this -> db -> where('BankStatusFlag',1);
	
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['BankId']] = $rows['BankName'];
	}
	
	return $_conds;
}

/*
 * @ def 	: _getOrderStatus
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
// function _getOrderStatus()
// {
	// $_conds = array();
	// $this -> db -> select('OrderStatusId, StatusName');
	// $this -> db -> from('t_lk_order_status');
	// foreach($this -> db ->get()->result_assoc() as $rows )
	// {
		// $_conds[$rows['OrderStatusId']] = $rows['StatusName'];
	// }
	
	// return $_conds;
// }


/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getProvince()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('ProvinceId, Province');
	$this -> db -> from('t_lk_province');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['ProvinceId']] = $rows['Province'];
	}
	
	return $_conds;
}

/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getRealtionship()
{
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('RelationshipTypeId, RelationshipTypeDesc');
	$this -> db -> from('t_lk_relationshiptype');
	$this -> db -> where('RelationshipTypeFlags',1);
	
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['RelationshipTypeId']] = $rows['RelationshipTypeDesc'];
	}
	
	return $_conds;
}
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getSalutation()
{
	$_conds = array();
	$this ->db->reset_select();
	$this ->db-> select('SalutationId, Salutation');
	$this ->db->from('t_lk_salutation');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['SalutationId']] = $rows['Salutation'];
	}
	
	return $_conds;
}

/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getProductCurrency()
{
	$_conds = array();
	$this ->db->reset_select();
	$this ->db-> select('CurrId, CurrCode, CurrName', false);
	$this ->db->from('t_lk_currency');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['CurrCode']] = "{$rows['CurrCode']} - {$rows['CurrName']}";
	}
	
	return $_conds;
}
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getProductType()
{
	$_conds = array();
	$this ->db->reset_select();
	$this ->db-> select('ProductTypeId, ProductFormJs');
	$this ->db->from('t_lk_producttype');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['ProductTypeId']] = $rows['ProductFormJs'];
	}
	
	return $_conds;
}


/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getDirectionType()
{
	$_conds = array();
	$this -> db -> select('ActionCode,ActionName');
	$this -> db -> from('t_lk_direction_action');
	foreach($this -> db ->get()->result_assoc() as $rows ){
		$_conds[$rows['ActionCode']] = $rows['ActionName'];
	}
	
	return $_conds;
}

// get UserAgent 

function _getUser()
{
	$_conds = array();
	if(class_exists('M_SysUser')){
		$_conds = $this ->M_SysUser->_get_teleamarketer();
	}
	
	return $_conds;
}

// get All User On database  

function _getAllUser()
{
	$_conds = array();
	if(class_exists('M_SysUser')){
		$_conds = $this ->M_SysUser->_get_select_all_user();
	}
	
	return $_conds;
}

// get _getProduct 

function _getProduct()
{
	$_conds = array();
	
	if(class_exists('M_SetProduct')){
		$Product = $this -> M_SetProduct -> _getProductId();
		foreach($Product as $keys => $rows )
		{
			$_conds[$keys] = $rows['name'];
		}
	}
	
	return $_conds;
}


// get _getCampaign 

function _getCampaign()
{
	$_conds = array();
	if( class_exists('M_SetCampaign')) {
		$_conds = $this->M_SetCampaign->_get_campaign_name();
	}
	return $_conds;
}


// get _getCallResult 

function _getCallResult()
{
	$_conds = array();
	
	if( class_exists('M_SetCallResult') ){
		$_list = $this->M_SetCallResult->_getCallReasonId(null);
		
		if( is_array($_list) ) 
		{
			foreach($_list as $k => $rows )
			{
				$_conds[$k] = $rows['name'];
			}
		}
	}
	
	return $_conds;
}


// get _getCallResult 

function _getCallResultByCategory( $cetegoryId = 0 )
{
	$_conds = array();
	
	if( class_exists('M_SetCallResult') )
	{
		$_list = $this->M_SetCallResult->_getCallReasonId( $cetegoryId  );
		if( is_array($_list) ) 
		{
			foreach($_list as $k => $rows )
			{
				$_conds[$k] = $rows['name'];
			}
		}
	}
	return $_conds;
}

// get approval status 

function _getQualityResult()
{
	$_conds = array();
	if( class_exists('M_SetResultQuality') ){
		$_list = $this->M_SetResultQuality->_getQualityResult();
		if( is_array($_list) ) 
		{
			foreach($_list as $k => $rows )
			{
				$_conds[$k] = $rows['name'];
			}
		}
	}
	
	return $_conds;
}


/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 function _getSerialize()
 {
	$data = array();
	$list = get_class_methods($this);
	foreach($list as $key => $Method )
	{
		$_key= substr($Method,4,strlen($Method));
		$data[$_key] = $Method;
	}
	
	return $data;
 }
 
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 
 function _getIdentification()
 {
	$_conds = array();
	$this ->db->reset_select();
	$this -> db -> select('*');
	$this -> db -> from('t_lk_identificationtype');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['IdentificationTypeId']] = $rows['IdentificationType'];
	}
	
	return $_conds;
	
 }	
  
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
  
 function _getBillingAddress()
 {
	$_conds = array();
	$this ->db->reset_select();
	$this->db->select('BilingId, BilingDescription');
	$this->db->from('t_lk_billingaddress');
	$this->db->where('BilingFlagsStatus',1);
	
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['BilingId']] = $rows['BilingDescription'];
	}
	
	return $_conds;
	
 } 
 
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 
// function _getComplaintStatus()
// {
	// $_conds = array();
	// $this->db->select('a.id, a.StatusName');
	// $this->db->from('t_lk_complaint_status a');
	// $this->db->where('a.flags',1);
	
	// foreach($this -> db ->get()->result_assoc() as $rows )
	// {
		// $_conds[$rows['id']] = $rows['StatusName'];
	// }
	
	// return $_conds;
	
// }
 
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 
 
  function _getCallDirection()
 {
	$_conds = array();
	$this ->db->reset_select();
	$this->db->select('OutboundGoalsId, Description');
	$this->db->from('t_lk_outbound_goals');
	$this->db->where('Flags',1);
	
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['OutboundGoalsId']] = $rows['Description'];
	}
	
	return $_conds;
	
 } 
 
  
 
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 
 
  function _getAgentGroup()
 {
	$_conds = array();
	$this ->db->reset_select();
	$this->db->select('id, description');
	$this->db->from('cc_agent_group');
	$this->db->where('status_active',1);
	
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['id']] = $rows['description'];
	}
	
	return $_conds;
	
 }
 
 function _getAvailalblePDSGroup($groupId=null)
 {
	$_conds = array();
	$this->db->reset_select();
	$this->db->select('id, description');
	$this->db->from('cc_agent_group');
	$this->db->where('status_active',1);
	if($groupId){
		$this->db->where('id',$groupId);
	}
	$this->db->where('id>1');
	
	foreach($this->db->get()->result_assoc() as $rows ){
		$cc_groups[$rows['id']] = $rows['description'];
	}
	
	$this ->db->reset_select();
	$this->db->select('distinct b.CcGroup, a.description');
	$this->db->from('cc_agent_group a');
	$this->db->join('t_gn_campaign_pds b', 'a.id = b.CcGroup', 'inner');
	$this->db->where('CcGroup IS NOT NULL');
	
	foreach($this -> db ->get()->result_assoc() as $rows ){
		$tms_groups[$rows['CcGroup']] = $rows['description'];
	}
	
	if(!$groupId){
		$_conds = array_diff ( $cc_groups , $tms_groups);
		if(!$_conds){
			$_conds=$cc_groups;
		}
	}else{
		$_conds = $cc_groups;
	}
	
	return $_conds;
	
 }

 
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 
 
  function _getAgentId()
 {
	$_conds = array();
	$this ->db->reset_select();
	$this->db->select('a.id, a.name');
	$this->db->from('cc_agent a');
	$this->db->join('tms_agent b', 'a.userid = b.id','INNER');
	
    if( in_array( _get_session('UserId'), array(USER_ROOT) )) {	
		$this->db->where('b.handling_type IS NOT NULL',"", FALSE);
    } else{
		$this->db->where_not_in('b.handling_type', array(USER_ROOT));
	}
	
	$this->db->order_by('a.name', 'ASC');
	foreach($this -> db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['id']] = $rows['name'];
	}
	
	return $_conds;
	
 }
 
 
/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
  function _getProductPlanName( $ProductId = null )
 {
	$arr_data = array();
	
	$this->db->reset_select();
	$this->db->select(
		"a.ProductPlan, 
		IF(b.ProductPlanName IS NULL, a.ProductPlanName, b.ProductPlanName) as ProductPlanName", FALSE);
	$this->db->from("t_gn_productplan a");
	$this->db->join("t_gn_plan_name b ","a.ProductPlan=b.ProductPlanId AND a.ProductId=b.ProductId", "LEFT");
	
	 if( !is_null($ProductId) )
	{
		$this->db->where("a.ProductId", $ProductId);
	 }
	 
	$this->db->group_by("a.ProductPlanName");
	$this->db->order_by("a.ProductPlanName", "ASC");
	
	$rs = $this->db->get();
	if( $rs->num_rows() > 0 ) 
		foreach( $rs->result_assoc() as $rows ) {
		$arr_data[$rows['ProductPlan']] = $rows['ProductPlanName']; 	
	}
	return (array)$arr_data;
 }
 
 
 
 /*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 function _getUserPrivilege()
{
	$arr_user_privileges = array();
	$this->db->reset_select();
	$this->db->select("a.id, a.name ");
	$this->db->from("tms_agent_profile a ");
	$this->db->where("a.IsActive", 1);
	$this->db->order_by("a.id", "ASC");
	
	$rs = $this->db->get();
	if( $rs -> num_rows() > 0 ) 
		foreach( $rs->result_assoc() as $rows ) 
	{
		$arr_user_privileges[$rows['id']] = $rows['name'];	
	}
	return (array)$arr_user_privileges;
 }
 
 /*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 function _getCallResultTransfer()
{
  if( class_exists('M_SetCallResult') )
 {
	 $out =& get_class_instance('M_SetCallResult');
	 return $out->_getCallResultTransfer();
  } else{
	  return array();
  }
  
}
 /*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 
 function _getQualityScoreStaff()
{
  //
  $arr_quality_score_register = array();
  
  $this->load->model(array('M_SysUser','M_QtySetAgent'));	
  
 //--------- instance of class ------------------------------
 
  $User =& get_class_instance('M_SysUser');
  $Quality = & get_class_instance('M_QtySetAgent');
  
 // -------------------------------------------------------------
   $arr_all_quality  =& $User->_get_quality_staff();
   $arr_reg_quality = & $Quality->_select_row_quality_score_register();
  
 // ---------- return -----------------
	if( is_array( $arr_all_quality ) )
		foreach( $arr_all_quality as $UserId => $val )
	{
		if( @in_array( $UserId, $arr_reg_quality))
		{
			$arr_quality_score_register[$UserId] = $val;
		}		
	}
	
	return (array)$arr_quality_score_register;
}


 /*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 
 function _getQualityAllStaff()
{
  //
  $arr_all_quality = array();
  
  $this->load->model(array('M_SysUser'));	
  
 //--------- instance of class ------------------------------
 
  $User =& get_class_instance('M_SysUser');
  $Quality = & get_class_instance('M_QtySetAgent');
  
 // -------------------------------------------------------------
  $arr_all_quality  =& $User->_get_quality_staff();
  return (array)$arr_all_quality;
}

/*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 
 function _getTeamLeader()
{
  //
  $arr_all_spv = array();
  
  $this->load->model(array('M_SysUser'));	
  
 //--------- instance of class ------------------------------
 
  $User =& get_class_instance('M_SysUser');
  
 // -------------------------------------------------------------
  $arr_all_spv  =& $User->_get_teamleader();
  return (array)$arr_all_spv;
}

function _getSPV()
{
  //
  $arr_all_spv = array();
  
  $this->load->model(array('M_SysUser'));	
  
 //--------- instance of class ------------------------------
 
  $User =& get_class_instance('M_SysUser');
  
 // -------------------------------------------------------------
  $arr_all_spv  =& $User->_get_supervisor();
  return (array)$arr_all_spv;
}


 function _getATMTeamLeader()
{
  //
  $arr_all_spv = array();
  
  $this->load->model(array('M_SysUser'));	
  
 //--------- instance of class ------------------------------
 
  $User =& get_class_instance('M_SysUser');
  
 // -------------------------------------------------------------
  $arr_all_spv  =& $User->_get_atmleader();
  return (array)$arr_all_spv;
}



 /*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 function _getLayoutThemes()
{
  $this->load->model(array('M_SysThemes'));	
  if( class_exists('M_SysThemes') )
 {
	 return $this->M_SysThemes->_getUserThemes();
  } else{
	  return array();
  }
  
}
 /*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
 function _getQualitySkill()
{
  $this->load->model(array('M_QtyStaffGroup'));	
  if( class_exists('M_QtyStaffGroup') )
 {
	 return $this->M_QtyStaffGroup->_getStaffSkill();
  } else{
	  return array();
  }
  
}
 /*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getAdditionalPhone( $CustomerId = 0 )
{ 
  /**$arr_result = array();
  $this->db->reset_select();
  $this->db->select("a.AddPhoneNumber, a.AddPhoneNumber, b.PhoneDesc", FALSE);
  $this->db->from("t_gn_addphone  a ");
  $this->db->join("t_lk_phonetype b ","a.AddPhoneType=b.PhoneType", "LEFT");
  $this->db->where("a.CustomerId", $CustomerId);
  $rs = $this->db->get();
  if( $rs->num_rows() > 0 ) foreach( $rs->result_assoc() as $rows ){
	  
	  $arr_result[$rows['AddPhoneNumber']] = join(" ", array($rows['PhoneDesc'], _setMasking($rows['AddPhoneNumber'])));
  }
  
  return (array)$arr_result;*/
  
  $arr_result = array();
  $this->db->reset_select();
  $this->db->select("a.ApprovalNewValue, a.ApprovalNewValue, b.PhoneDesc", FALSE);
  $this->db->from("t_gn_approvalhistory  a ");
  $this->db->join("t_lk_phonetype b ","a.ApprovePhoneType=b.PhoneType", "LEFT");
  $this->db->where("a.CustomerId", $CustomerId);
  $this->db->where("a.ApprovalApprovedFlag", 1);
  $rs = $this->db->get();
  if( $rs->num_rows() > 0 ) foreach( $rs->result_assoc() as $rows ){
	  
	  $arr_result[$rows['ApprovalNewValue']] = join(" ", array($rows['PhoneDesc'], _setMasking($rows['ApprovalNewValue'])));
  }
  
  return (array)$arr_result;
  
}
 /*
 * @ def 	: index / default page on this controller
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
function _getAllUserIdByLevel( $level = null )
{
	//
  $arr_all_spv = array();
  
  $this->load->model(array('M_SysUser'));	
  
 //--------- instance of class ------------------------------
 
  $User =& get_class_instance('M_SysUser');
 // -------------------------------------------------------------
  $arr_all_spv  =& $User->_select_row_user_id_by_level( $level );
  return (array)$arr_all_spv;
  
}

// ---------------------------------------------------------------------
/*
 * @ package : list on Minute 
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
public function _getListHour()
{
  $arr_list_hour = array();	
  $start_hour = 0;  $end_hour = 24;
  for( $i = 0; $i<=$end_hour; $i++)
  {
	  $list_val = "";
	  if( strlen($i) == 1 ){
		  $list_val ="0$i"; 
	  } else {
		  $list_val ="$i";
	  }
	  
	  $arr_list_hour[(string)$list_val] = (string)$list_val;
  }  
  return (array)$arr_list_hour;
  
} 

// ---------------------------------------------------------------------
/*
 * @ package : list on Minute 
 * ----------------------------------------------------
 * @ param  : $_POST
 * @ author : razaki team
 * 
 */
public function _getListMinute()
{
  $arr_list_hour = array();	
  $start_hour = 0;  $end_hour = 60;
  for( $i = 0 ; $i<=$end_hour; $i++)
  {
	  $list_val = "";
	  if( strlen($i) == 1 ){
		  $list_val ="0$i"; 
	  } else {
		  $list_val ="$i";
	  }
	  
	  $arr_list_hour[(string)$list_val] = (string)$list_val;
  }  
  return (array)$arr_list_hour;
  
}


// ------------- get Group Premi ----------------------
function _getProductGroupPremi( $ProductId = 0 )
{
	$arr_product_group_premi = array();
	
	$this->db->reset_select();
	$this->db->select("b.PremiumGroupId, b.PremiumGroupDesc", FALSE);
	$this->db->from("t_gn_productplan a ");
	$this->db->join("t_lk_premiumgroup b "," a.PremiumGroupId=b.PremiumGroupId", "LEFT");
	$this->db->where("a.ProductId", (int)$ProductId);
	$this->db->group_by("a.PremiumGroupId");
	$this->db->order_by("b.PremiumGroupOrder", "ASC");
	
	//echo $this->db->print_out();
	
	$rs = $this->db->get();
	if( $rs->num_rows() > 0 ) foreach( $rs ->result_assoc() as $rows )
	{
		$arr_product_group_premi[$rows['PremiumGroupId']] = ucwords($rows['PremiumGroupDesc']);
	}
	
	return (array)$arr_product_group_premi;
}

// ------------ get Gender by Product -------------------

function _getProductGender( $ProductId = 0 )	
{
	$arr_product_gender = array();
	$this->db->reset_select();
	$this->db->select("b.GenderId, b.Gender", FALSE);
	$this->db->from("t_gn_productplan a ");
	$this->db->join("t_lk_gender b "," a.GenderId=b.GenderId", "LEFT");
	$this->db->where("a.ProductId", (int)$ProductId);
	$this->db->group_by("a.GenderId");
	$this->db->order_by("b.GenderId", "ASC");
	
	$rs = $this->db->get();
	if( $rs->num_rows() > 0 ) foreach( $rs ->result_assoc() as $rows )
	{
		$arr_product_gender[$rows['GenderId']] = ucfirst(strtolower($rows['Gender']));
	}
	
	return (array)$arr_product_gender;
	
}


// ------- update on here ------------------
// ------------ get Gender by Product -------------------

 function _getQualityStatus()	
{
 $arr_quality_status = array();
 $this->db->reset_select();
 $this->db->select("a.ApproveId, a.AproveName,
	( SELECT COUNT(ts.ApproveId) from t_lk_aprove_status  ts where ts.ApproveParent = a.ApproveId ) as tot ", 
	FALSE);
	
 $this->db->from("t_lk_aprove_status a");
 $this->db->where("a.AproveFlags", 1);
 $this->db->where("a.ApproveParent",0);
 
	
/*	
 $this->db->from("t_lk_aprove_status a");
 $this->db->where("a.AproveFlags", 1);
 $this->db->having("tot", 0);
 
 */
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	 foreach( $rs ->result_assoc() as $rows ) 
 {
	$arr_quality_status[$rows['ApproveId']] = ucfirst(strtolower($rows['AproveName']));
 }
	
	return (array)$arr_quality_status;
	
}


// ------------ get Gender by Product -------------------

 function _getQualityParentStatus( $QualityId = 0 )	
{
 $arr_quality_status = 0;
 $this->db->reset_select();
 $this->db->select("(select qta.ApproveId from t_lk_aprove_status qta where qta.ApproveId=a.ApproveParent ) as ApproveId", FALSE);
 $this->db->from("t_lk_aprove_status a");
 $this->db->where("a.AproveFlags", 1);
 $this->db->where("a.ApproveId", $QualityId);
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
{
	$arr_quality_status  = $rs->result_singgle_value();
 }
 
 if( $arr_quality_status == 0 ){
  return (int)$QualityId;
 }	
  return (int)$arr_quality_status;
	
}


// ------------ get Gender by Product -------------------

function _getQualityReason( $ParentId = null )	
{
 
 $arr_quality_status = array();
 $this->db->reset_select();
 $this->db->select("a.ApproveId, a.AproveName ", FALSE);
 $this->db->from("t_lk_aprove_status a");
 // $this->db->where_not_in("a.ApproveParent",array(0));
 if( !is_null( $ParentId) 
	AND $ParentId >  0 )
 {
	$this->db->where("a.ApproveParent",$ParentId);
 }
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	 foreach( $rs ->result_assoc() as $rows ) 
 {
	$arr_quality_status[$rows['ApproveId']] = $rows['AproveName'];
 }
	
 return (array)$arr_quality_status;
 
}

// ------------ get Gender by Product -------------------

function _getQualitySuspend( $ParentId = null )	
{
 $Quality =& get_class_instance('M_SetResultQuality');
 return (array)$arr_quality_status;
 
}

// ------------ get Gender by Product -------------------

 function _getCtiSkill()
{
  $objClass =& get_class_instance('M_CtiSkill');
  return (array)$objClass->getSelectSkillUser(); 	
}



// ------------ get Gender by Product -------------------

 function _getCallDuration( $CustomerId = null )	
{
  
  $duration = 0;
  $this->db->reset_select();
  $this->db->select("SUM(a.duration) as Duration",false);
  $this->db->from("cc_recording a ");
  $this->db->where("a.assignment_data", $CustomerId);
  $this->db->group_by("a.assignment_data");
	
  $rs = $this->db->get();
  if( $rs->num_rows() > 0 ){
	$duration = $rs->result_singgle_value();
  }
  
  if(function_exists('_getDuration') ){
	return ( $duration ? _getDuration($duration) : '00:00:00');
  } else {
	  return ( $duration ? $duration : '00:00:00');
  }
}


// ------------- get Group Gender ------------------------
 function _getFieldValue()
{
	$arr_value = array();
	$this->db->reset_select();
	$this->db->select("a.ConfigName, a.ConfigValue", FALSE);
	$this->db->from("t_lk_configuration a ");
	$this->db->where("a.ConfigCode", "FLT_VALUE_DATA");
	
	$this->db->where("a.ConfigFlags", 1);
	$this->db->order_by("a.ConfigSort", "ASC");
	
	$rs = $this->db->get();
	if( $rs->num_rows() > 0 ) 
		foreach( $rs->result_assoc() as $rows )
	{
		$arr_value[$rows['ConfigName']] = lang($rows['ConfigValue']);
	}
	
	return $arr_value;
}


// ------------- get Group Gender ------------------------

 function _getFilterValue()
{
	$arr_value = array();
	$this->db->reset_select();
	$this->db->select("a.ConfigName, a.ConfigValue", FALSE);
	$this->db->from("t_lk_configuration a ");
	$this->db->where("a.ConfigCode", "FLT_FIELD_DATA");
	$this->db->where("a.ConfigFlags", 1);
	$rs = $this->db->get();
	if( $rs->num_rows() > 0 ) 
		foreach( $rs->result_assoc() as $rows )
	{
		$arr_value[$rows['ConfigName']] = $rows['ConfigValue'];
	}
	
	return $arr_value;
}

// ---------------- select call status Not In Interested data --> 
function _getCallResultNotInterest()
{
	
 $arr_value = array();	
 $this->db->reset_select();
 $this->db->select("a.CallReasonId, a.CallReasonDesc ", FALSE);
 $this->db->from("t_lk_callreason a ");
 $this->db->join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId", "INNER");
 $this->db->where_not_in("b.CallReasonCategoryCode",array('600'));
 $this->db->where("a.CallReasonStatusFlag", 1);
 $this->db->where("a.CallReasonId <> 13");
// $this->db->print_out();
 
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	foreach( $rs->result_assoc() as $rows )
 {
	$arr_value[$rows['CallReasonId']] = $rows['CallReasonDesc'];
 }
	
 return $arr_value;
 
}

function _getCallResultNotInterestPDS()
{
	
 $arr_value = array();	
 $this->db->reset_select();
 $this->db->select("a.CallReasonId, a.CallReasonDesc ", FALSE);
 $this->db->from("t_lk_callreason a ");
 $this->db->join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId", "INNER");
 $this->db->where_in("b.CallReasonCategoryId",array(7,10,8,9));
 $this->db->where("a.CallReasonStatusFlag", 1);
 $this->db->where("a.CallReasonId <> 13");
// $this->db->print_out();
 
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	foreach( $rs->result_assoc() as $rows )
 {
	$arr_value[$rows['CallReasonId']] = $rows['CallReasonDesc'];
 }
	
 return $arr_value;
 
}

// ---------------- select call status Not In Interested data --> 

function _getCallResultNotInterestThinkingBadlead()
{
	
 $arr_value = array();	
 $this->db->reset_select();
 $this->db->select("a.CallReasonId, a.CallReasonDesc ", FALSE);
 $this->db->from("t_lk_callreason a ");
 $this->db->join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId", "INNER");
 $this->db->where_not_in("b.CallReasonCategoryCode",array('600'));
 $this->db->where_not_in("a.CallReasonLater",array(1));
 $this->db->where_not_in("a.CallReasonNoMoreFU",array(1));
 $this->db->where("a.CallReasonStatusFlag", 1);
 $this->db->order_by("a.CallReasonDesc", "ASC");
 
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	foreach( $rs->result_assoc() as $rows )
 {
	$arr_value[$rows['CallReasonId']] = $rows['CallReasonDesc'];
 }
	
 return $arr_value;
 
}

// ---------------- select call status Not In Interested data --> 

function _getCallResultNotInterestBadlead()
{
	
 $arr_value = array();	
 $this->db->reset_select();
 $this->db->select("a.CallReasonId, a.CallReasonDesc ", FALSE);
 $this->db->from("t_lk_callreason a ");
 $this->db->join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId", "INNER");
 // $this->db->where_not_in("b.CallReasonCategoryCode",array('600'));
 $this->db->where_not_in("a.CallReasonNoMoreFU",array(1));
 $this->db->where("a.CallReasonEvent", 0);
 $this->db->where("a.CallReasonStatusFlag", 1);
 $this->db->order_by("a.CallReasonDesc", "ASC");
 
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	foreach( $rs->result_assoc() as $rows )
 {
	$arr_value[$rows['CallReasonId']] = $rows['CallReasonDesc'];
 }
	
 return $arr_value;
 
}

function _getAllCallResult(){
	$arr_value = array();	
	$this->db->reset_select();
	$this->db->select("a.CallReasonId, a.CallReasonDesc ", FALSE);
	$this->db->from("t_lk_callreason a ");
	$this->db->join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId", "INNER");
	$this->db->where("a.CallReasonStatusFlag", 1);
	$this->db->order_by("a.CallReasonDesc", "ASC");

	$rs = $this->db->get();
	if( $rs->num_rows() > 0 ) 
	foreach( $rs->result_assoc() as $rows )
	{
	$arr_value[$rows['CallReasonId']] = $rows['CallReasonDesc'];
	}

	return $arr_value;
}

 function _getCallResultAuto()
{
 $arr_value = array();	
 $this->db->reset_select();
 $this->db->select("a.CallReasonId, a.CallReasonDesc ", FALSE);
 $this->db->from("t_lk_callreason a ");
 $this->db->join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId", "INNER");
 // $this->db->where_not_in("b.CallReasonCategoryCode",array('600'));
 $this->db->where_in("a.CallReasonAutoDial",array(1));
 $this->db->where("a.CallReasonStatusFlag", 1);
 $this->db->order_by("a.CallReasonDesc", "ASC");
 
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	foreach( $rs->result_assoc() as $rows )
 {
	$arr_value[$rows['CallReasonId']] = $rows['CallReasonDesc'];
 }
	
 return $arr_value;
 
}

// ---------------- select call status Not In Interested data --> 

 function _getCallResultThinking()
{
 $arr_value = array();	
 $this->db->reset_select();
 $this->db->select("a.CallReasonId, a.CallReasonDesc ", FALSE);
 $this->db->from("t_lk_callreason a ");
 $this->db->join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId", "INNER");
 $this->db->where_not_in("b.CallReasonCategoryCode",array('600'));
 $this->db->where_in("a.CallReasonLater",array(1));
 $this->db->where("a.CallReasonStatusFlag", 1);
 $this->db->order_by("a.CallReasonDesc", "ASC");
 
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	foreach( $rs->result_assoc() as $rows )
 {
	$arr_value[$rows['CallReasonId']] = $rows['CallReasonDesc'];
 }
	
 return $arr_value;
 
}

// ---------------- select call status Not In Interested data --> 
function _getCallResultInterest()
{
	
 $arr_value = array();	
 $this->db->reset_select();
 $this->db->select("a.CallReasonId, a.CallReasonDesc ", FALSE);
 $this->db->from("t_lk_callreason a ");
 $this->db->join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId", "INNER");
 // $this->db->where_in("b.CallReasonCategoryCode",array('600'));
 $this->db->where_in("a.CallReasonEvent",array(1));
 $this->db->where("a.CallReasonStatusFlag", 1);
 
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	foreach( $rs->result_assoc() as $rows )
 {
	$arr_value[$rows['CallReasonId']] = $rows['CallReasonDesc'];
 }
	
 return $arr_value;
 
}

// ---------------- select call status Not In Interested data --> 

 function _getSelectFilterBy()
{
 $arr_value = array();	
 $this->db->reset_select();
 $this->db->select("a.ConfigName as ValId, a.ConfigValue as ValText ");
 $this->db->from("t_lk_configuration a ");
 $this->db->where_in("a.ConfigCode",array('FLT_VALUE_PHONE'));
 $this->db->where_in("a.ConfigFlags", array(1));
 
  $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	foreach( $rs->result_assoc() as $rows )
 {
	$arr_value[$rows['ValId']] = $rows['ValText'];
 }
	
 return $arr_value;
 
}

// ------------ select premi type -----------------------
function _getPremiType()
{
 $arr_premi_type = array();
 $this->db->reset_select();
 $this->db->select("*", false);
 $this->db->from("t_lk_premitype");
 $this->db->where("PremiTypeFlags", 1);
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	foreach( $rs ->result_assoc() as $rows )
 {
	$arr_premi_type[$rows['PremiTypeId']] =  $rows['PremiTypeName'];
 }
 return (array)$arr_premi_type;
 
}	

function _getConfiguration($_code=null,$_name=null)
{
	$_datas = array();
	
	if( !is_null($_code) )
	{
		$this->db->reset_select();
		$this->db->select("*", false);
		$this->db->from("t_lk_configuration");
		$this->db->where("ConfigCode", $_code);
		$this->db->where("ConfigFlags", 1);
		
		if( !is_null($_name) )
		{
			$this->db->where("ConfigName", $_name);
		}
		
		$rs = $this->db->get();
		if( $rs->num_rows() > 0 )
		{		
			foreach( $rs ->result_assoc() as $rows )
			{
				$_datas[$rows['ConfigName']] =  $rows['ConfigValue'];
			}
		}
	}
	
	return $_datas;
}

function _getDisagree($_cmp)
{
	$_datas = array();
	
	if( !is_null($_cmp) )
	{
		$sql = "select DisagreeId, DisagreeCode, DisagreeDesc from t_lk_disagree
				where DisagreeFlag=1
				and CampaignId='".$_cmp."'";
		$qry = $this->db->query($sql);
		
		if($qry->num_rows()>0)
		{
			foreach($qry->result_assoc() as $rows)
			{
				$_datas[$rows['DisagreeId']] = $rows['DisagreeCode'].' - '.$rows['DisagreeDesc'];
			}
		}
	}
	
	return $_datas;
}

function _getApproveStatusQA()
{
	$datas = array();
	
	$sql = "select ApproveId, AproveName from t_lk_aprove_status
			where 1=1
			and (ApproveEskalasi=1 or AproveVeryfied=1)";
	$qry = $this->db->query($sql);
		
	if($qry->num_rows()>0)
	{
		foreach($qry->result_assoc() as $rows)
		{
			$datas[$rows['ApproveId']] = $rows['AproveName'];
		}
	}
	
	return $datas;
}

function _getApproveStatusTMR()
{
	$datas = array();
	
	$sql = "select ApproveId, AproveName from t_lk_aprove_status
			where 1=1
			and (HoldFlag=1 or ConfirmFlags=1 or CancelFlags=1)";
	$qry = $this->db->query($sql);
		
	if($qry->num_rows()>0)
	{
		foreach($qry->result_assoc() as $rows)
		{
			$datas[$rows['ApproveId']] = $rows['AproveName'];
		}
	}
	
	return $datas;
}

 /**
  * [_getDetailCustomer description]
  * @param  [type] $CustomerId [description]
  * @return [type]             [description]
  */
  
function _getApprovalParam($_cmp)
{
	$_datas = array();
	
	if( !is_null($_cmp) )
	{
		$sql = "select * from t_gn_approval_param
				where CampaignId='".$_cmp."'
				order by ParamOrder ASC";
		$qry = $this->db->query($sql);
		
		if($qry->num_rows()>0)
		{
			$_datas = $qry->result_assoc();
		}
	}
	
	return $_datas;
}

 /**
  * [_getDetailCustomer description]
  * @param  [type] $CustomerId [description]
  * @return [type]             [description]
  */
  
 function _getCallDisposition( $dispositionID = 0  )
{
  
 // set default on list data OK 
 $list = array(); 
 
 // set query selector with method_exists
 // sprintf function 
 
 $sql = sprintf("SELECT 
					c.DSP_Current_Id as DSP_Next_Id, 
					c.DSP_Current_Kode as DSP_Next_Kode, 
					d.CallReasonDesc as DSP_Next_Desc 
					from t_lk_disposition c 
					left join t_lk_callreason d on c.DSP_Current_Id=d.CallReasonId
					where c.DSP_Current_Id='%s'
				UNION 
				SELECT 
					a.DSP_Next_Id as DSP_Next_Id, 
					a.DSP_Next_Kode as DSP_Next_Kode, 
					b.CallReasonDesc as DSP_Next_Desc 
					from t_lk_disposition a 
					left join t_lk_callreason b on a.DSP_Next_Id=b.CallReasonId
					where a.DSP_Current_Id='%s'
					and b.CallReasonStatusFlag=1 ", $dispositionID,  $dispositionID);

// result on query data process record by object 
// test on new framwork 
					
 $qry = $this->db->query( $sql );
 if( $qry && $qry->num_rows() > 0 ) 
 foreach( $qry->result_record() as $row ){
	$list[$row->field('DSP_Next_Id')]  = $row->field('DSP_Next_Desc');
 }
 
 return (array)$list;
}


 /**
  * [_getDetailCustomer description]
  * @param  [type] $CustomerId [description]
  * @return [type]             [description]
  */
function _getDisagreeData( $CampaignId=0, $ReasonId = 0 ) 
{
	
 $arDisagree = array();
 $sql = sprintf("select a.DisagreeId, a.DisagreeCode, a.DisagreeDesc 
				 from t_lk_disagree a
				 where a.DisagreeFlag = 1 
				 and a.CampaignId  = '%d' 
				 and a.CallreasonId = '%d'
				 order by a.DisagreeOrder ASC", $CampaignId, $ReasonId );
	
	
 $qry = $this->db->query( $sql );
 if( $qry && $qry->num_rows() > 0 ) 
	foreach( $qry->result_record() as $row ){
	$arDisagree[$row->field('DisagreeId')]  = sprintf("%s - %s", $row->field( 'DisagreeCode' ),
 																 $row->field( 'DisagreeDesc' ) );
 }
	return (array)$arDisagree;
 
}

/**
* @BAP
* (F) _getCallResultNotInterestBadlead [get status call AUTO DIAL]
*
* @return Array $arr_value
*/
function _getCallStatusAutoDial()
{
	$arr_value = array();
	$category  = array(1,7,10);	
 	$this->db->reset_select();
 	$this->db->select("a.CallReasonId, a.CallReasonDesc");
 	$this->db->from("t_lk_callreason a ");
	$this->db->join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId", "INNER");
	$this->db->where_in("b.CallReasonCategoryId", $category);
	$rs = $this->db->get();

 	if( $rs->num_rows() > 0 ) 
 	{
		foreach( $rs->result_assoc() as $rows )
 		{
			$arr_value[$rows['CallReasonId']] = $rows['CallReasonDesc'];
		}
 	}
 	return $arr_value;
}

/**
 * @BAP
 * (F) _getCampaignPds
 * 
 * @return Array  $_conds
 */
function _getCampaignPds()
{
	$_conds = array();
	if( class_exists('M_SetCampaign')) {
		$_conds = $this->M_SetCampaign->_get_campaign_name_pds();
	}
	return $_conds;
} 


 // ================= END CLASS ========================= 
}

?>