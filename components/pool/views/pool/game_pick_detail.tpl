{$game->getPick() assign="pick"}
<table id="game_picks">
	<tr>
		<td width="5%">{$game.id}</td>
		<td width="20%">
			{if $pick.team_id == $game.away_id}
				{assign var="class" value="pick chosen"}
			{else}
				{assign var="class" value="pick"}
			{/if}
			<div class="{$class}">
				{if $pick->status.name == "" or $pick->status.name == "Open"}
					{if $date > $game.start_date and $date < $game.end_date and $game->status.name != "Closed"}
						<a class="pick" href="" onClick="pickTeam({$game.id},{$game.away_id}); return false;">{$game->awayteam->name}</a>
					{else}
						{$game->awayteam->name}
					{/if}
				{else}
					{$game->awayteam->name}
				{/if}
			</div>
		</td>
		<td width="5%">
			{if $pick.team_id == -1}
				{assign var="class" value="pick chosen"}
			{else}
				{assign var="class" value="pick"}
			{/if}
			<div class="{$class}">
				{if $pick->status.name == "" or $pick->status.name == "Open"}
					{if $date > $game.start_date and $date < $game.end_date and $game->status.name != "Closed"}
						<a href="" onClick="pickTie({$game.id}); return false;">Tie</a>
					{else}
						Tie
					{/if}
				{else}
					Tie
				{/if}
			</div>
			</td>
		<td width="20%">
			{if $pick.team_id == $game.home_id}
				{assign var="class" value="pick chosen"}
			{else}
				{assign var="class" value="pick"}
			{/if}
			<div class="{$class}">
				{if $pick->status.name == "" or $pick->status.name == "Open"}
					{if $date > $game.start_date and $date < $game.end_date and $game->status.name != "Closed"}
						<a class="pick" href="" onClick="pickTeam({$game.id},{$game.home_id}); return false;">{$game->hometeam->name}</a>
					{else}
						{$game->hometeam.name}
					{/if}
				{else}
					{$game->hometeam->name}
				{/if}
			</div>
		</td>
		<td width="5%">{$game.modifier}</td>
		<td width="10%">
			{if $pick->status.name == ""}
				N/A
			{else}
				{if $pick->status.name != "Locked"}
					<a href="" onClick="lockPick({$game.id}); return false;">Lock</a>
				{else}
					Locked
				{/if}
			{/if}
		</td>
		<td width="20%">
			{date_diff date2=$game.end_date}
		</td>
	</tr>
</table>