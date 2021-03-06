<?php
class M_VerifikasiB extends EUI_Model
{
	var $_set_a = array();
	var $_set_b = array();
	var $_set_c = array();
	
	function M_VerifikasiB()
	{
		$this->_set_a = array('cust_dob');
		$this->_set_b = array('cycle_due_date','old_instalment','account','phone_number');
		$this->_set_c = array('flag_supplement','bill_address');
	}
	
	function _get_value_verification($_cust_id)
	{
		$_datas = array();
		
		$sql = "SELECT 
					a.CustomerDOB,
					a.CustomerHomePhoneNum,
					a.CustomerMobilePhoneNum,
					a.CustomerWorkPhoneNum,
					a.card_no,
					a.credit_limit,
					a.due_date,
					a.card_exp,
					a.flag_suplement,
					a.billing_address,
					a.cycle_due_date,
					a.pil_acc_no,
					a.monthly_installment
				FROM t_gn_customer a
				WHERE a.CustomerId = '".$_cust_id."'";
		// echo $sql;
		$qry = $this->db->query($sql);
		
		if($qry->num_rows()>0)
		{
			$_datas = $qry->result_first_assoc();
		}
		
		return $_datas;
	}
	
	function _get_result_verification($_cust_id)
	{
		$_datas = array();
		
		/* $sql = "SELECT * FROM t_gn_ver_result a
				WHERE a.cust_id = '".$_cust_id."'
				AND a.ver_date = '".date('Y-m-d')."'"; */
		$sql = "SELECT * FROM t_gn_ver_result a
				WHERE a.cust_id = '".$_cust_id."'";
		$qry = $this->db->query($sql);
		
		if($qry->num_rows()>0)
		{
			$_datas = $qry->result_first_assoc();
		}
		
		return $_datas;
	}
	
	function _get_input_verification($_cust_id)
	{
		$_datas = array();
		
		/* $sql = "SELECT * FROM t_gn_ver_activity a
				WHERE a.cust_id = '".$_cust_id."'
				AND a.ver_date = '".date('Y-m-d')."'"; */
			$sql = "SELECT * FROM t_gn_ver_activity a
				WHERE a.cust_id = '".$_cust_id."'";
				
		$qry = $this->db->query($sql);
		
		if($qry->num_rows()>0)
		{
			foreach($qry->result_assoc() as $rows)
			{
				$_datas[$rows['ver_form']] = $rows;
			}
		}
		
		return $_datas;
	}
	
	function _get_res_activity($cust_id,$ver_date)
	{
		$_temp = array();
		
		$sql = "select 
					a.ver_set,
					a.ver_status,
					count(a.id) as ver_total
				from t_gn_ver_activity a
				where 1=1
				and a.cust_id = '".$cust_id."'
				group by a.ver_set, a.ver_status";
		$qry = $this->db->query($sql);
		
		if($qry->num_rows()>0)
		{
			foreach($qry->result_assoc() as $rows)
			{
				$_temp[$rows['ver_set']][$rows['ver_status']] = $rows['ver_total'];
			}
		}
		
		return $_temp;
	}
	
	function _set_ver_result($cust_id,$ver_date)
	{
		$_temp = $this->_get_res_activity($cust_id,$ver_date);
		$_res = 0;
				
		/* JIKA VERIFIKASI DOB GAGAL */
		if( isset($_temp['A'][2]) && $_temp['A'][2]>0 )
		{
			$_res = 2;
		}
		else{
			/* JIKA VERIFIKASI DOB BERHASIL */
			if( isset($_temp['A'][1]) && $_temp['A'][1]>0 )
			{
				/* JIKA VERIFIKASI SET B, 2 BERHASIL */
				if( isset($_temp['B'][1]) && $_temp['B'][1]>1 )
				{
					$_res = 1;
				}
				/* JIKA VERIFIKASI SET B, 1 BERHASIL && JIKA VERIFIKASI SET C, 1 BERHASIL */
				elseif( (isset($_temp['B'][1]) && $_temp['B'][1]>0) && (isset($_temp['C'][1]) && $_temp['C'][1]>0) )
				{
					$_res = 1;
				}
			}
		}
		
		if($_res>0)
		{
			$this->db->insert('t_gn_ver_result',array(
				'cust_id' 	 => $cust_id,
				// 'ver_date' 	 => $ver_date,
				'ver_result' => $_res,
				'create_by'  => $this->EUI_Session->_get_session('UserId')
			));
		}
	}
	
