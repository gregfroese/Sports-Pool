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
		<input type="hidden" value="1" name="save">
		<input type="hidden" value="{$segment.id}" name="segment_id">
		<div>
		  	<label class="block" for="awayteam">Away Team ({$game.away_id})</label>
	    	<select id="away_id" name="away_id">
	    		<option value="0">Select away team</option>
	    		{foreach from=$teams key=key item=team}
	    			<option {if $team.id == $game->awayteam.id}selected{/if} value="{$team.id}">{$team.name}</option>
	    		{/foreach}
	    	</select>
		</div>
		<div class="clear"></div>
		<div>
			<label class="block" for"awayscore">Away Score</label>
			<input type="text" value="{$game.away_score}" name="away_score" id="away_score" />
		</div>
		<div class="clear"></div>
		<div>	
			<label class="block" for="hometeam">Home Team</label>
	    	<select id="home_id" name="home_id">
	    		<option value="0">Select home team</option>
	    		{foreach from=$teams key=key item=team}
	    			<option {if $team.id == $game->hometeam.id}selected{/if} value="{$team.id}">{$team.name}</option>
	    		{/foreach}
	    	</select>
		</div>
		<div class="clear"></div>
		<div>
			<label class="block" for"homescore">Home Score</label>
			<input type="text" value="{$game.home_score}" name="home_score" id="home_score" />
		</div>
		<div class="clear"></div>
		<div class="">
			<label class="block"></label>
			<select id="status_id" name="status_id">
				<option value="0">Select a status</option>
				{foreach from=$statuses key=key item=status}
					<option {if $status.id == $game.status_id}selected{/if} value="{$status.id}">{$status.name}</option>
				{/foreach}
			</select>
		</div>
		<div class="clear"></div>
		<div>
			<label class="block" for"modifier">Modifier</label>
			<input type="text" value="{$game.modifier}" name="modifier" id="modifier" />
		</div>
		<div class="clear"></div>
		<div>
			<label class="block" for"notes">Notes</label>
			<textarea rows="5" cols="80" name="notes" id="notes">{$game.notes}</textarea>
		</div>
		<div class="clear"></div>
		<div>
			<label class="block" for"start_date">Start Date</label>
			<input type="text" class="datepicker" value="{$game.start_date}" name="start_date" id="start_date" />
		</div>
		<div class="clear"></div>
		<div>
			<label class="block" for"end_date">End Date</label>
			<input type="text" class="datepicker" value="{$game.end_date}" name="end_date" id="end_date" />
		</div>
		<div class="clear"></div>
		<div class="">
			<input type="submit" class="buttons" value="Submit" name="Submit">
		</div>
	</form>
</div>
