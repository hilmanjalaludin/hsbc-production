<script>

var gTotalData = {
	distribusi : 0,
	transfer  : 0,
	pulldata : 0
}
// -----------------------------------------------------------------------------------------------------------------------------------
/* 
 * @ Method .............. : jQuery
 * @ pack ................ : wellcome on eui first page 
 * @ param ............... : testing all 
 */
 window.percentData = {
	 perDis 	: 0, 
	 perSwap 	: 0, 
	 perPull 	: 0
 }
// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  
 */

 Ext.DOM.RoleBack = function() 
{
	if( Ext.Msg('Are you sure ?').Confirm() ){
		new Ext.BackHome();
	}
}

// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  
 */
 
 window.ViewDistributeData = function( obj )
{
  var formDisFilter = Ext.Serialize('formDisFilter');
	$('#ui-widget-dis-list').Spiner 
	({
		url 	: new Array('MgtAssignment','PageDistribute'),
		param 	: Ext.Join(new Array( formDisFilter.getElement() ) ).object(),
		order   : {
			order_type : obj.type,
			order_by   : obj.orderby,
			order_page : obj.page	
		}, 
		handler  : 'ViewDistributeData',
		complete : function( obj ){
		
		  // add customize for scroll testing 
		  if( !$('.ui-widget-scroll-top-table-dis').length ){
				$("<div class='ui-widget-scroll-top-table-dis'><div class='ui-wdget-slider-top-dis' style='width:99%;'></div>").insertBefore(obj);
			}
			
		// callculate of height this 
		  this.protectedHeighes = $('#ui-widget-pager-dis-list').innerHeight()+$('#ui-widget-pager-dis-list-bottom').innerHeight();
		  this.protectedHeights = this.protectedHeighes+5;
		  this.protectedWidths  = $(window).innerWidth() - ($(window).innerWidth()/3);
		  
		 // replace styleSheets of overflow method 	
		
			$(".ui-widget-dis-list").css({  
				width: Math.round(this.protectedWidths), 
				height :  Math.round(this.protectedHeights) 
			});
			
			$(".ui-widget-dis-list").addClass("ui-scroller-width-right-border-fixed");
			$(".ui-widget-fieldset").addClass("ui-group-width-right-border ui-group-width-right-righter");
				
			
			var TotalDatas = $('#ui-total-ui-widget-pager-dis-list-record').text();
				gTotalData.distribusi = $('#ui-total-ui-widget-pager-dis-list-record').text();
				Ext.Cmp('dis_user_quantity').setValue(0);
				Ext.Cmp('dis_user_total').setValue(TotalDatas);
				Ext.Cmp('dis_user_total').disabled(true);
				
				
				if( gTotalData.distribusi == 0 ){
					$(".ui-widget-dis-list").css({ 
						height: 268
					});
				}
				
				//console.log(window.percentData.perDis);
				if( window.percentData.perDis ){
					$('.ui-widget-dis-list').scrollLeft( window.percentData.perDis );
				}
				
				$(".ui-wdget-slider-top-dis").slider({
					slide: function( event, ui ) {
						var widthData = $('.ui-widget-dis-list').innerWidth();
							window.percentData.perDis = ((widthData * ui.value) /100);
						$('.ui-widget-dis-list').scrollLeft( window.percentData.perDis );
					}
				});	
		}
	});		
}


