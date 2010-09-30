<td>{link action="editGame" id=$segment.id subid=$game.id text=$game.id}</td>
<td>{$game->awayteam.name}</td>
<td>{$game.away_score}</td>
<td>{$game->hometeam.name}</td>
<td>{$game.home_score}</td>
<td><div class="gameStatus_{$game.id}">{$game->status.name}</div></td>
<td>{$game.modifier}</td>
<td>{$game.notes}</td>
<td>{$game.start_date}</td>
<td>{$game.end_date}</td>
<td>
	<div class="gameAction_{$game.id}">
		{if $game->status->name == "Closed"}
			<a href="#" onClick="reopenGame({$game.id})">Re-Open</a>
		{else}
			<a href="#" onClick="closeGame({$game.id})">Close</a>
		{/if}
	</div>
</td>
