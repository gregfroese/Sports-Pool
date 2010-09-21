{* Smarty *}
<h1>Game Manager: {if $params["id"] ne ""}Edit{else}Create{/if}</h1>
<a href="/seasonmanager/manageSegment/{$season.id}/{$segment.id}">Back to Manage Segment</a><br /><br />
<link rel="stylesheet" href="/css/style.css" type="text/css">
{if $message ne ""}
	<div class="message">{$message}</div>
{/if}
{if $error ne ""}
	<div class="error">{$error}</div>
{/if}

<div id="content">
	<form class="form" method="POST" action="">
		<div>
		  	<label for="awayteam">Away Team ({$game.away_id})</label>
	    	{$game->get_team($game.away_id) assign='awayteam'}
	    	<select id="away_id" name="away_id">
	    		<option value="0">Select away team</option>
	    		{foreach from=$teams key=key item=team}
	    			<option {if $team.id == $awayteam.id}selected{/if} value="{$team.id}">{$team.name}</option>
	    		{/foreach}
	    	</select>
		</div>
		<div>
			<label for"awayscore">Away Score</label>
			<input type="text" value="{$game.away_score}" name="away_score" id="away_score" />
		</div>
		<div>	
			<label for="hometeam">Away Team ({$game.home_id})</label>
	    	{$game->get_team($game.home_id) assign='hometeam'}
	    	<select id="home_id" name="home_id">
	    		<option value="0">Select home team</option>
	    		{foreach from=$teams key=key item=team}
	    			<option {if $team.id == $hometeam.id}selected{/if} value="{$team.id}">{$team.name}</option>
	    		{/foreach}
	    	</select>
		</div>
		<div>
			<label for"homescore">Home Score</label>
			<input type="text" value="{$game.home_score}" name="home_score" id="home_score" />
		</div>
		<div class="">
			<select id="status_id" name="status_id">
				<option value="0">Select a status</option>
				{foreach from=$statuses key=key item=status}
					<option {if $status.id == $game.status_id}selected{/if} value="{$status.id}">{$status.name}</option>
				{/foreach}
			</select>
		</div>
		<div>
			<label for"modifier">Modifier</label>
			<input type="text" value="{$game.modifier}" name="modifier" id="modifier" />
		</div>
		<div>
			<label for"notes">Notes</label>
			<textarea rows="5" cols="80" name="notes" id="notes">{$game.notes}</textarea>
		</div>
		<div>
			<label for"start_date">Start Date</label>
			<input type="text" value="{$game.start_date}" name="start_date" id="start_date" />
		</div>
		<div>
			<label for"end_date">End Date</label>
			<input type="text" value="{$game.end_date}" name="end_date" id="end_date" />
		</div>
		<div class="">
			<input type="submit" class="buttons" value="Submit" name="Submit">
		</div>
	</form>
</div>