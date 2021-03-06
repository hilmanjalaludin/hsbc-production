<?php
/*
 * E.U.I 
 *
 
 * subject	: get model data for SysUser 
 * 			  extends under Controller class
 * author   : razaki team	
 * link		: http://www.razakitechnology.com/eui/controller/sysuser/
 */
 
class SrcCustomerPolis extends EUI_Controller
{

/*
 * @ def 		: __construct // constructor class 
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
public function SrcCustomerPolis() 
{
	parent::__construct();
	$this -> load ->model(base_class_model($this));	
}

 
/*
 * @ def 		: __construct // constructor class 
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */

public function index()
{
 if( $this ->EUI_Session ->_have_get_session('UserId') )
 {
	$_EUI  = array( 'page' => $this ->M_SrcCustomerPolis ->_get_default()
		//'CampaignId' => $this ->M_SetCampaign ->_get_campaign_name() )
		// 'CallResult' => self::getCallResult(), 'CardType' => $this ->M_SrcCustomerList ->_getCardType(), 
		// 'ProductId' => self::_getProductId(), 'GenderId' => $this ->M_SrcCustomerList ->_getGenderId()
	);
		
	if( is_array($_EUI))
	{
		$this -> load ->view('src_policy_list/view_editpolicy_nav',$_EUI);
	}	
 }
 
}
 
/*
 * @ def 		: __construct // constructor class 
 * -----------------------------------------
 *
 * @ params  	: post & definition paymode 
 * @ return 	: void(0)
 */
 
public function Content()
{

  if( $this -> EUI_Session -> _have_get_session('UserId') )
	{
		$_EUI['page'] = $this ->M_SrcCustomerPolis ->_get_resource();    // load content data by pages 
		$_EUI['num']  = $this ->M_SrcCustomerPolis ->_get_page_number(); // load content data by pages 
		
		// sent to view data 
		
		if( is_array($_EUI) && is_object($_EUI['page']) )  
		{
			$this -> load -> view('src_policy_list/view_editpolicy_list',$_EUI);
		}	
	}	
}


	
}

?>