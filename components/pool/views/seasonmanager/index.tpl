<link rel="stylesheet" href="/css/style.css" type="text/css">
<h1>List Teams</h1>

<a href="/seasonmanager/edit/0">Create new season</a>
<table class="hor-zebra" id="hor-zebra">
<tr>
	<th>Name</th>
	<th>Start - End</th>
	<th>Action</th>
</tr>
{foreach from=$seasons item=season key=key}
{strip}
   <tr class="{cycle values="even, odd"}">
      <td>{$season.name}</td>
      <td>{$season.start_year} - {$season.end_year}</td>
      
	  <td>
	  	<a href="/seasonmanager/edit/{$season.id}">Edit</a><br />
	  	<a href="/seasonmanager/manage/{$season.id}">Manage</a>
	  </td>
   </tr>
{/strip}
{/foreach}
</table>

<!-- Probably a better way to do this -->
