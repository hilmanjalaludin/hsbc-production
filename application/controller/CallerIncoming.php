<?php


class CallerIncoming extends EUI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model(array('M_CallerIncoming','M_SrcCustomerList','M_SetCallResult','M_SetProduct', 'M_SetCampaign','M_SetResultCategory', 'M_Combo', 'M_SysUser', 'M_MgtLockCustomer' ));
		$this->load->helper('EUI_Object');
	}

	function index(){
		if( !_have_get_session('UserId') ){
			return FALSE;
		}
		if(  _get_have_post('CustomerId') ){
			$var =new EUI_Object( _get_all_request() );
			$out =& get_class_instance(base_class_model($this));
			
			$verif_stat=$this ->M_SrcCustomerList ->_getVerifStat($var->get_value('CustomerId'));
			$cdd_stat=$this ->M_SrcCustomerList ->_getCddStat($var->get_value('CustomerId'));
			
			if($second_product = $out->_getDetailSecondProduct($var->get_value('CustomerId'))){
				if( $arr_ouput = $out->_getDetailCustomer( $var->get_value('CustomerId') ) ){
					$this->load->view('mod_contact_detail_pds/view_contact_main_detail', array(
						'Detail' => new EUI_Object( $arr_ouput ),
						'SecondDetail' => new EUI_Object( $second_product ),
						'ver_res_stat'=>$verif_stat,
						'cdd_stat'=>$cdd_stat,
						'PDSCall'=>$var->get_value('PDSCall'),
					));
				}
			}else{
				if( $arr_ouput = $out->_getDetailCustomer( $var->get_value('CustomerId') ) ){
					$this->load->view('mod_contact_detail_pds/view_contact_main_detail', array(
						'Detail' => new EUI_Object( $arr_ouput ),
						'Detail_attr' => $out->_getDetailAttr($arr_ouput['TableDetail'], $var->get_value('CustomerId')),
						'ver_res_stat'=>$verif_stat,
						'cdd_stat'=>$cdd_stat,
						'PDSCall'=>$var->get_value('PDSCall'),
					));
				}
			}
		}
	}
	
	function getCustomerIdfromCallSession(){
		if(  _get_have_post('callsessionid') ){
			$var = new EUI_Object(_get_all_request());
			$CustomerId = $this->M_CallerIncoming->_getCustomerIdfromCallSession($var->get_value('callsessionid'));
		}
		
		// return $CustomerId['assign_data'];
		echo json_encode($CustomerId);
	}
}

?>