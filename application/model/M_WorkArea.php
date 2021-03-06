<?php
/*
 * E.U.I 
 *
 
 * subject	: M_Utility modul 
 * author   : razaki team	
 * link		: http://www.razakitechnology.com/eui/model/M_Utility/
 */
 
class M_WorkArea extends EUI_Model
{


 
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
	$this -> EUI_Page -> _setQuery("SELECT * FROM t_lk_branch a "); 
	
	$filter = '';
	
	if( $this->URI->_get_have_post('key_words') ) 
	{
		$filter ="";
	}				
			
	$this -> EUI_Page -> _setWhere( $filter );   
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

  $this -> EUI_Page->_postPage( $this -> URI -> _get_post('v_page') );
  $this -> EUI_Page->_setPage(10);
 
 $sql = "SELECT * FROM t_lk_branch a ";
			
 $this -> EUI_Page ->_setQuery($sql);
 $filter = '';
 
  if( $this -> URI -> _get_have_post('key_words') )
  {
	$filter = " ";	
  }				
		
  $this -> EUI_Page->_setWhere();
  $this -> EUI_Page->_setLimit();
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
 * EUI :: _get_branch_work() 
 * -----------------------------------------
 *
 * @ def		function get detail content list page 
 * @ param		not assign parameter
 */
 
function _get_branch_work()
{
	$datas = array();
	$qry = $this -> db -> query(" SELECT a.BranchCode, a.BranchName FROM t_lk_branch a ");
	foreach( $qry -> result_assoc() as $rows ){
		$datas[$rows['BranchCode']] = $rows['BranchName'];
	}
  return $datas;	
}

}

?>