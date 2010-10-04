{if $user.administrator == true}
	<li class="dir">{link controller="seasonmanager" action="index" text="Admin Tools"}
		<ul>
			<li class="dir">Seasons
				<ul>
					{foreach from=$seasons item="season" key="season_id"}
						<li class="dir">{link controller="seasonmanager" action="manage" id=$season_id text=$season.name}
							<ul>
								<li class="dir">Segments
									<ul>
										{foreach from=$season->segments item="segment"}
											<li class="dir">{$segment.name}
												<ul>
													<li>{link controller="seasonmanager" action="manageSegment" id=$segment.season_id subid=$segment.id text="Manage"}</li>
													<li>{link controller="seasonmanager" action="editSegment" id=$segment.season_id subid=$segment.id text="Edit"}</li>
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
			<li>{link controller="default" action="index" text="ACL"}</li>
			<li>{link controller="usermanager" action="index" text="User Manager"}</li>
		</ul>
	</li>
{/if}
