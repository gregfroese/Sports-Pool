{* Smarty *}
<h1>User Manager - Edit/Create User</h1>
<a href="/usermanager">Back to user list</a>
<link rel="stylesheet" href="/css/style.css" type="text/css">

<div class="message">{$message}</div>
<div class="error">{$error}</div>

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
		<input type="submit" class="buttons" value="Submit" name="Submit">
		</div>
	</form>
</div>