	function _save_activity($param)
	{
		$_id = $param['InputId'];
		$_pass = 0;
		$_sett = null;
		$_tmax = $param['c_'.$_id];
		$_cout = $param['a_'.$_id]+1;
		
		if( $param['o_'.$_id]==$param['i_'.$_id] )
		{
			$_pass = 1;
		}
		else{
			if($_cout<$_tmax)
			{
				$_pass = 0;
			}
			else{
				$_pass = 2;
			}
		}
		
		if(in_array($_id,$this->_set_a))
		{
			$_sett = 'A';
		}
		
		if(in_array($_id,$this->_set_b))
		{
			$_sett = 'B';
		}
		
		if(in_array($_id,$this->_set_c))
		{
			$_sett = 'C';
		}
		
		$this->db->insert('t_gn_ver_activity',array(
			'cust_id' 		=> $param['CustomerId'],
			// 'ver_date' 		=> date('Y-m-d'),
			'ver_form' 		=> $_id,
			'ver_value' 	=> $param['o_'.$_id],
			'ver_input' 	=> $param['i_'.$_id],
			'ver_attempt' 	=> $_cout,
			'ver_status' 	=> $_pass,
			'ver_set' 		=> $_sett,
			'create_date' 	=> date('Y-m-d H:i:s'),
			'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
		));
		
		if($this->db->affected_rows()>0)
		{
			$this->db->insert('t_gn_ver_activity_log',array(
				'cust_id' 		=> $param['CustomerId'],
				// 'ver_date' 		=> date('Y-m-d'),
				'ver_form' 		=> $_id,
				'ver_value' 	=> $param['o_'.$_id],
				'ver_input' 	=> $param['i_'.$_id],
				'ver_attempt' 	=> $_cout,
				'ver_status' 	=> $_pass,
				'ver_set' 		=> $_sett,
				'create_date' 	=> date('Y-m-d H:i:s'),
				'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
			));
		}
		else{
			$this->db->update('t_gn_ver_activity',array(
				'ver_value' 	=> $param['o_'.$_id],
				'ver_input' 	=> $param['i_'.$_id],
				'ver_attempt' 	=> $_cout,
				'ver_status' 	=> $_pass,
				'ver_set' 		=> $_sett,
				'create_date' 	=> date('Y-m-d H:i:s'),
				'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
			),array(
				'cust_id' 		=> $param['CustomerId'],
				// 'ver_date' 		=> date('Y-m-d'),
				'ver_form' 		=> $_id,
			));
			
			if($this->db->affected_rows()>0)
			{
				$this->db->insert('t_gn_ver_activity_log',array(
					'cust_id' 		=> $param['CustomerId'],
					// 'ver_date' 		=> date('Y-m-d'),
					'ver_form' 		=> $_id,
					'ver_value' 	=> $param['o_'.$_id],
					'ver_input' 	=> $param['i_'.$_id],
					'ver_attempt' 	=> $_cout,
					'ver_status' 	=> $_pass,
					'ver_set' 		=> $_sett,
					'create_date' 	=> date('Y-m-d H:i:s'),
					'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
				));
			}
		}
		
		$this->_set_ver_result($param['CustomerId'],date('Y-m-d'));
	}
	
