<script type="text/javascript" src="/js/comments.js"></script>
<div class="rightContent">
	<h3>Comments</h3>
	<div class="commentAdd">
		{textbox name="comment" value="" class="commentBox"}
		{hidden name="season_id" value=$season.id}
		<div class="linkContainer">
			<div class="left"><a href="#" class="commentSubmit">Say it</a></div>
			<div class="right"><a href="#" onClick="toggleComments(); return false;">Show/Hide</a></div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="commentContainer">
	</div>
</div>