// ====================== TRANSFER SESCTION =======================================================================
// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  
 */
 
 window.ViewTransferData = function( obj )
{
  var formTransFilter = Ext.Serialize('formTransFilter');
	$('#ui-widget-trans-list').Spiner 
	({
		url 	: new Array('MgtAssignment','PageTransfer'),
		param 	: Ext.Join( new Array( formTransFilter.getElement())).object(),
		order 	: {
			order_type : obj.type,
			order_by   : obj.orderby,
			order_page : obj.page	
		}, 
		handler  : 'ViewTransferData',
		complete : function( obj ){
			
			// tambahan slider untuk wrap table 
			// add customize for scroll testing 
			if( !$('.ui-widget-scroll-top-table-trans').length ){
				$("<div class='ui-widget-scroll-top-table-trans'><div class='ui-wdget-slider-top-trans' style='width:99%;'></div>").insertBefore(obj);
			}
			
		 // callculate of height this 
		  this.protectedHeighes = $('#ui-widget-pager-trf-list').innerHeight()+$('#ui-widget-pager-trf-list-bottom').innerHeight();
		  this.protectedHeights = this.protectedHeighes+15;
		  this.protectedWidths  = $(window).innerWidth() - ($(window).innerWidth()/3);
		  
		 // replace styleSheets of overflow method 	
		
			$(".ui-widget-trans-list").css({  
				width: Math.round(this.protectedWidths), 
				height :  Math.round(this.protectedHeights) 
			});
			
			$(".ui-widget-trans-list").addClass("ui-scroller-width-right-border-fixed");
			$(".ui-widget-fieldset").addClass("ui-group-width-right-border ui-group-width-right-righter");
				
			
			var TotalDatas = $('#ui-total-ui-widget-pager-trf-list-record').text();
				gTotalData.transfer = $('#ui-total-ui-widget-pager-trf-list-record').text();
				Ext.Cmp('trans_user_quantity').setValue(0);
				Ext.Cmp('trans_user_total').setValue(TotalDatas);
				Ext.Cmp('trans_user_total').disabled(true);
				
				
			// jika total = 0 default height;
			
				if( gTotalData.transfer == 0 ){
					$(".ui-widget-trans-list").css({  height: 268 });
				}
			//console.log(window.percentData.perDis);
				if( window.percentData.perSwap ){
					$('.ui-widget-trans-list').scrollLeft( window.percentData.perSwap );
				}	
				
				$(".ui-wdget-slider-top-trans").slider({
					slide: function( event, ui ) {
						var widthData = $('.ui-widget-trans-list').innerWidth();
							window.percentData.perSwap = ((widthData * ui.value) /100);
						$('.ui-widget-trans-list').scrollLeft( window.percentData.perSwap );
					}
				});	
				
		}
	});		
}
// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  
 */
 Ext.DOM.ActionCheckDist = function( obj ) 
 {
	if( obj.checked && obj.value == 2 )
	{
		var BoxList = Ext.Cmp("DistAssignId").getValue()
		if( BoxList.length == 0 ){
			Ext.Cmp('DistAssignId').setChecked();
			BoxList = Ext.Cmp("DistAssignId").getValue()
		}
		
		Ext.Cmp('dis_user_quantity').setValue(0);
		Ext.Cmp('dis_user_total').setValue(BoxList.length);
		Ext.Cmp('dis_user_total').disabled(true);
			
	} else {
		Ext.Cmp('dis_user_quantity').setValue(0);
		Ext.Cmp('dis_user_total').setValue(gTotalData.distribusi);
		Ext.Cmp('dis_user_total').disabled(true);
	}	
 }
 

// ======== end func ========> 

// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  
 */
 
 Ext.DOM.SearchDataDist = function()
{
	window.ViewDistributeData ({ orderby : '',  type: '', page: 0	 });	
}

// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  
 */
 Ext.DOM.ClearDataDist = function() 
{
	Ext.Serialize('formDisFilter').Clear(new Array('dis_record_page'));
	new Ext.DOM.SearchDataDist();
}

// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	SubmitDistribute
 *  
 */
 Ext.DOM.SubmitDistribute = function()
{
 var frmDistFilter = Ext.Serialize("formDisFilter"),
	 frmDistOption = Ext.Serialize("frmDistOption"),
	 frmDistGrid = new Array();
	
 if( !frmDistOption.Complete() )	{
	Ext.Msg('Form Option Not Complete !').Info();
	return false;
 }
 
 frmDistGrid['AssignId'] = Ext.Cmp('DistAssignId').getValue();
 var Data = new Array(
	frmDistFilter.getElement(), 
	frmDistOption.getElement(),
	frmDistGrid
  );
 // --------- set distribusi data ----> 
	
 Ext.Ajax 
 ({
	 url 	: Ext.EventUrl(['UserDistribusi', 'index']).Apply(),
	 method : 'POST',
	 param 	: Ext.Join( Data ).object(),
	 ERROR 	: function( e )
	 {
		Ext.Util( e ).proc(function( response ){
			if(  response.success ){
				Ext.Msg("Distribute Data ").Success();
				new Ext.DOM.SearchDataDist();				
			} else {
				Ext.Msg("Distribute Data ").Failed();
			}
		});
	}
  }).post();
} 


// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on Transfer part 	
 *  
 */
 Ext.DOM.SearchDataTrans =function() 
{	
 var cond = Ext.Serialize('formTransFilter').Required(new Array('trans_from_campaign_id') );
 if( cond ) {
	 window.ViewTransferData ({  orderby : '',   type : '',  page : 0 });
 }
 
}
// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  
 */
 
Ext.DOM.SubmitTransfer = function()
{
	var formTransFilter = Ext.Serialize("formTransFilter"),
	 frmTransOption = Ext.Serialize("frmTransOption"),
	 frmTransGrid = new Array();
	
 if( !frmTransOption.Complete() )	{
	Ext.Msg('Form Option Not Complete !').Info();
	return false;
 }
 
 frmTransGrid['AssignId'] = Ext.Cmp('TransAssignId').getValue();
 
 var Data = new Array(
	formTransFilter.getElement(), 
	frmTransOption.getElement(),
	frmTransGrid
  );
// --------- set distribusi data ----> 
	
   Ext.Ajax 
 ({
	 url 	: Ext.EventUrl(['UserTransfer', 'index']).Apply(),
	 method : 'POST',
	 param 	: Ext.Join( Data ).object(),
	 ERROR 	: function( e )
	 {
		Ext.Util( e ).proc(function( response ){
			if(  response.success ){
				Ext.Msg("Transfer Data ").Success();
				new Ext.DOM.SearchDataTrans();
				
			} else {
				Ext.Msg("Transfer Data ").Failed();
			}
		});
	}
  }).post();
}



// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  
 */

Ext.DOM.ClearDataTrans = function(){
	Ext.Serialize('formTransFilter').Clear(new Array('trans_record_page'));
}


// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  
 */
 Ext.DOM.ActionCheckTrans = function( obj )
{
	if( obj.checked && obj.value == 2 )
	{
		var BoxList = Ext.Cmp("TransAssignId").getValue()
		if( BoxList.length == 0 ){
			Ext.Cmp('TransAssignId').setChecked();
			BoxList = Ext.Cmp("TransAssignId").getValue()
		}
		
		Ext.Cmp('trans_user_quantity').setValue(0);
		Ext.Cmp('trans_user_total').setValue(BoxList.length);
		Ext.Cmp('trans_user_total').disabled(true);
			
	} else {
		Ext.Cmp('trans_user_quantity').setValue(0);
		Ext.Cmp('trans_user_total').setValue(gTotalData.transfer);
		Ext.Cmp('trans_user_total').disabled(true);
	}	
}

// ---------------------------------------------------------------------------------------------------------------
/*
 * @ def	 : $.ready
 * 
 * @ params	 : method on ready pages 
 * @ package : bucket datas 
 */
 
 
 Ext.DOM.SelectUserTransByGroup = function( obj )
{
	$('#trans_form_user_list').toogle ({ 
		url : 'MgtAssignment/SelectFromTrfUserByLevel',
		param :  {
			time 	 : Ext.Date().getDuration(),
			trans_from_user_group : obj.value
		},
		elval:['trans_from_user_group']
	});	
}	

// ---------------------------------------------------------------------------------------------------------------
/*
 * @ def	 : $.ready
 * 
 * @ params	 : method on ready pages 
 * @ package : bucket datas 
 */
 
 //http://192.168.10.236/bnilifeinsurance213r1/index.php/MgtAssignment/SelectTrfUserByLevel
 
 Ext.DOM.SelectUserTransToByGroup = function( obj )
{
	$('#trans_to_user_list').toogle ({ 
		url : 'MgtAssignment/SelectTrfUserByLevel',
		param :  {
			time 	 : Ext.Date().getDuration(),
			trans_to_user_group : Ext.Cmp(obj.id).getValue()
		},
		elval:['trans_to_user_group']
	});	
}
// ---------------------------------------------------------------------------------------------------------------
// ====================== PULL THE DATA  =========================================================================
// ---------------------------------------------------------------------------------------------------------------

