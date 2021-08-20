<?php declare(strict_types=1);

namespace Beethoven\Service\Pagination;

use Beethoven\Page\Page;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

interface PaginationServiceInterface
{
	public function paginate(Page $page, Collection $collection): ArrayCollection;
}
