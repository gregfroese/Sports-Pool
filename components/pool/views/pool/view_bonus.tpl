<p></p>
<h2>Bonus</h2>
<div class="scores" id="scores">
	<table class="hor-zebra" id="hor-zebra">
		<thead>
			<tr>
				<th></th>
				{foreach from=$segment->bonus item="bonus"}
					<th>{$bonus->question}</th>
				{/foreach}
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$segment->season->users item="user"}
				{assign var="total" value=0}
				<tr class="{cycle values="even, odd"}">
					<td>{$user.first_name} {$user.last_name}</td>
					{foreach from=$segment->bonus item="bonus"}
						<td>
							{$bonus->getResponse($user) assign="response"}
							{$response->response}
							{assign var="total" value=$total+$response.value}
						</td>
					{/foreach}
					<td>{$total}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
</div>
		