	function _save_ver_phone($param)
	{
		$_phone = array();
		$_id   = $param['InputId'];
		$_pass = 0;
		$_sett = 'B';
		$_tmax = $param['c_'.$_id];
		$_cout = $param['a_'.$_id]+1;
		
		$_phonex = array(
			trim($param['o_'.$_id.'_1']),
			trim($param['o_'.$_id.'_2']),
			trim($param['o_'.$_id.'_3']),
		);
		
		foreach($_phonex as $key => $value)
		{
			if( strlen($value)>4 )
			{
				$_phone[$key] = $value;
			}
		}
		
		if( in_array($param['i_'.$_id],$_phone) )
		{
			$_pass = 1;
		}
		else{
			if($_cout<$_tmax)
			{
				$_pass = 0;
			}
			else{
				$_pass = 2;
			}
		}
		
		$this->db->insert('t_gn_ver_activity',array(
			'cust_id' 		=> $param['CustomerId'],
			// 'ver_date' 		=> date('Y-m-d'),
			'ver_form' 		=> $_id,
			'ver_value' 	=> implode(',',$_phone),
			'ver_input' 	=> $param['i_'.$_id],
			'ver_attempt' 	=> $_cout,
			'ver_status' 	=> $_pass,
			'ver_set' 		=> $_sett,
			'create_date' 	=> date('Y-m-d H:i:s'),
			'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
		));
		
		if($this->db->affected_rows()>0)
		{
			$this->db->insert('t_gn_ver_activity_log',array(
				'cust_id' 		=> $param['CustomerId'],
				// 'ver_date' 		=> date('Y-m-d'),
				'ver_form' 		=> $_id,
				'ver_value' 	=> implode(',',$_phone),
				'ver_input' 	=> $param['i_'.$_id],
				'ver_attempt' 	=> $_cout,
				'ver_status' 	=> $_pass,
				'ver_set' 		=> $_sett,
				'create_date' 	=> date('Y-m-d H:i:s'),
				'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
			));
		}
		else{
			$this->db->update('t_gn_ver_activity',array(
				'ver_value' 	=> implode(',',$_phone),
				'ver_input' 	=> $param['i_'.$_id],
				'ver_attempt' 	=> $_cout,
				'ver_status' 	=> $_pass,
				'ver_set' 		=> $_sett,
				'create_date' 	=> date('Y-m-d H:i:s'),
				'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
			),array(
				'cust_id' 		=> $param['CustomerId'],
				// 'ver_date' 		=> date('Y-m-d'),
				'ver_form' 		=> $_id,
			));
			
			if($this->db->affected_rows()>0)
			{
				$this->db->insert('t_gn_ver_activity_log',array(
					'cust_id' 		=> $param['CustomerId'],
					// 'ver_date' 		=> date('Y-m-d'),
					'ver_form' 		=> $_id,
					'ver_value' 	=> implode(',',$_phone),
					'ver_input' 	=> $param['i_'.$_id],
					'ver_attempt' 	=> $_cout,
					'ver_status' 	=> $_pass,
					'ver_set' 		=> $_sett,
					'create_date' 	=> date('Y-m-d H:i:s'),
					'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
				));
			}
		}
		
		$this->_set_ver_result($param['CustomerId'],date('Y-m-d'));
	}
	
	function _save_ver_crlimit($param)
	{
		$_id   = $param['InputId'];
		$_pass = 0;
		$_sett = 'B';
		$_tmax = $param['c_'.$_id];
		$_cout = $param['a_'.$_id]+1;
		
		$_credit = $param['o_'.$_id];
		$_persen = 10;
		$_amount = (is_numeric($_credit)?($_credit/100)*$_persen:0);
		$_minima = (is_numeric($_credit)?($_credit-$_amount):0);
		$_maxima = (is_numeric($_credit)?($_credit+$_amount):0);
		
		if( ($param['i_'.$_id]>=$_minima) && ($param['i_'.$_id]<=$_maxima) )
		{
			$_pass = 1;
		}
		else{
			if($_cout<$_tmax)
			{
				$_pass = 0;
			}
			else{
				$_pass = 2;
			}
		}
		
		
		$this->db->insert('t_gn_ver_activity',array(
			'cust_id' 		=> $param['CustomerId'],
			// 'ver_date' 		=> date('Y-m-d'),
			'ver_form' 		=> $_id,
			'ver_value' 	=> $_minima.' - '.$_maxima,
			'ver_input' 	=> $param['i_'.$_id],
			'ver_attempt' 	=> $_cout,
			'ver_status' 	=> $_pass,
			'ver_set' 		=> $_sett,
			'create_date' 	=> date('Y-m-d H:i:s'),
			'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
		));
		
		if($this->db->affected_rows()>0)
		{
			$this->db->insert('t_gn_ver_activity_log',array(
				'cust_id' 		=> $param['CustomerId'],
				// 'ver_date' 		=> date('Y-m-d'),
				'ver_form' 		=> $_id,
				'ver_value' 	=> $_minima.' - '.$_maxima,
				'ver_input' 	=> $param['i_'.$_id],
				'ver_attempt' 	=> $_cout,
				'ver_status' 	=> $_pass,
				'ver_set' 		=> $_sett,
				'create_date' 	=> date('Y-m-d H:i:s'),
				'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
			));
		}
		else{
			$this->db->update('t_gn_ver_activity',array(
				'ver_value' 	=> $_minima.' - '.$_maxima,
				'ver_input' 	=> $param['i_'.$_id],
				'ver_attempt' 	=> $_cout,
				'ver_status' 	=> $_pass,
				'ver_set' 		=> $_sett,
				'create_date' 	=> date('Y-m-d H:i:s'),
				'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
			),array(
				'cust_id' 		=> $param['CustomerId'],
				// 'ver_date' 		=> date('Y-m-d'),
				'ver_form' 		=> $_id,
			));
			
			if($this->db->affected_rows()>0)
			{
				$this->db->insert('t_gn_ver_activity_log',array(
					'cust_id' 		=> $param['CustomerId'],
					// 'ver_date' 		=> date('Y-m-d'),
					'ver_form' 		=> $_id,
					'ver_value' 	=> $_minima.' - '.$_maxima,
					'ver_input' 	=> $param['i_'.$_id],
					'ver_attempt' 	=> $_cout,
					'ver_status' 	=> $_pass,
					'ver_set' 		=> $_sett,
					'create_date' 	=> date('Y-m-d H:i:s'),
					'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
				));
			}
		}
		
		$this->_set_ver_result($param['CustomerId'],date('Y-m-d'));
	}
	
