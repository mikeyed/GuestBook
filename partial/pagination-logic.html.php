<ul>
	<?php if ($page_total > 4) : //max pages before using truncated pagination ?>
		<?php if ($current_page != 1 AND $current_page != $page_total ) : //not on first or last page ?>
			
				<li><a href="./?pg=1">1</a></li>
				<li><a href="./?pg=<?php echo $prev; ?>"><</a></li>
				<li><span><?php echo $current_page; ?></span></li>
				<li><a href="./?pg=<?php echo $next; ?>">></a></li>
				<li><a href="./?pg=<?php echo $page_total; ?>"><?php echo $page_total; ?></a></li>
				
		<?php else : //last/first page?>
			<?php if ($current_page != 1 ) : //not on first or last page ?>
					<li><a href="./?pg=1">1</a></li>
					<li><a href="./?pg=<?php echo $prev -= 1; ?>"><<</a></li>
					<li><a href="./?pg=<?php echo $prev; ?>"><</a></li>
					<li><span><?php echo $page_total; ?></span></li>
			<?php else : ?>				
					<li><span>1</span></li>
					<li><a href="./?pg=<?php echo $next; ?>">></a></li>
					<li><a href="./?pg=<?php echo $next += 1; ?>">>></a></li>
					<li><a href="./?pg=<?php echo $page_total; ?>"><?php echo $page_total; ?></a></li>
			<?php endif; ?>
		<?php endif; ?>
	<?php else :?>
		<?php $i = 0; //loop for full pagination
			while ($i < $page_total) :?>
				<?php $i += 1; ?>
				<?php if ( $i == $current_page): ?>
					<li><span><?php echo $i; ?></span></li>
				<?php else : ?>
					<li><a href="./?pg=<?php echo $i; ?>"><?php echo $i; ?></a></li>
				<?php endif; ?>
			<?php endwhile; ?>
	<?php endif; ?>
</ul>
