<link rel="stylesheet" href="/css/style.css" type="text/css">
<script type="text/javascript" src="/js/jquery.js"></script>

<h1>View Scores</h1>

<div id="scores" class="scores">
	<table class="hor-zebra" id="hor-zebra">
		{* create the dynamic table headers for each game *}
		<tr>
			<th>User</th>
			{foreach from=$segment->games item="game"}
				<th>{$game.id}: {$game->awayteam.name} vs {$game->hometeam.name}</th>
			{/foreach}
		</tr>
		
		{* Now show the picks for each user if the current user's pick for that game is locked *}
		{foreach from=$segment->season->users item="user"}
			<tr class="{cycle values="even, odd"} picks">
				<td>{$user.first_name}</td>
				{* now get their pick for each game *}
				{assign var="count" value="0"}
				{foreach from=$segment->games item="game"}
					{assign var="count" value=$count+1}
					{$game->getPick($user) assign="pick"}
					{* have to make sure we display the picks in the right column for each game *}
					{* important if the user has skipped making a pick for a game *}
					<td>
						{if $pick.game_id == $order_of_games[$count]}
							{* show the picks if they belong to the current user *}
							{* or if the current user's pick is locked *}
							{if $pick.user_id == $currentUser.id or $pick->status.name == "Locked"} 
								{if $pick.team_id == -1}
									{if $pick->status.name == "Locked"}
										<div class="locked">Tie</div>
									{else}
										Tie
									{/if}
								{else}
									{if $pick->status.name == "Locked"}
										<div class="locked">{$pick->team.name}</div>
									{else}
										{$pick->team.name}
									{/if}
								{/if}
							{else}
								N/A: Lock your pick to see
							{/if}
						{else}
							<div class="nopick">No pick</div>
						{/if}
					</td>
				{/foreach}
			</tr>
		{/foreach}
	</table>
</div>