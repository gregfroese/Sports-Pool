<table class="comments">
	<tbody>
		{$season->getComments($page, $limit) assign="comments"}
		{foreach from=$comments.comments item="comment"}
			<tr>
				<td>
					<div class="comment">{$comment.comment}</div>
					<div class="commentFooter">{$comment->user.first_name} {$comment->user.last_name} - {$comment.create_date}</div>
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>
{assign var="count" value=$comments.count}
{math equation="floor( $count / $limit ) + 1" assign="lastPage"}
{math equation="$page + 1" assign="currentPage"}
<div class="small center">Page {$currentPage} of {$lastPage}</div>
<div class="left small">
	<a href="#" onclick="getComments({$season.id}, 0, {$limit}); return false;">First</a>
	{if $page != 0}
		{assign var="prevPage" value=$page-1}
		 - <a href="#" onclick="getComments({$season.id}, {$prevPage}, {$limit}); return false;">Prev</a>
	{/if}
</div>

<div class="right small">
	{if $currentPage lt $lastPage}
		{assign var="nextPage" value=$page+1}
		<a href="#" onclick="getComments({$season.id}, {$nextPage}, {$limit}); return false;">Next</a> -- 
	{/if}
	{math equation="$lastPage - 1" assign="lastPage"}
	<a href="#" onclick="getComments({$season.id}, {$lastPage}, {$limit}); return false;">Last</a>
</div>