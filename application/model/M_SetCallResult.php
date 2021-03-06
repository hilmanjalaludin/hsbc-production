<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Enigma User Interface
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Enigma User Interface
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, razaki, Inc.
 * @license		http://razakitechnology.com/user_guide/license.html
 * @link		http://razakitechnology.com
 * @since		Version 1.0
 * @filesource
 */
 
class M_SetCallResult extends EUI_Model
{

private static $Instance   = null; 
 public static function &Instance()
{
	if( is_null(self::$Instance) ){
		self::$Instance = new self();
	}	
	return self::$Instance;
}
 
/*
 * @ def 		: __construct // constructor class 
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
function _get_default()
{
	$this -> EUI_Page -> _setPage(10); 
	
	$this -> EUI_Page -> _setQuery
		(
		 " SELECT a.CallReasonId FROM t_lk_callreason a 
		   LEFT JOIN  t_lk_callreasoncategory b ON a.CallReasonCategoryId=b.CallReasonCategoryId "
		); 
	
	$flt = '';
	
	if( $this->URI->_get_have_post('keywords') ) 
	{
		$flt.=" AND ( 
				a.CallReasonCategoryId LIKE '%{$this->URI->_get_post('keywords')}%' 
				OR a.CallReasonLevel LIKE '%{$this->URI->_get_post('keywords')}%'
				OR a.CallReasonCode LIKE '%{$this->URI->_get_post('keywords')}%'
				OR a.CallReasonDesc LIKE '%{$this->URI->_get_post('keywords')}%'
				OR a.CallReasonStatusFlag LIKE '%{$this->URI->_get_post('keywords')}%'
				OR a.CallReasonContactedFlag LIKE '%{$this->URI->_get_post('keywords')}%'
				OR a.CallReasonEvent LIKE '%{$this->URI->_get_post('keywords')}%'
				OR a.CallReasonLater LIKE '%{$this->URI->_get_post('keywords')}%'
				OR a.CallReasonOrder LIKE '%{$this->URI->_get_post('keywords')}%'
				OR a.CallReasonNoNeed LIKE '%{$this->URI->_get_post('keywords')}%' 
			) ";
	}				
			
	$this -> EUI_Page -> _setWhere( $flt );   
	if( $this -> EUI_Page -> _get_query() ) {
		return $this -> EUI_Page;
	}
}

/*
 * @ def 		: __construct // constructor class 
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
function _get_content()
{
	  $this->EUI_Page->_postPage(_get_post('v_page') );
	  $this->EUI_Page->_setPage(10);
	  
	  $conds1 = " IF( a.CallReasonEvent=1, 'YES', 'NO') as CallReasonEvent ";
	  $conds2 = " IF( a.CallReasonLater=1, 'YES', 'NO') as CallReasonLater ";
	  $conds3 = " IF( a.CallReasonNoNeed=1, 'YES', 'NO') as CallReasonNoNeed ";
	  $conds4 = " IF(a.CallReasonStatusFlag = 1, 'Active', 'Not Active') as Flags ";
	  // mode mssql
	  if( QUERY == 'mssql') {
	  	$conds1 = " CASE WHEN a.CallReasonEvent=1 THEN 'YES' ELSE 'NO' END as CallReasonEvent ";
	  	$conds2 = " CASE WHEN a.CallReasonLater=1 THEN 'YES' ELSE 'NO' END as CallReasonLater ";
	 	$conds3 = " CASE WHEN a.CallReasonNoNeed=1 THEN 'YES' ELSE 'NO' END as CallReasonNoNeed ";
	  	$conds4 = " CASE WHEN a.CallReasonStatusFlag=1 THEN 'Active' ELSE 'Not Active' END as Flags ";
	  }

	  $this->EUI_Page->_setArraySelect(array(
		"a.CallReasonId as chk_result" => array("chk_result", "chk_result", "primary"),
		"a.CallReasonCode as CallReasonCode" => array("CallReasonCode", "Call Reason Code"),
		"a.CallReasonDesc as CallReasonDesc" => array("CallReasonDesc", "Call Reason Name"),
		"concat(b.CallReasonCategoryCode,' - ',b.CallReasonCategoryName) as CallStatus" => array("CallStatus", "Call Status"),
		"{$conds1}" => array("CallReasonEvent", "Interest Flag"),
		"{$conds2}" => array("CallReasonLater", "Call Later Flag"),
		"{$conds3}" => array("CallReasonNoNeed", "Not Interest Flag"),
		/* "IF( a.CallReasonInterest =1, 'YES', 'NO') as CallReasonInterest" => array("CallReasonInterest", "Interest"), */
		"a.CallReasonOrder as CallReasonOrder" => array("CallReasonOrder","Order"),
		"{$conds4}" => array("Flags", "Is Active")
	  ));
	  

	  $this->EUI_Page->_setFrom("t_lk_callreason a");
	  $this->EUI_Page->_setJoin("t_lk_callreasoncategory b", "a.CallReasonCategoryId=b.CallReasonCategoryId", "LEFT", TRUE);
		
	 // --- set filter if OK ---
	 $this->EUI_Page->_setAndOr(array(
		"a.CallReasonCode" => array("LIKE",_get_post('keywords')),
		"a.CallReasonDesc" => array("LIKE",_get_post('keywords')),
		"b.CallReasonCategoryCode" => array("LIKE",_get_post('keywords')),
		"b.CallReasonCategoryName" => array("LIKE",_get_post('keywords'))
	 ));

		// ------------ set order field  ----------------------------
		// echo $this->EUI_Page->_getCompiler();	

	   	if(_get_have_post('order_by')) 
	  	{
		 	$this->EUI_Page->_setOrderBy($this ->URI->_get_post('order_by'),$this ->URI->_get_post('type'));
	   	} else {
		   $this->EUI_Page->_setOrderBy("a.CallReasonId","ASC");
	    }
	   
	  	$this->EUI_Page->_setLimit();
}


