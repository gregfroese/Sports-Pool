{* Smarty *}
<h1>User Manager - Edit/Create User</h1>
<a href="/usermanager">Back to user list</a>
{if $message ne ""}
	<div class="message">{$message}</div>
{/if}
{if $error ne ""}
	<div class="error">{$error}</div>
{/if}

<div id="content">
	{form action="saveUser" controller="usermanager" id=$user.id}
		{hidden name="user_id" value=$user.id}
		<div class="">
	  		<label class="block" for="username">Username</label>
		    <input type="text" value="{$user.username}" id="username" class="username" name="username">
		</div>
		<div class="clear"></div>
		<div class="">
			<label class="block" for="first_name">First name</label>
		    <input type="text" value="{$user.first_name}" id="first_name" class="username" name="first_name">
		</div>
		<div class="clear"></div>
		<div class="">
			<label class="block" for="last_name">Last name</label>
		    <input type="text" value="{$user.last_name}" id="last_name" class="username" name="last_name">
		</div>
		<div class="clear"></div>
	    <div class="">
	    	<label class="block" for="password">Password</label>
	    	<input type="password" value="" id="password" class="password" name="password">
		</div>
		<div class="clear"></div>
		<div class="">
			<label class="block" for="password">Confirm Password</label>
	    	<input type="password" value="" id="password" class="password" name="confirm_password">
		</div>
		<div class="clear"></div>
		<div class="">
			<h2>Member of:</h2>
			<ol>
			{foreach from=$user->groups item="group"}
				<li>{$group.name} - {link controller="usermanager" action="deleteMember" group_id=$group.id user_id=$user.id text="Delete"}</li>
			{/foreach}
			</ol>
			<h2>Add to Group</h2>
			{html_options name="group_id" options=$allGroups}
		</div>
		<div class="clear"></div>
		<div class="">
			<input type="submit" class="buttons" value="Submit" name="Submit">
		</div>
	{/form}
</div>
