<h1>Season: {$segment->season.name} - {$segment->name}</h1>
<table class="hor-zebra" id="hor-zebra">
	<tr>
		<td>
			<table id="game_picks">
				<tr>
					<th width="5%">Game ID</th>
					<th width="20%">Away Team</th>
					<th width="5%"></th>
					<th width="20%">Home Team</th>
					<th width="5%">Modifier</th>
					<th width="10%">Action</th>
					<th width="20%">Availability</th>
				</tr>
			</table>
		</td>
	</tr>
	{foreach from=$segment->games item=game key=key}
	{strip}
		<tr class="{cycle values="even, odd"}">
			<td>
				<div class="game_{$game.id}">
					{render_partial template="game_pick_detail.tpl" game=$game}
				</div>
			</td>
		</tr>
	{/strip}
	{/foreach}
</table>

<h2>Bonus Questions</h2>
<table id="hor-zebra" class="hor-zebra">
	<tr>
		<th>ID</th>
		<th>Question</th>
		<th>Modifier</th>
		<th>Response</th>
	</tr>
	{foreach from=$segment->bonus item="bonus"}
		<tr>
			<td>{$bonus.id}</td>
			<td>{$bonus.question}</td>
			<td>{$bonus.modifier}</td>
			<td>do this</td>
		</tr>
	{/foreach}
</table>