/*
 * @ def 		: _get_resource // constructor class 
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
function _get_resource()
 {
	self::_get_content();
	if( $this -> EUI_Page -> _get_query()!='') 
	{
		return $this -> EUI_Page -> _result();
	}	
 }
 
/*
 * @ def 		: _get_page_number // constructor class 
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
function _get_page_number() 
 {
	if( $this -> EUI_Page -> _get_query()!='' ) {
		return $this -> EUI_Page -> _getNo();
	}	
 }
 
/*
 * @ def 		: _get_page_number // constructor class 
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
function _getNotInterest()
{
	$_conds = array();
	
	$sql = " SELECT a.CallReasonId, a.CallReasonDesc, a.CallReasonCode FROM t_lk_callreason a 
			 LEFT JOIN t_lk_callreasoncategory b on a.CallReasonCategoryId=b.CallReasonCategoryId
			 WHERE a.CallReasonNoNeed=1  AND b.CallReasonInterest=0 ORDER BY a.CallReasonOrder ASC ";
		 
	$qry = $this -> db -> query($sql);
	if( !$qry -> EOF() ) 
	{
		foreach( $qry -> result_assoc() as $rows )
		{
			$_conds[$rows['CallReasonId']] = array 
			( 
				'name' => $rows['CallReasonDesc'], 
				'code' => $rows['CallReasonCode']
			);
		}
	}
	
	return $_conds;
}

/*
 * @ def 		: _getInterestSale
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
function _getInterestSale()
 {
	$_conds = array();
	$sql = " SELECT a.CallReasonId, a.CallReasonDesc, a.CallReasonCode from t_lk_callreason a 
			 LEFT join t_lk_callreasoncategory b on a.CallReasonCategoryId = b.CallReasonCategoryId
			 WHERE b.CallReasonInterest =1 AND a.CallReasonStatusFlag=1 ";
	
	$qry = $this -> db -> query($sql);

	// if(!$qry -> EOF()){
	if( $qry->num_rows() > 0 ){
		foreach( $qry -> result_assoc() as $rows ) {
			$_conds[$rows['CallReasonId']]= array( 
				'name' => $rows['CallReasonDesc'], 
				'code' => $rows['CallReasonCode']
			);	
		}	
	}
	
	return $_conds;
 }


 /*
 * @ def 		: _getCallback
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
function _getBoolean()
{
	$array = array('1'=>'Yes','0'=>'No');
	return $array;
}	

/*
 * @ def 		: _getCallback
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
function _getCallback()
{
	$_conds = array();
	
	$sql = " SELECT a.CallReasonId, a.CallReasonDesc, a.CallReasonCode 
			 FROM  t_lk_callreason a WHERE a.CallReasonLater=1 
			 AND a.CallReasonStatusFlag=1 ";
			 
	$qry = $this -> db -> query($sql);
	if( !$qry -> EOF() ) 
	{
		foreach( $qry -> result_assoc() as $rows )
		{
			$_conds[$rows['CallReasonId']] = array ( 
				'name' => $rows['CallReasonDesc'], 
				'code' => $rows['CallReasonCode']
			);	
		}	
	}
	
	return $_conds;
}

/*
 * @ def 		: _getCallReasonId
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
function _getCallReasonId( $CategoryId=NULL )
{
	$_conds = array();
	$this -> db ->reset_select();
	$this -> db -> select("a.CallReasonId, a.CallReasonDesc, a.CallReasonCode");
	$this -> db -> from("t_lk_callreason a");
	$this -> db -> join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId","LEFT");
	$this -> db -> where("a.CallReasonStatusFlag",1);
	
	if(!is_null($CategoryId))
	{
		$this -> db -> where("a.CallReasonCategoryId",$CategoryId);
	}
	
	//echo $this -> db ->_get_var_dump();
	
	
	foreach( $this ->db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['CallReasonId']] = array 
		( 
			'name' => $rows['CallReasonDesc'], 
			'code' => $rows['CallReasonCode']
		);	
	}	

	return $_conds;		 
}

function _getCallReasonIdPds( $CategoryId=NULL )
{
	$_conds = array();
	$this -> db ->reset_select();
	$this -> db -> select("a.CallReasonId, a.CallReasonDesc, a.CallReasonCode");
	$this -> db -> from("t_lk_callreason a");
	$this -> db -> join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId","LEFT");
	$this->db->where_in("b.CallReasonCategoryId",array(1,7,10,8,9));
	$this -> db -> where("a.CallReasonStatusFlag",1);
	
	if(!is_null($CategoryId))
	{
		$this -> db -> where("a.CallReasonCategoryId",$CategoryId);
	}
	
	// echo $this -> db ->_get_var_dump();
	
	
	foreach( $this ->db ->get()->result_assoc() as $rows )
	{
		$_conds[$rows['CallReasonId']] = array 
		( 
			'name' => $rows['CallReasonDesc'], 
			'code' => $rows['CallReasonCode']
		);	
	}	

	return $_conds;		 
} 

/*
 * @ def 		: _getCallReasonId
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
 
function _getInboundReasonId()
{
	$_conds = array();
	
	$this -> db -> select("a.CallReasonId, a.CallReasonDesc, a.CallReasonCode");
	$this -> db -> from("t_lk_callreason a");
	$this -> db -> join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId","LEFT");
	$this -> db -> where("b.CallOutboundGoalsId",1);
	
	foreach( $this->db->get()->result_assoc() as $rows )
	{
		$_conds[$rows['CallReasonId']] = array 
		( 
			'name' => $rows['CallReasonDesc'], 
			'code' => $rows['CallReasonCode']
		);	
	}	
	return $_conds;		 
} 

/*
 * @ def 		: _getEventSale
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
function _getEventSale()
{
	$_conds = array();
	
	$sql = "SELECT a.CallReasonId, a.CallReasonDesc, a.CallReasonCode FROM  t_lk_callreason a where a.CallReasonEvent=1";
	$qry = $this -> db -> query($sql);
	
	if( !$qry -> EOF() ) 
	{
		foreach( $qry -> result_assoc() as $rows )
		{
			$_conds[$rows['CallReasonId']] = array ( 
				'name' => $rows['CallReasonDesc'], 
				'code' => $rows['CallReasonCode']
			);	
		}	
	}
	
	return $_conds;		 
}
 
/*
 * @ def 		: _getEventSale
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
 function _setActive($data=array())
 {
	$_conds = 0;
	if(is_array($data))
	{
		foreach( $data['CallReasonId'] as $keys => $CallReasonId )
		{
			if( $this -> db ->update('t_lk_callreason', 
				array('CallReasonStatusFlag'=> $data['Active']), 
				array('CallReasonId' => $CallReasonId)
			))
			{
				$_conds++;
			}	
		}
	}	
	return $_conds;
 }
 
/*
 * @ def 		: _getEventSale
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
 function _setSaveCallResult( $post=array() )
 {
	$_conds = 0;
	if( $this -> db->insert('t_lk_callreason',$post) ) 
	{
		$_conds++;
	}
	return $_conds;
 }
 
/*
 * @ def 		: _getEventSale
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
 function _setDeleteCallResult($_post)
 {
	$_conds = 0;
	foreach($_post as $a => $PK )
	{
		if( $this -> db ->delete('t_lk_callreason', 
			array('CallReasonId' => $PK) 
		)) 
		{
			$_conds++;
		}
	}
	
	return $_conds; 
 }
 
/*
 * @ def 		: _getEventSale
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */

function _getDataResult( $ResultId=0 )
{  
	$_conds = array();
	
	$this -> db -> select('*');
	$this -> db -> from('t_lk_callreason a');
	$this -> db -> where('a.CallReasonId',$ResultId);
	
	if( $rows = $this -> db -> get() -> result_first_assoc())
	{
		$_conds = $rows;
	}
	
	return $_conds;
}

/*
 * @ def 		: _getEventSale
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */

function _setUpdateCallResult($_post = array() )
{
	$_conds = 0; $update = array(); $where = array();
	foreach( $_post as $fields => $values )
	{
		if(($fields!='CallReasonId'))
			$update[$fields] = $values;
		else
			$where[$fields] = $values;
	}
	
	if( $this -> db -> update('t_lk_callreason',$update,$where)){
		$_conds++;	
	}
	
	return $_conds;
}

/*
 * @ def 		: _getEventSale
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
function _getEventType($CallReasonId)
{
	$this->db->select('a.CallReasonEvent, a.CallReasonLater, a.CallReasonNoNeed,a.CallReasonNoMoreFU');
	$this->db->from('t_lk_callreason a');
	$this->db->where('a.CallReasonStatusFlag',1);
	$this->db->where('a.CallReasonId', $CallReasonId);
	
	if( $rows = $this -> db->get()->result_first_assoc()){
		return $rows;
	}
	else
		return null;

}


/*
 * @ def 		: _getPendingInfo
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
function _getPendingInfo()
{
	$_conds = array();
	$sql = "SELECT a.CallReasonId, a.CallReasonDesc  FROM 
				t_lk_callreason a 
			WHERE a.CallReasonPendingQA = 1 ";
	
	$qry = $this -> db -> query($sql);

	// if(!$qry -> EOF()){
	if( $qry->num_rows() > 0 ){
		foreach( $qry -> result_assoc() as $rows ) {
			$_conds[$rows['CallReasonId']]= $rows['CallReasonDesc'];
		}	
	}
	
	return $_conds;
 }
 
 
/*
 * @ def 		: _getPendingInfo
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
 function _getRealInterest()
 {
	$Int = $this->_getInterestSale();
	$Pen = $this->_getPendingInfo();
	
	$process = array();
	foreach( $Int as $k => $v ){
		if(!in_array($k,array_keys($Pen) )){
			$process[$k] = $v;
		}
	}
	
	return $process;
	
 }
 
 // 23/09/2014 : abie
 
 function _getAllResult()
 {
	$_conds = array();
	$sql = "SELECT a.CallReasonId, a.CallReasonDesc  FROM 
				t_lk_callreason a 
			WHERE a.CallReasonPendingQA <> 1 ";
	
	$qry = $this -> db -> query($sql);
	if(!$qry -> EOF()){
		foreach( $qry -> result_assoc() as $rows ) {
			$_conds[$rows['CallReasonId']]= $rows['CallReasonDesc'];
		}	
	}
	
	return $_conds;
 }
 
  
  /**
  * Select
  *
  * Generates the SELECT portion of the query
  *
  * @param	string
  * @return	object
  * query-mssql [OK]
  */
  function getCategoryIDByResult( $resultDispositionID = 0 )
 {
	$this->val = 0; 
	$sql = sprintf("SELECT a.CallReasonCategoryId as ID  
						FROM t_lk_callreason a 
						WHERE a.CallReasonId='%d'", $resultDispositionID );
						
	$qry  = $this->db->query( $sql );
	if( $qry && $qry->num_rows() > 0 ) {
		 $this->val = $qry->result_value();
	}	
	
	return (int)$this->val;					
}


 /**
  * Select
  *
  * Generates the SELECT portion of the query
  *
  * @param	string
  * @return	object
  */
  function getScoreCategoryID( $categoryID = 0 )
 {
	$this->val = 0; 
	$sql = sprintf("select a.CallReasonCategoryCode as ID from t_lk_callreasoncategory a 
					where a.CallReasonCategoryId=%d", $categoryID );
	
	$qry  = $this->db->query( $sql );
	if( $qry && $qry->num_rows() > 0 ) {
		 $this->val = $qry->result_value();
	}	
	return $this->val;					
}

 /**
  * Select
  *
  * Generates the SELECT portion of the query
  *
  * @param	string
  * @return	object
  */
  
 function getDispositionDataID( $callCustomerID = 0 )
{
	$this->val = 0;
	
	$sql  = sprintf("select a.CustomerStatus from t_gn_customer a  where a.CustomerId='%d'", $callCustomerID);
	$qry  = $this->db->query( $sql );
	
	if( $qry && $qry->num_rows() > 0 ) {
		 $this->val = $qry->result_value();
	}	
	return $this->val;
	
} 
// ---------------------------------------------------------------------------------------------
/* 
 * add call result all by not interest && New 
 *
 */
 
 function _getCallResultTransfer()
{
  
 $arr_call_result = array();
 
 $this->db->reset_select();
 $this->db->select("a.CallReasonId, a.CallReasonDesc", FALSE);
 $this->db->from("t_lk_callreason a");
 $this->db->join("t_lk_callreasoncategory b ","a.CallReasonCategoryId=b.CallReasonCategoryId","LEFT");
 $this->db->where("a.CallReasonEvent", 0);
 $this->db->where("b.CallOutboundGoalsId", 2);
 $this->db->where_not_in("a.CallReasonId", array(99));
 
 $rs = $this->db->get();
 if( $rs->num_rows() > 0 ) 
	foreach( $rs->result_assoc() as $rows )
 {
	$arr_call_result[$rows['CallReasonId']] = $rows['CallReasonDesc'];	
 }
 return (array)$arr_call_result;
 
}

// ===================== END CLASS ==========================================
}
?>