/*
 * @ package	 	view data on distribute part 	
 *  
 */
 window.ViewPullData = function( obj )
{
  var formPullFilter = Ext.Serialize('formPullFilter');
	$('#ui-widget-pull-list').Spiner 
	({
		url 	: new Array('MgtAssignment','PagePullData'),
		param 	: Ext.Join([
					formPullFilter.getElement() 
				]).object(),
		order : {
			order_type : obj.type,
			order_by   : obj.orderby,
			order_page : obj.page	
		}, 
		handler  : 'ViewPullData',
		complete : function( obj ){
		  
		  // add customize for scroll testing 
		  
		  if( !$('.ui-widget-scroll-top-table-pull').length ){
				$("<div class='ui-widget-scroll-top-table-pull'><div class='ui-wdget-slider-top-pull' style='width:99%;'></div>").insertBefore(obj);
		  }
			
		// callculate of height this 
		  this.protectedHeighes = $('#ui-widget-pager-pull-list').innerHeight()+$('#ui-widget-pager-pull-list-bottom').innerHeight();
		  this.protectedHeights = this.protectedHeighes+15;
		  this.protectedWidths  = $(window).innerWidth() - ($(window).innerWidth()/3);
		  
		 // replace styleSheets of overflow method 	
		
			$(".ui-widget-pull-list").css({  
				width: Math.round(this.protectedWidths), 
				height :  Math.round(this.protectedHeights) 
			});
			
			$(".ui-widget-pull-list").addClass("ui-scroller-width-right-border-fixed");
			$(".ui-widget-fieldset").addClass("ui-group-width-right-border ui-group-width-right-righter");
				
			
			
			var TotalDatas = $('#ui-total-ui-widget-pager-pull-list-record').text();
				gTotalData.pulldata = $('#ui-total-ui-widget-pager-pull-list-record').text();
				Ext.Cmp('pull_user_quantity').setValue(0);
				Ext.Cmp('pull_user_total').setValue(TotalDatas);
				Ext.Cmp('pull_user_total').disabled(true);
				
				
				// add pull data 
				if( gTotalData.pulldata == 0 ){
					$(".ui-widget-pull-list").css({ 
						height: 268
					});
				}
				
				//console.log(window.percentData.perPull);
				if( window.percentData.perPull ){
					$('.ui-widget-pull-list').scrollLeft( window.percentData.perPull );
				}
				
				$(".ui-wdget-slider-top-pull").slider({
					slide: function( event, ui ) {
						var widthData = $('.ui-widget-pull-list').innerWidth();
							window.percentData.perPull = ((widthData * ui.value) /100);
						$('.ui-widget-pull-list').scrollLeft( window.percentData.perPull );
					}
				});	
		}
	});		
}

/*
 * @ package	 	SearchPullData
 *  
 */
 
 Ext.DOM.SearchPullData = function()
{
  var cond = Ext.Serialize('formPullFilter').Required(new Array('pull_from_campaign_id') );
  if( cond ) 
 {
	 new window.ViewPullData ({ 
		orderby : '',  
		type : '', 
		page : 0	 
	 });
  }
}

// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	ClearPullData
 *  
 */

 Ext.DOM.ClearPullData = function() { 
	new Ext.Serialize('formPullFilter').Clear(new Array('pull_record_page') );
}
// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  
 */
 Ext.DOM.ActionCheckPull = function( obj )
{
	if( obj.checked && obj.value == 2 )
	{
		var BoxList = Ext.Cmp("PullAssignId").getValue()
		if( BoxList.length == 0 ){
			Ext.Cmp('PullAssignId').setChecked();
			BoxList = Ext.Cmp("PullAssignId").getValue()
		}
		
		Ext.Cmp('pull_user_quantity').setValue(0);
		Ext.Cmp('pull_user_total').setValue(BoxList.length);
		Ext.Cmp('pull_user_total').disabled(true);
			
	} else {
		Ext.Cmp('pull_user_quantity').setValue(0);
		Ext.Cmp('pull_user_total').setValue(gTotalData.pulldata);
		Ext.Cmp('pull_user_total').disabled(true);
	}	
}

// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  
 */
 
 Ext.DOM.SelectUserPullByGroup = function( obj )
 {
	$('#pull_form_user_list').toogle 
	({ 
		url : 'MgtAssignment/SelectPullFromUserByLevel',
		param :  {
			time : Ext.Date().getDuration(),
			pull_from_user_group : Ext.Cmp(obj.id).getValue()
		},
		elval:['pull_from_user_group']
	});	
	 
 }
 
// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  http://192.168.10.236/bnilifeinsurance213r1/index.php/MgtAssignment/SelectPullToUserByLevel
 */
 
 Ext.DOM.SelectUserToByGroup = function( obj )
{
	$('#pull_to_user_list').toogle 
	({ 
		url : 'MgtAssignment/SelectPullToUserByLevel',
		param :  {
			time : Ext.Date().getDuration(),
			pull_to_user_group : Ext.Cmp(obj.id).getValue()
		},
		elval:['pull_to_user_group']
	});	
	 
 } 
 
// ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	view data on distribute part 	
 *  http://192.168.10.236/bnilifeinsurance213r1/index.php/MgtAssignment/SelectUserByLevel
 */

 Ext.DOM.SelectUserDistByGroup = function( obj )
 {
	$('#dis_user_list').toogle 
	({ 
		url : 'MgtAssignment/SelectUserByLevel',
		param :  {
			time : Ext.Date().getDuration(),
			dis_user_group : Ext.Cmp(obj.id).getValue()
		},
		elval:['dis_user_group']
	});	
	 
 } 
 // ---------------------------------------------------------------------------------------------------------------
/*
 * @ package	 	Ext.DOM.SubmitPullData 	
 *  
 */
  Ext.DOM.SubmitPullData = function()
{
 
 var formPullFilter = Ext.Serialize("formPullFilter"),
	 frmPullOption = Ext.Serialize("frmPullOption"),
	 frmPullGrid = new Array();
	
	if( !frmPullOption.Complete() )	{
		Ext.Msg('Form Option Not Complete !').Info();
		return false;
	 }
	 
	 frmPullGrid['AssignId'] = Ext.Cmp('PullAssignId').getValue();
	 
 var Data = new Array(
		formPullFilter.getElement(), 
		frmPullOption.getElement(),
		frmPullGrid
	);

	// --------- set distribusi data ----> 	
    Ext.Ajax 
   ({
		url 	: Ext.EventUrl(['UserPullData', 'index']).Apply(),
		method : 'POST',
		param 	: Ext.Join( Data ).object(),
		ERROR 	: function( e )
		{
			 Ext.Util( e ).proc(function( response )
			{
				if(  response.success )
				{
					Ext.Msg("Pull The Data ").Success();
					new Ext.DOM.SearchPullData();
					
				} else {
					Ext.Msg("Pull The Data ").Failed();
				}
			});
		}
	  }).post(); 
 }
 
  Ext.DOM.load_Recsource = function(obj)
 {
	$('#dis_recsource_name').toogle 
	({ 
		url : 'MgtAssignment/filtered_recsource',
		param :  {
			time : Ext.Date().getDuration(),
			campaign_name : Ext.Cmp(obj.id).getValue()
		},
		elval:['dis_campaign_name']
	});
 };	
 
 Ext.DOM.load_Recsource_pull = function(obj)
 {
	$('#pull_recsource_name').toogle 
	({ 
		url : 'MgtAssignment/filtered_recsource',
		param :  {
			time : Ext.Date().getDuration(),
			campaign_name : Ext.Cmp(obj.id).getValue()
		},
		elval:['pull_from_campaign_id']
	});
 };
 

  Ext.DOM.CallStatCheck=function (params) {
	 console.log('CallStatCheck',params.value)
	var param=[];
	param['value'] = params.value;
	param['Campaign']=Ext.Cmp('pull_from_campaign_id').getValue()
	if(param['Campaign']!=''||param['Campaign']!=0){
		if(params.value==8){
		console.log('true',params.value)
		Ext.Ajax({
		url 	: Ext.EventUrl(['MgtAssignment','getDisagree']).Apply(),
		method 	: 'POST',
		param  	: Ext.Join([param]).object() ,
		success  : function( xhr ){
			Ext.Util( xhr ).proc(function(xhr){
				// console.log(xhr);
				// document.getElementById("aading").innerHTML = "New text!"
				document.getElementById("aading").innerHTML ="<select id='disagree' name='disagree' class='select tolong'><option value='Choose'>Choose</option></select>"

				xhr.forEach(function (resp) {
					console.log(resp.DisagreeCode)
					$('#disagree').append('<option value="'+resp.DisagreeId+'">'+resp.DisagreeDesc+'</option>')
                    })
			});
		}
	}).post();
	 }
	 
	}else{
		$('#disagree').prop( "disabled", true );
	 }
	 


 }

  Ext.DOM.CallStatCheck2=function (params) {
	 console.log('CallStatCheck',params.value)
	var param=[];
	param['value'] = params.value;
	param['Campaign']=Ext.Cmp('trans_from_campaign_id').getValue()
	if(param['Campaign']!=''||param['Campaign']!=0){
		if(params.value==8){
		console.log('true',params.value)
		Ext.Ajax({
		url 	: Ext.EventUrl(['MgtAssignment','getDisagree']).Apply(),
		method 	: 'POST',
		param  	: Ext.Join([param]).object() ,
		success  : function( xhr ){
			Ext.Util( xhr ).proc(function(xhr){
				// console.log(xhr);
				// document.getElementById("aading").innerHTML = "New text!"
				document.getElementById("aading2").innerHTML ="<select id='disagree2' name='disagree2' class='select tolong'><option value='Choose'>Choose</option></select>"

				xhr.forEach(function (resp) {
					console.log(resp.DisagreeCode)
					$('#disagree2').append('<option value="'+resp.DisagreeId+'">'+resp.DisagreeDesc+'</option>')
                    })
			});
		}
	}).post();
	 }else{
		$('#disagree2').prop( "disabled", true );
	 }
	}
	 


 }
