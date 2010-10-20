<h1>Active Pools</h1>
<p>Click to view details</p>

<div id="accordion" class="accordion">
	{foreach from=$seasons item=season key=key}
		<h3 class="accordion">
			<a class="accordion" href="#">{$season.name}</a>
		</h3>
		<div class="seasonOverview">
			<div class="accordionTitle">Date range</div>
			<div class="accordionContent">
				{$season.start_year} - {$season.end_year}
			</div>
			<div class="accordionTitle">Action</div>
			<div class="accordionContent">
				{if $currentUser->id != "" and $currentUser->id != 0}
			  		{if $season->isMember($currentUser)}
			  			{link component="pool" action="viewSeason" id=$season.id text="Season Overview"}
			  			{link component="pool" action="leaveSeason" id=$season.id text="Leave"}
			  		{else}
			  			{link component="pool" action="joinSeason" id=$season.id text="Join"}
			  		{/if}
			  	{/if}
			</div>
		  	<div class="accordionTitle">Members</div>
		  	<div class="accordionContent">
			  	<ul>
			  		{foreach from=$season->users item="user"}
				  		<li>{$user.first_name} {$user.last_name}</li>
				  	{/foreach}
				</ul>
			</div>
		</div>
	{/foreach}
</div>