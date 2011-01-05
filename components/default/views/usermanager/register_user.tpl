{* Smarty *}
{if $success == "1"}
	<h1>Registration successful</h1>
	Click <a href="/">here</a> to login
{else}
	<h1>Error registering</h1>
	{if $message ne ""}
		<div class="message">{$message}</div>
	{/if}
	{if $error ne ""}
		<div class="error">{$error}</div>
	{/if}
	Please <a href="/usermanager/register">try again</a>
{/if}

<div id="content">
</div>
