<div class="bonus picksContainer">
	<h2>Bonus questions</h2>
	{link controller="seasonmanager" action="editBonus" id=$segment.id text="Create new bonus"}
	
	<table id="hor-zebra" class="hor-zebra">
		<tr>
			<th>ID</th>
			<th>Question</th>
			<th>Modifier</th>
			<th>Status</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Action</th>
		</tr>
		{foreach from=$segment->bonus item="bonus"}
			<tr>
				<td>{$bonus.id}</td>
				<td>{link controller="seasonmanager" action="editBonus" id=$segment.id bonus_id=$bonus.id text=$bonus.question}</td>
				<td>{$bonus.modifier}</td>
				<td>{$bonus->status.name}</td>
				<td>{$bonus.start_date}</td>
				<td>{$bonus.end_date}</td>
				<td>{link controller="seasonmanager" action="markBonusWinners" id=$segment.id bonus_id=$bonus.id text="Mark Winners"}</td>
			</tr>
		{/foreach}
	</table>
</div>