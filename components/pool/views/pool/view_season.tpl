<script type="text/javascript" src="/js/viewSeason.js"></script>
<script language="javascript" type="text/javascript" src="/js/visualize.jQuery.js"></script>
<script language="javascript" type="text/javascript" src="/js/excanvas.js"></script>
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
	<caption>Leaderboard</caption>
	<thead>
		<tr>
			<td></td>
			<th scope="col">Total</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$chartPoints key="name" item="chartPoint"}
			<tr>
				<th scope="row">{$name}</th>
				<td>{$chartPoint.total}</td>
			</tr>
		{/foreach}
	</tbody>
</table>

<table class="chartLine">
	<caption>My performance</caption>
	<thead>
		<tr>
			<td></td>
			{foreach from=$ranges["High"] item="points" key="name"}
				<th scope="col">{$name}</th>
			{/foreach}
		</tr>
	</thead>
	<tbody>
		<tr>
			<th scope="col">High</th>
			{foreach from=$ranges["High"] item="points" key="name"}
				<td>{$points}</td>
			{/foreach}
		</tr>
		<tr>
			<th scope="col">Low</th>
			{foreach from=$ranges["Low"] item="points" key="name"}
				<td>{$points}</td>
			{/foreach}
		</tr>
		<tr>
			<th scope="col">{$username}</th>
			{foreach from=$ranges[$username] item="points" key="name"}
				<td>{$points}</td>
			{/foreach}
		</tr>
	</tbody>
</table>

<table class="chartLine">
	<caption>My cumulative performance</caption>
	<thead>
		<tr>
			<td></td>
			{foreach from=$segmentRanges["High"] item="points" key="name"}
				<th scope="col">{$name}</th>
			{/foreach}
		</tr>
	</thead>
	<tbody>
		<tr>
			<th scope="col">High</th>
			{foreach from=$segmentRanges["High"] item="points" key="name"}
				<td>{$points}</td>
			{/foreach}
		</tr>
		<tr>
			<th scope="col">Low</th>
			{foreach from=$segmentRanges["Low"] item="points" key="name"}
				<td>{$points}</td>
			{/foreach}
		</tr>
		<tr>
			<th scope="col">{$username}</th>
			{foreach from=$userTotal[$username] item="points" key="name"}
				<td>{$points}</td>
			{/foreach}
		</tr>
	</tbody>
</table>
