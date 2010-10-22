<script type="text/javascript" src="/js/comments.js"></script>
<div class="rightContent">
	<div class="title">Comments</div>
	<div class="left small"><a href="#" onClick="toggleComments(); return false;">Show/Hide</a></div>
	<div class="commentAdd">
		{textbox name="comment" value="" class="commentBox"}
		{hidden name="season_id" value=$season.id}
		<div class="linkContainer">
			<div class="left"><a href="#" class="commentSubmit">Say it</a></div>
			<div class="right small"><a href="#" onClick="getComments({$season.id}, 0, 10); return false;">Refresh</a></div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="commentContainer">
	</div>
</div>