<div class="menu">
	{if $user.id != ""}
		<div class="login">Logged in as: {$user.first_name} {$user.last_name}</div>
	{/if}
</div>

<link href="/css/menus/css/dropdown/themes/default/helper.css" media="screen" rel="stylesheet" type="text/css" />

<link href="/css/menus/css/dropdown/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/css/menus/css/dropdown/themes/default/default.css" media="screen" rel="stylesheet" type="text/css" />

<!--[if lt IE 7]>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
<![endif]-->

<!-- / END -->

<ul id="nav" class="dropdown dropdown-horizontal">
	{if $user.id != ""}
		<li><a href="/pool">Home</a></li>
	{else}
		<li><a href="/">Home</a></li>
	{/if}
	{if $user.id != ""}
		<li class="dir">Subscribed Pools
			<ul>
				<li>{link controller="pool" action="index" text="All Pools"}</li>
				{foreach from=$seasons item="season" key="season_id"}
					<li class="dir">{link controller="pool" action="viewSeason" id=$season_id text=$season.name}
						<ul>
							<li>{link controller="pool" action="viewSeason" id=$season_id text="Sesason Overview"}</li>
							<li class="dir">Segments
								<ul>
									{foreach from=$season->segments item="segment"}
										<li class="dir">{$segment.name}
											<ul>
												<li>{link controller="pool" action="enterPicks" id=$segment.id text="Enter Picks"}</li>
												<li>{link controller="pool" action="viewScores" id=$segment.id text="View Scores"}</li>
											</ul>
										</li>
									{/foreach}
								</ul>
							</li>
						</ul>
					</li>
				{/foreach}
			</ul>
		</li>
		<li class="dir">Unsubscribed Pools
			<ul>
				<li>{link controller="pool" action="index" text="All Pools"}</li>
				{foreach from=$nonMemberSeasons item="season" key="season_id"}
					<li class="dir">{$season.name}
						<ul>
							<li>{link controller="pool" action="joinSeason" id=$season_id text="Join Season"}</li>
						</ul>
					</li>
				{/foreach}
			</ul>
		</li>
		<li>{link controller="default" action="logout" text="Logout"}</li>
		{if $user.id != ""}
			<li>Logged in as: {$user.first_name} {$user.last_name}</li>
		{/if}
	{/if}
</ul>
