<h2>Mark Bonus Winners</h2>
<table id="hor-zebra" class="hor-zebra">
	<tr>
		<td>
			<table id="hor-zebra" class="hor-zebra">
				<tr>
					<th>Name</th>
					<th>Answer</th>
					<th>Action</th>
				</tr>
			</table>
		</td>
	</tr>
	{foreach from=$bonus->responses item="response"}
		<tr>
			<td><div class="user_{$response.id}">{render_partial template="bonus_response.tpl" response=$response}</div></td>
		</tr>
	{/foreach}
</table>