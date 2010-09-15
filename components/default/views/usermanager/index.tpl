{* Smarty *}
<h1>User Manager</h1>
<link rel="stylesheet" href="/css/style.css" type="text/css">
<div id="content">
	<a href="/usermanager/edit/0">Create new user</a>
	<table class="hor-zebra" id="hor-zebra">
		<thead>
			<tr>
				<td>id</td>
				<td>Name</td>
				<td>Action</td>
			</tr>
		</thead>
		<tbody>
			{foreach from=$users key=key item=user}
				<tr class="{cycle values="even,odd"}">
					<td>{$user.id}</td>
					<td>{$user.first_name} {$user.last_name}</td>
					<td><a href="/usermanager/edit/{$user.id}">Edit</a></td>
				</tr>
			{/foreach}
		</tbody>
	</table>
</div>
	