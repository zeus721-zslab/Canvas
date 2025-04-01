<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<div class="dataTables_paginate paging_simple_numbers" aria-label="<?= lang('Pager.pageNavigation') ?>">
	<ul class="pagination gap-2" style="justify-content:center;">
		<?php if ($pager->hasPrevious()) : ?>
			<li class="paginate_button page-item ">
				<a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="first" data-page_seq="first">
					<span aria-hidden="true"><?= lang('Pager.first') ?></span>
				</a>
			</li>
			<li class="paginate_button page-item ">
				<a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="prev" data-page_seq="prev">
					<span aria-hidden="true"><?= lang('Pager.previous') ?></span>
				</a>
			</li>
		<?php endif ?>

		<?php foreach ($pager->links() as $link) : ?>
			<li class="paginate_button page-item <?= $link['active'] ? 'active' : '' ?>">
				<a class="page-link" href="<?= $link['uri'] ?>" data-page_seq="<?= $link['title'] ?>">
					<?= $link['title'] ?>
				</a>
			</li>
		<?php endforeach ?>

		<?php if ($pager->hasNext()) : ?>
			<li class="paginate_button page-item ">
				<a class="page-link" href="<?= $pager->getNext() ?>" aria-label="next" data-page_seq="next">
					<span aria-hidden="true"><?= lang('Pager.next') ?></span>
				</a>
			</li>
			<li class="paginate_button page-item ">
				<a class="page-link" href="<?= $pager->getLast() ?>" aria-label="last"  data-page_seq="last">
					<span aria-hidden="true"><?= lang('Pager.last') ?></span>
				</a>
			</li>
		<?php endif ?>
	</ul>
</div>
