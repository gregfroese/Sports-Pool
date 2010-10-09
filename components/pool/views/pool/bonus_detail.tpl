{assign var="response" value=$bonus->getResponse()}
{if $response.response == ""}
	{if $date >= $bonus.start_date AND $date <= $bonus.end_date} 
		{textbox name="response_{$bonus.id}" value=""}
		<a href="#" onClick="saveBonus({$user.id}, {$bonus.id}); return false;">Save</a>
	{/if}
{else}
	{$response.response}
{/if}