<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Default: {$title}</title>
	<link rel="stylesheet" href="/css/style.css" type="text/css">
	<link rel="stylesheet" href="/js/anytime/anytime.css" type="text/css">
	<script type="text/javascript" src="/js/anytime/anytime.js"></script>
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/enterPicks.js"></script>
	<script type="text/javascript" src="/js/manageSegment.js"></script>
	<script type="text/javascript" src="/js/bonus.js"></script>
</head>
<body>
	<div class="menu">
		{run_action controller="menu" action="index" assign="menu"}
	</div>
	<div id="clear" class="clear"></div>
	<div class="content">
		{$content}
	</div>
</body>
</html>