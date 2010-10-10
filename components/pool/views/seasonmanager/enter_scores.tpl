<h1>Enter Scores: {$segment->season.name} - {$segment->name}</h1>
<div class="picksContainer">
	{form action="saveScores" controller="seasonmanager"}
		{hidden name="segment_id" value=$segment.id}
		<table class="hor-zebra" id="hor-zebra">
			<tr>
				<th>Game ID</th>
				<th>Away Team</th>
				<th>Away Score</th>
				<th>Home Team</th>
				<th>Home Score</th>
			</tr>
			{foreach from=$segment->games item=game key=key}
			{strip}
				<tr class="{cycle values="even, odd"}">
					<td>{$game.id}</td>
					<td>{$game->awayteam.name}</td>
					<td>{textbox name="away_score[{$game.id}]" value=$game.away_score}</td>
					<td>{$game->hometeam.name}</td>
					<td>{textbox name="home_score[{$game.id}]" value=$game.home_score}</td>
				</tr>
			{/strip}
			{/foreach}
		</table>
		<p>
			{submit value="Save Scores"}
		</p>
	{/form}
</div>