<?php declare(strict_types=1);

namespace App\Page;

use App\Framework\Struct\Struct;
use Doctrine\ORM\LazyCriteriaCollection;

class Page extends Struct implements PageInterface
{
	protected LazyCriteriaCollection $dataCollection;

	/**
	 * @return LazyCriteriaCollection
	 */
	public function getDataCollection(): LazyCriteriaCollection
	{
		return $this->dataCollection;
	}

	/**
	 * @param LazyCriteriaCollection $dataCollection
	 */
	public function setDataCollection(LazyCriteriaCollection $dataCollection): self
	{
		$this->dataCollection = $dataCollection;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getData(): array
	{
		return $this->dataCollection->toArray();
	}
}