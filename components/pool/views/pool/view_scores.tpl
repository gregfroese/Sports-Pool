<h1>{$segment->season.name}: {$segment.name} - View Scores</h1>

<div id="scores" class="scores">
	<table class="hor-zebra" id="hor-zebra">
		<tr>
			<th>Game ID</th>
			<th>Away Team</th>
			<th>Away Score</th>
			<th>Home Team</th>
			<th>Home Score</th>
			<th>Modifier</th>
			<th>Status</th>
			<th>Notes</th>
		</tr>
		{foreach from=$segment->games item=game}
			<tr class="{cycle values="even, odd"}">
				<td>{$game.id}</td>
				<td>{$game->awayteam.name}</td>
				<td>{$game.away_score}</td>
				<td>{$game->hometeam.name}</td>
				<td>{$game.home_score}</td>
				<td>{$game.modifier}</td>
				<td>{$game->status.name}</td>
				<td>
					{if $game->status.name == "Closed"}
						{$game.notes}
					{else}
						{$game.notes}<br />
						Not included in average
					{/if}
				</td>
			</tr>
		{/foreach}
			<tr>
				<td colspan=2>Average</td>
				<td>{$average["away"]}</td>
				<td></td>
				<td>{$average["home"]}</td>
			</tr>
	</table>
</div>

{render_partial template="view_picks.tpl" currentUser=$currentUser segment=$segment}