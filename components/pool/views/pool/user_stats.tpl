<script type="text/javascript" src="/js/userStats.js"></script>
<script language="javascript" type="text/javascript" src="/js/visualize.jQuery.js"></script>
<script language="javascript" type="text/javascript" src="/js/excanvas.js"></script>
<link rel="stylesheet" href="/css/visualize.css" type="text/css">
<link rel="stylesheet" href="/css/visualize-dark.css" type="text/css">

{$season->getPerformanceByUser($user) assign="chartPoints"}
<table class="chartLine">
	<caption>{$fullname} by segment</caption>
	<thead>
		<tr>
			<td></td>
			{foreach from=$chartPoints["high"] key="name" item="chartPoint"}
				{if $name ne $fullname}
					<th scope="col">{$name}</th>
				{/if}
			{/foreach}
		</tr>
	</thead>
	<tbody>
			<tr>
				<th scope="row">{$fullname}</th>
				{foreach from=$chartPoints["user"] key="name" item="points"}
					<td>{$points}</td>
				{/foreach}
			</tr>
			<tr>
				<th scope="row">High</th>
				{foreach from=$chartPoints["high"] key="name" item="points"}
					<td>{$points}</td>
				{/foreach}
			</tr>
			<tr>
				<th scope="row">Low</th>
				{foreach from=$chartPoints["low"] key="name" item="points"}
					<td>{$points}</td>
				{/foreach}
			</tr>
	</tbody>
</table>

<table class="chartLine">
	<caption>{$fullname} cumulative</caption>
	<thead>
		<tr>
			<td></td>
			{foreach from=$chartPoints["high"] key="name" item="chartPoint"}
				{if $name ne $fullname}
					<th scope="col">{$name}</th>
				{/if}
			{/foreach}
		</tr>
	</thead>
	<tbody>
			<tr>
				<th scope="row">{$fullname}</th>
				{assign var="total" value=0}
				{foreach from=$chartPoints["user"] key="name" item="points"}
					{math equation=$total+$points assign="total"}
					<td>{$total}</td>
				{/foreach}
			</tr>
			<tr>
				<th scope="row">High</th>
				{assign var="total" value=0}
				{foreach from=$chartPoints["high"] key="name" item="points"}
					{math equation=$total+$points assign="total"}
					<td>{$total}</td>
				{/foreach}
			</tr>
			<tr>
				<th scope="row">Low</th>
				{assign var="total" value=0}
				{foreach from=$chartPoints["low"] key="name" item="points"}
					{math equation=$total+$points assign="total"}
					<td>{$total}</td>
				{/foreach}
			</tr>
	</tbody>
</table>