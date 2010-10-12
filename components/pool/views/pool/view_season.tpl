<script type="text/javascript" src="/js/viewSeason.js"></script>
<script language="javascript" type="text/javascript" src="/js/visualize.jQuery.js"></script>
<link rel="stylesheet" href="/css/visualize.css" type="text/css">
<link rel="stylesheet" href="/css/visualize-dark.css" type="text/css">

<h1>Season: {$season.name}</h1>
{hidden name="season_id" value=$season.id class="season_id"}
<div class="picksContainer">
	<table class="hor-zebra" id="hor-zebra">
		<tr>
			<th>Segment</th>
			<th>Status</th>
			<th colspan=5>Actions</th>
		</tr>
		{foreach from=$season->segments item=segment key=key}
		{strip}
		   <tr class="{cycle values="even, odd"}">
		      <td>{$segment->name}</td>
		      <td>{$segment->status->name}</td>
			  <td>
			  	{if $segment->status->id == 3}
			  		{link action="enterPicks" id=$segment->id text="Enter Picks"}
			  	{/if}
			  </td>
			  <td>{link action="viewScores" id=$segment->id text="View Scores"}</td>
			  <td>{link action="viewPicks" id=$segment->id text="View Picks"}</td>
		   </tr>
		{/strip}
		{/foreach}
	</table>
</div>

<table class="chart">
	<caption>Points by Segment</caption>
	<thead>
		<tr>

			<td></td>
			{* use this for weekly detail
			{foreach from=$season->segments item="segment"}
				<th scope="col">{$segment.name}</th>
			{/foreach}
			*}
			<th scope="col">Total</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$season->users item="user"}
			{assign var="total" value=0}
			<tr>
				<th scope="row">{$user.first_name} {$user.last_name}</th>
				{foreach from=$season->segments item="segment"}
                                        {$segment->getPointsBySegment($user) assign="points"}
                                        {if $total == 0}
						{assign var="total" value=$points}
                                        {else}
                                                {assign var="total" value=$total+$points}
                                        {/if}
                                {/foreach}
				<td>{$total}</td>
			</tr>
		{/foreach}
	</tbody>
</table>
