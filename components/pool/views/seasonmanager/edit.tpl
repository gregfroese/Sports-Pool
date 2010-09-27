{* Smarty *}
<h1>Season Manager: {if $params["name"] ne ""}Edit{else}Create{/if}</h1>
{link action='index' text='Back to season list'}
<link rel="stylesheet" href="/css/style.css" type="text/css">
{if $message ne ""}
	<div class="message">{$message}</div>
{/if}
{if $error ne ""}
	<div class="error">{$error}</div>
{/if}

<div id="content">
	<form class="form" method="POST" action="">
	  	<label for="name">Name</label>
	    <div class="">
	    	<input type="text" value="{$season.name}" id="name" class="name" name="name">
		</div>
		<label for="start_year">Start Year</label>
		<div class="">
	    	<input type="text" value="{$season.start_year}" id="start_year" class="start_year" name="start_year">
		</div>
		<label for="end_year">End Year</label>
		<div class="">
			<input type="text" value="{$season.end_year}" id="end_year" class="end_year" name="end_year">
		</div>
		 <div class="">
			<select id="sport_id" name="sport_id">
				<option value="0">Select sport</option>
				{foreach from=$sports key=key item=sport}
					<option {if $sport.id == $season.sport_id}selected{/if} value="{$sport.id}">{$sport.name}</option>
				{/foreach}
			</select>
		</div>
		<div class="">
			<select id="status_id" name="status_id">
				<option value="0">Select a status</option>
				{foreach from=$statuses key=key item=status}
					<option {if $status.id == $season.status_id}selected{/if} value="{$status.id}">{$status.name}</option>
				{/foreach}
			</select>
		</div>
		<div class="">
		<input type="submit" class="buttons" value="Submit" name="Submit">
		</div>
	</form>
</div>