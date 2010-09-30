{* Smarty *}
{literal}
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/manageSegment.js"></script>
{/literal}
<link rel="stylesheet" href="/css/style.css" type="text/css">
<h1>Manage Segment</h1>
<a href="/seasonmanager/manage/{$season.id}">Back to segment list</a><br />
<a href="/seasonmanager/editGame/{$segment.id}/0">Create new game</a>
<table class="hor-zebra" id="hor-zebra">
<tr>
	<th>Game ID</th>
	<th>Away Team</th>
	<th>Away Score</th>
	<th>Home Team</th>
	<th>Home Score</th>
	<th>Status</th>
	<th>Modifier</th>
	<th>Notes</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th>Action</th>
</tr>
{foreach from=$games item=game key=key}
   <tr class="{cycle values="even, odd"}">
      {render_partial template="game_detail.tpl" game=$game}
   </tr>
{/foreach}
</table>