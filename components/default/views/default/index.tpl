{* Smarty *}
<h1>Homepage</h1>
<link rel="stylesheet" href="/css/style.css" type="text/css">
{if $error ne ""}
	<div class="error">{$error}</div>
{/if}
{if $user.id == 0}
	<div id="leftSide">
		<fieldset>
			<legend>Login details</legend>
			<form class="form" method="POST" action="">
			  <label class="login" for="username">Username</label>
			    <div class="div_texbox">
			    <input type="text" value="" id="username" class="username" name="username">
				</div>
				 <label class="login" for="password">Password</label>
			    <div class="div_texbox">
			    <input type="password" value="" id="password" class="password" name="password">
				</div>
				<div class="button_div">
				<input type="submit" class="buttons" value="Submit" name="Submit">
				<input type="hidden" name="component" value="default">
				<input type="hidden" name="controller" value="default">
				<input type="hidden" name="action" value="login">
				</div>
			</form>
			<div class="clear"></div>
		</fieldset>
	</div>
{else}
	welcome back {$user.first_name}<br />
	<a href="/default/logout">Logout</a>
{/if}
	