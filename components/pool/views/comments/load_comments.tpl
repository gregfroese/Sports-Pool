<table class="comments">
	<tbody>
		{$season->getComments() assign="comments"}
		{foreach from=$comments item="comment"}
			<tr>
				<td>
					<div class="comment">{$comment.comment}</div>
					<div class="commentFooter">{$comment->user.first_name} {$comment->user.last_name} - {$comment.create_date}</div>
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>