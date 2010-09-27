{* Smarty *}
<h1>Segment Manager: {if $segment.name ne ""}Edit{else}Create{/if}</h1>
<a href="/seasonmanager/manage/{$season.id}">Back to Manage Season</a>
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
		<input type="hidden" value="{$season.id}" name="seasonid">
	  	<label for="name">Name</label>
	    <div class="">
	    	<input type="text" value="{$segment.name}" id="name" class="name" name="name">
		</div>
		<div class="">
			<select id="status_id" name="status_id">
				<option value="0">Select a status</option>
				{foreach from=$statuses key=key item=status}
					<option {if $status.id == $segment.status_id}selected{/if} value="{$status.id}">{$status.name}</option>
				{/foreach}
			</select>
		</div>
		<div class="">
		<input type="submit" class="buttons" value="Submit" name="Submit">
		</div>
	</form>
</div>