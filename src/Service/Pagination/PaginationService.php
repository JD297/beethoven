<?php declare(strict_types=1);

namespace Beethoven\Service\Pagination;

use Beethoven\Framework\Struct\ArrayStruct;
use Beethoven\Page\Page;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaginationService implements PaginationServiceInterface
{
	public const PAGINATION_LENGTH = 8;
	public const PAGINATION_DISTANCE = 4;

	private ?Request $request;

	public function __construct(RequestStack $requestStack)
	{
		$this->request = $requestStack->getCurrentRequest();
	}

	public function paginate(Page $page, Collection $collection): ArrayCollection
	{
		$this->setPaginationData($page, $this->getMaxOffset($collection->count()));

		$arrayCollection = new ArrayCollection(
			$collection->slice($this->getOffset(), self::PAGINATION_LENGTH)
		);

		if(!$arrayCollection->count() && $this->getOffset() != 0) {
			throw new NotFoundHttpException();
		}

		return $arrayCollection;
	}


	private function setPaginationData(Page $page, int $maxOffset): void
	{
		$current = $this->getOffset() / self::PAGINATION_LENGTH + 1;

		$start = $current - self::PAGINATION_DISTANCE;
		if($start < 1) {
			$start = 1;
		}

		$end = $current + self::PAGINATION_DISTANCE;
		if($end > $maxOffset) {
			$end = $maxOffset;
		}

		$data = new ArrayStruct();
		$data->set('current', $current);
		$data->set('start', $start);
		$data->set('end', $end);

		$page->getCustomData()->set('pagination', $data);
	}

	private function getOffset(): int
	{
		$offset = $this->request->query->getInt('page');

		$offset = intval(($offset - 1) * self::PAGINATION_LENGTH);

		// first page is fallback
		if($offset < 0) {
			$offset = 0;
		}

		return $offset;
	}

	private function getMaxOffset(int $count): int
	{
		return intval(ceil($count / self::PAGINATION_LENGTH));
	}
}