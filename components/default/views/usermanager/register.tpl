{* Smarty *}
<h1>Register now</h1>
{if $message ne ""}
	<div class="message">{$message}</div>
{/if}
{if $error ne ""}
	<div class="error">{$error}</div>
{/if}

<div id="content">
	{form action="registerUser" controller="usermanager"}
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
			<label class="block" for="email">Email</label>
		    <input type="text" value="{$user.email}" id="email" class="email" name="email">
		</div>
		<div class="clear"></div>

		<input type="submit" class="buttons" value="Submit" name="Register">
		</div>
	{/form}
</div>
