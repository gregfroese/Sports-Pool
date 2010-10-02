{* Smarty *}
<link rel="stylesheet" href="/css/style.css" type="text/css">
<h1>Active Pools</h1>
<table class="hor-zebra" id="hor-zebra">
	<tr>
		<th>Name: {$user->username}</th>
		<th>Start - End</th>
		<th>Members</th>
	</tr>
	{foreach from=$seasons item=season key=key}
	{strip}
	   <tr class="{cycle values="even, odd"}">
	      <td>
	      	{if $season->isMember($user)}
	      		{link component="pool" action="viewSeason" id=$season.id text=$season.name}
	      	{else}
	      		{$season.name}
	      	{/if}
	      </td>
	      <td>{$season.start_year} - {$season.end_year}</td>
		  <td>
		  	{foreach from=$season->users item="user"}
		  		{$user.first_name} {$user.last_name}<br />
		  	{/foreach}
		  </td>
		  <td>
		  	{if $user->id != "" and $user->id != 0}
		  		{if $season->isMember($user)}
		  			{link component="pool" action="leaveSeason" id=$season.id text="Leave"}
		  		{else}
		  			{link component="pool" action="joinSeason" id=$season.id text="Join"}
		  		{/if}
		  	{/if}
		  </td>
	   </tr>
	{/strip}
	{/foreach}
</table>