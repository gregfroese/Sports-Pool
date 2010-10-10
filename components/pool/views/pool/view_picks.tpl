<p></p>
<h2>View Picks</h2>
{if $segment->status->id == 3}
  	{link action="enterPicks" id=$segment->id text="Enter Picks"}
  {/if}

<div id="scores" class="scores">
	<table class="hor-zebra" id="hor-zebra">
		{* create the dynamic table headers for each game *}
		<tr>
			<th>User</th>
			{foreach from=$segment->games item="game"}
				<th class="center"><div class="team">{$game->awayteam.name}</div><div style="color: red">vs</div><div class="team">{$game->hometeam.name}</div></th>
			{/foreach}
			<th>Total</th>
		</tr>
		
		{* Now show the picks for each user if the current user's pick for that game is locked *}
		{assign var="grandTotal" value=0}
		{assign var="userCount" value=0}
		{foreach from=$segment->season->users item="user"}
			{assign var="userCount" value=$userCount + 1}
			{assign var="totalPoints" value=0}
			{if $currentUser.id == $user.id}
				{assign var="class" value="currentUser"}
			{else}
				{assign var="class" value=""}
			{/if}
			<tr class="{cycle values="even,odd"} {$class}">
				<td>
					{if $currentUser.id == $user.id}
						<div class="currentUser">{$user.first_name}</div>
					{else}
						<div class="">{$user.first_name}</div>
					{/if}
				</td>
				{* now get their pick for each game *}
				{assign var="count" value="0"}
				{foreach from=$segment->games item="game"}
					{assign var="count" value=$count+1}
					{$game->getPick($user) assign="pick"}
					{$game->getPick($currentUer) assign="userPick"}
					{$game->getPoints($user) assign="points"}
					
					{* have to make sure we display the picks in the right column for each game *}
					{* important if the user has skipped making a pick for a game *}
					<td class="picks">
						{if $pick.game_id == $order_of_games[$count]}
							{* show the picks if they belong to the current user *}
							{* or if the current user's pick is locked *}
							{if $pick.user_id == $currentUser.id or $userPick->status.name == "Locked"} 
								{if $pick.team_id == -1}
									{if $pick->status.name == "Locked"}
										<div class="locked center">Tie</div>
									{else}
										<div class="center">Tie</div>
									{/if}
								{else}
									{if $pick->status.name == "Locked"}
										<div class="locked center">{$pick->team.name}</div>
									{else}
										<div class="center">{$pick->team.name}</div>
									{/if}
								{/if}
								{if $points.id != ""}
									{if $points.points > 0}
										{assign var="class" value="green"}
									{else}
										{assign var="class" value="red"}
									{/if}
									<div class="points center {$class}">{$points.points}</div>
									{assign var="totalPoints" value=$totalPoints + $points.points}
								{/if}
							{else}
								<div class="center">N/A: Lock your pick to see</div>
							{/if}
						{else}
							<div class="nopick center">No pick</div>
						{/if}
					</td>
				{/foreach}
				<td class="center">{$totalPoints}</td>
				{assign var="grandTotal" value=$grandTotal + $totalPoints}
			</tr>
		{/foreach}
	</table>
	<div class="average">Average points per player: {$grandTotal / $userCount}</div>
</div>