{* Smarty *}
<h1>User Manager - Edit/Create User</h1>
<a href="/usermanager">Back to user list</a>
<link rel="stylesheet" href="/css/style.css" type="text/css">
{if $message ne ""}
	<div class="message">{$message}</div>
{/if}
{if $error ne ""}
	<div class="error">{$error}</div>
{/if}

<div id="content">
	<form class="form" method="POST" action="">
	  	<label for="username">Username</label>
	    <div class="">
	    <input type="text" value="{$user.username}" id="username" class="username" name="username">
		</div>
		<label for="first_name">First name</label>
		<div class="">
	    <input type="text" value="{$user.first_name}" id="first_name" class="username" name="first_name">
		</div>
		<label for="last_name">Last name</label>
		<div class="">
	    <input type="text" value="{$user.last_name}" id="last_name" class="username" name="last_name">
		</div>
		 <label for="password">Password</label>
	    <div class="">
	    	<input type="password" value="" id="password" class="password" name="password">
		</div>
		<label for="password">Confirm Password</label>
	    <div class="">
	    	<input type="password" value="" id="password" class="password" name="confirm_password">
		</div>
		<div class="">
			<select id="usertype_id" name="usertype_id">
				<option value="0">Select a usertype</option>
				{foreach from=$usertypes key=key item=usertype}
					<option {if $user.usertype_id == $usertype.id}selected{/if} value="{$usertype.id}">{$usertype.name}</option>
				{/foreach}
			</select>
		</div>
		<div class="">
		<input type="submit" class="buttons" value="Submit" name="Submit">
		</div>
	</form>
</div>