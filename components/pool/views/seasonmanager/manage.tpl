<h1>Segments for {$season.name}</h1>

{link action='index' text='Back to season list'}<br />
{link action='editSegment' text='Create new segment' id=$season->id subid=0}<br />

<div class="picksContainer">
	<table class="hor-zebra" id="hor-zebra">
	<tr>
		<th>Name</th>
		<th>Status</th>
		<th>Action</th>
		<th>Delete</th>
	</tr>
	{foreach from=$segments item=segment key=key}
	   <tr class="{cycle values="even, odd"}">
	      <td>{$segment.name}</td>
	      <td>{$segment->status.name}</td>
		  <td>
		  	<a href="/seasonmanager/editSegment/{$season.id}/{$segment.id}">Edit</a><br />
		  	<a href="/seasonmanager/manageSegment/{$season.id}/{$segment.id}">Manage</a><br />
		  </td>
		  <td>
		  	Delete
		  </td>
	   </tr>
	{/foreach}
	</table>
</div>