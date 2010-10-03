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