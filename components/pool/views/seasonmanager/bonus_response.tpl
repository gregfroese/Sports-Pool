<table id="bonus" class="bonus">
	<tr>
		<td>{$response->user.first_name} {$response->user.last_name}</td>
		<td>{$response.response}</td>
		<td>{$response.value}</td>
		<td>
			<a href="#" onClick="markWinner({$response.id}); return false;">Winner</a>
			<a href="#" onClick="markLoser({$response.id}); return false;">Loser</a>
		</td>
	</tr>
</table>