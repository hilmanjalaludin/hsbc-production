
<table cellspacing=1 cellpadding=0 width='99%'>
<thead>
<tr height=22 >
	<th class="ui-state-default ui-corner-top ui-state-focus ">&nbsp;No.</th>
	<th class="ui-state-default ui-corner-top ui-state-focus">&nbsp;Username</th>
	<th class="ui-state-default ui-corner-top ui-state-focus">&nbsp;Call</th>
	<th class="ui-state-default ui-corner-top ui-state-focus">&nbsp;Conected</th>
	<th class="ui-state-default ui-corner-top ui-state-focus">&nbsp;Abandone</th>
	<th class="ui-state-default ui-corner-top ui-state-focus">&nbsp;(%)&nbsp;Connected</th>
	<th class="ui-state-default ui-corner-top ui-state-focus">&nbsp;(%)&nbsp;Abandone</th>
	<th class="ui-state-default ui-corner-top ui-state-focus">&nbsp;Talk Time</th>
	<th class="ui-state-default ui-corner-top ui-state-focus">&nbsp;Avg Talk</th>
</tr>
</thead>
<tbody>
<?php 
$no = 1;
$total_calls = 0;
$total_connected = 0;
$total_abandone = 0;
$total_talk =0;
foreach( $param['AgentId'] as $num => $AgentId ) :
	$Agents				= $Users[$AgentId];
	$color 				= ($no%2!=0?'#FFFEEE':'#FFFFFF');
	$percent_connected 	= ($view[$AgentId]['tots']?(round($view[$AgentId]['tot_connected']/$view[$AgentId]['tots'],2)*100) : 0);
	$percent_abandone 	= ($view[$AgentId]['tots']?(round($view[$AgentId]['tot_abandone']/$view[$AgentId]['tots'],2)*100) : 0);
	$talktime_agent 	= _getDuration(($view[$AgentId]['tot_talk']?$view[$AgentId]['tot_talk']:0)); 						
	$avg_talk_time		= _getDuration(($view[$AgentId]['tots']?($view[$AgentId]['tot_talk']/$view[$AgentId]['tot_connected']):0));
	
?>
<tr height='22' bgcolor='<?php __($color); ?>'>
	<td class="content-first">&nbsp;<?php __($no);?></td>
	<td class="content-middle left">&nbsp;<?php __($Agents['name']);?></td>
	<td class="content-middle right">&nbsp;<?php __(($view[$AgentId]['tots']?$view[$AgentId]['tots']:0));?></td>
	<td class="content-middle right">&nbsp;<?php __(($view[$AgentId]['tot_connected']?$view[$AgentId]['tot_connected']:0));?></td>
	<td class="content-middle right">&nbsp;<?php __(($view[$AgentId]['tot_abandone']?$view[$AgentId]['tot_abandone']:0));?></td>
	<td class="content-middle right">&nbsp;<?php __($percent_connected);?></td>
	<td class="content-middle right">&nbsp;<?php __($percent_abandone);?></td>
	<td class="content-middle right">&nbsp;<?php __($talktime_agent);?></td>
	<td class="content-lasted right">&nbsp;<?php __($avg_talk_time);?></td>
</tr>
<?php 

$total_calls 	 += $view[$AgentId]['tots'];
$total_connected += $view[$AgentId]['tot_connected'];
$total_abandone  += $view[$AgentId]['tot_abandone'];
$total_talk 	 += $view[$AgentId]['tot_talk'];
$no++; 
endforeach;


$tots_percent_connected = ($total_calls?(round($total_connected/$total_calls,2)*100) : 0);
$tots_percent_abandone 	= ($total_calls?(round($total_abandone/$total_calls,2)*100) : 0);
$tots_talktime_agent 	= _getDuration(($total_talk?$total_talk:0)); 						
$tots_avg_talk_time		= _getDuration(($total_talk?$total_talk/$total_connected:0));

?>
<tr height='22' bgcolor='#eaf6fa'>
	<td class="content-first" colspan=2>&nbsp;<b>Summary</b></td>
	<td class="content-middle right">&nbsp;<b><?php __($total_calls);?></b></td>
	<td class="content-middle right">&nbsp;<b><?php __($total_connected);?></b></td>
	<td class="content-middle right">&nbsp;<b><?php __($total_abandone);?></b></td>
	<td class="content-middle right">&nbsp;<b><?php __($tots_percent_connected);?></b></td>
	<td class="content-middle right">&nbsp;<b><?php __($tots_percent_abandone);?></b></td>
	<td class="content-middle right">&nbsp;<b><?php __($tots_talktime_agent );?></b></td>
	<td class="content-lasted right">&nbsp;<b><?php __($tots_avg_talk_time);?></b></td>
</tr>

</tbody>
</table>