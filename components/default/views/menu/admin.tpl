{if $user.administrator == true}
	<li class="dir">{link controller="seasonmanager" action="index" text="Admin Tools"}
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
{/if}