	function _save_ver_duedate($param)
	{
		$_id   = $param['InputId'];
		$_pass = 0;
		$_sett = 'B';
		$_tmax = $param['c_'.$_id];
		$_cout = $param['a_'.$_id]+1;
		
		$_limit = 2;
		$_dates = array(
			date('d',strtotime($param['o_'.$_id]))
		);
		
		$_besok = $param['o_'.$_id];
		$_maren = $param['o_'.$_id];
		
		for($b=0;$b<$_limit;$b++)
		{
			$_besok = _getNextDate($_besok);
			$_maren = _getPrevDate($_maren .' -1 day');
			$_dates[] = date('d',strtotime($_besok));
			$_dates[] = date('d',strtotime($_maren));
		}
		
		asort($_dates,SORT_NUMERIC);
		
		if( in_array($param['i_'.$_id],$_dates) )
		{
			$_pass = 1;
		}
		else{
			if($_cout<$_tmax)
			{
				$_pass = 0;
			}
			else{
				$_pass = 2;
			}
		}
		
		$this->db->insert('t_gn_ver_activity',array(
			'cust_id' 		=> $param['CustomerId'],
			// 'ver_date' 		=> date('Y-m-d'),
			'ver_form' 		=> $_id,
			'ver_value' 	=> implode(',',$_dates),
			'ver_input' 	=> $param['i_'.$_id],
			'ver_attempt' 	=> $_cout,
			'ver_status' 	=> $_pass,
			'ver_set' 		=> $_sett,
			'create_date' 	=> date('Y-m-d H:i:s'),
			'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
		));
		
		if($this->db->affected_rows()>0)
		{
			$this->db->insert('t_gn_ver_activity_log',array(
				'cust_id' 		=> $param['CustomerId'],
				// 'ver_date' 		=> date('Y-m-d'),
				'ver_form' 		=> $_id,
				'ver_value' 	=> implode(',',$_dates),
				'ver_input' 	=> $param['i_'.$_id],
				'ver_attempt' 	=> $_cout,
				'ver_status' 	=> $_pass,
				'ver_set' 		=> $_sett,
				'create_date' 	=> date('Y-m-d H:i:s'),
				'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
			));
		}
		else{
			$this->db->update('t_gn_ver_activity',array(
				'ver_value' 	=> implode(',',$_dates),
				'ver_input' 	=> $param['i_'.$_id],
				'ver_attempt' 	=> $_cout,
				'ver_status' 	=> $_pass,
				'ver_set' 		=> $_sett,
				'create_date' 	=> date('Y-m-d H:i:s'),
				'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
			),array(
				'cust_id' 		=> $param['CustomerId'],
				// 'ver_date' 		=> date('Y-m-d'),
				'ver_form' 		=> $_id,
			));
			
			if($this->db->affected_rows()>0)
			{
				$this->db->insert('t_gn_ver_activity_log',array(
					'cust_id' 		=> $param['CustomerId'],
					// 'ver_date' 		=> date('Y-m-d'),
					'ver_form' 		=> $_id,
					'ver_value' 	=> implode(',',$_dates),
					'ver_input' 	=> $param['i_'.$_id],
					'ver_attempt' 	=> $_cout,
					'ver_status' 	=> $_pass,
					'ver_set' 		=> $_sett,
					'create_date' 	=> date('Y-m-d H:i:s'),
					'create_by' 	=> $this->EUI_Session->_get_session('UserId'),
				));
			}
		}
		
		$this->_set_ver_result($param['CustomerId'],date('Y-m-d'));
	}
}
?>