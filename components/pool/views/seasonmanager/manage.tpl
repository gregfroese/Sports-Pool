<link rel="stylesheet" href="/css/style.css" type="text/css">
<h1>Segments for {$season.name}</h1>

<a href="/seasonmanager/">Back to season list</a><br />
<a href="/seasonmanager/editSegment/{$season.id}/0">Create new segment</a><br />
<table class="hor-zebra" id="hor-zebra">
<tr>
	<th>Name</th>
	<th>Status</th>
	<th>Action</th>
</tr>
{foreach from=$segments item=segment key=key}
   <tr class="{cycle values="even, odd"}">
      <td>{$segment.name}</td>
      <td>
      	{foreach from=$statuses key=key item=status}
      		{if $status.id == $segment.status_id}
      			{$status.name}
      		{/if}
      	{/foreach}
      </td>
      
	  <td>
	  	<a href="/seasonmanager/editSegment/{$season.id}/{$segment.id}">Edit</a><br />
	  	<a href="/seasonmanager/manage/{$season.id}">Manage</a>
	  </td>
   </tr>
{/foreach}
</table>