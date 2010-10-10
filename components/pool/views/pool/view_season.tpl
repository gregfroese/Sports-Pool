<h1>Season: {$season.name}</h1>
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

<img src="{$chart}" title="Chart" />