// --------------------------------------------------------------------------------------------------------------- 
// ====================== CAMPAIGN THE TRANSFER  =================================================================
// ---------------------------------------------------------------------------------------------------------------

/*
 * @ package	 	view data on distribute part 	
 *  
 */
 
 
 
// ---------------------------------------------------------------------------------------------------------------
/*
 * @ def	 : $.ready
 * 
 * @ params	 : method on ready pages 
 * @ package : bucket datas 
 */
 
$(document).ready( function()
{
  $('#ui-widget-user-assigment').mytab().tabs();
  $('#ui-widget-user-assigment').mytab().tabs("option", "selected", 0);
  $('#ui-widget-user-assigment').css({'background-color':'#FFFFFF'});
  $("#ui-widget-user-assigment").mytab().close(function(){
	  Ext.DOM.RoleBack();
  }, true);
  
  $('#ui-widget-asg-distribute').css({'background-color':'#FFFFFF'});
  $('#ui-widget-asg-transfer').css({'background-color':'#FFFFFF'});
  $('#ui-widget-asg-pooling').css({'background-color':'#FFFFFF'});
  $('#ui-widget-cmp-distribute').css({'background-color':'#FFFFFF'});
  $('.xselect').chosen();
  $('.date').datepicker({showOn: 'button',  changeYear:true, 
		changeMonth:true, buttonImage: Ext.Image('calendar.gif'),  
		buttonImageOnly: true,  dateFormat:'dd-mm-yy',readonly:true
  });
  
 // ----------------- Distribute   ---------------------------------------	
   new Ext.DOM.SearchDataDist();
   $("#dis_user_list").toogle({url:'MgtAssignment/SelectUserByLevel', param:{}, elval:['dis_user_group','dis_user_type']});
   $("#dis_recsource_name").toogle({url:'MgtAssignment/filtered_recsource', param:{}, elval:['dis_campaign_name']});
   $("#pull_recsource_name").toogle({url:'MgtAssignment/filtered_recsource', param:{}, elval:['pull_from_campaign_id']});
   
// ----------------- Pull Transfer  ---------------------------------------		
	
   $('#trans_to_user_list').toogle({url:'MgtAssignment/SelectTrfUserByLevel',param:{},elval:['trans_to_user_group','trans_user_type']});
   $("#trans_from_campaign_id").toogle();
   $('#trans_call_status_id').toogle();
   $("#trans_call_result_id").toogle();
   $("#dis_call_reason").toogle();
	
// ----------------- Pull The Data ---------------------------------------	
	
   $('#pull_to_user_list').toogle({url:'MgtAssignment/SelectPullToUserByLevel',param:{},elval:['pull_to_user_group','pull_user_type']});
   $("#pull_from_campaign_id").toogle();
   $("#pull_call_result_id").toogle();
   $('#pull_call_status_id').toogle();
  
	
//  ---------------- end function ready data -----------------------------
	
});
	
	
</script>