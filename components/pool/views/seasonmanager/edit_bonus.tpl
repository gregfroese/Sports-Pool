{if $bonus.id == ""}
	<h2>Create Bonus</h2>
{else}
	<h2>Edit Bonus</h2>
{/if}
{form action="saveBonus" controller="seasonmanager"}
	{hidden name="segment_id" value=$segment.id}
	{hidden name="bonus_id" value=$bonus.id}
	<div>
		<label class="block">Question</label>
		{textbox name="question" value=$bonus.question}
	</div>
	<div id="clear" class="clear"></div>
	<div>
		<label class="block">Status</label>
		<select name="status_id">
			{foreach from=$statuses item="status"}
				<option {if $bonus.status_id == $status.id}selected{/if} value={$status.id}>{$status.name}</option>
			{/foreach}
		</select>
	</div>
	<div id="clear" class="clear"></div>
	<div>
		<label class="block">Modifier</label>
		{if $bonus.modifier != ""}{assign var="modifier" value=$bonus.modifier}{else}{assign var="modifier" value=1}{/if}
		{textbox name="modifier" value=$modifier}
	</div>
	<div id="clear" class="clear"></div>
	<div>
		<label class="block">Start Date</label>
		{textbox name="start_date" value="{$bonus.start_date}" class="datepicker"}
	</div>
	<div id="clear" class="clear"></div>
	<div>
		<label class="block">End Date</label>
		{textbox name="end_date" value="{$bonus.end_date}" class="datepicker"}
	</div>
	<div id="clear" class="clear"></div>
	<div>
		{submit value="Save bonus"}
	</div>
{/form}