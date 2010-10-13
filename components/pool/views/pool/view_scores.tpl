<h1>{$segment->season.name}: {$segment.name} - View Scores</h1>
{link component="pool" action="viewSeason" id=$segment->season.id text="Season Overview"}
<div id="scores" class="picksContainer">
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
						Not included in average
						{if $game.notes == ""}
							<br />{$game.notes}
						{/if}
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
{render_partial template="view_bonus.tpl" currentUser=$currentUser segment=$segment}