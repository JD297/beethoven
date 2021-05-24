<?php declare(strict_types=1);

namespace App\Page;

use Doctrine\ORM\LazyCriteriaCollection;

interface PageInterface
{
	/**
	 * @return LazyCriteriaCollection
	 */
	public function getDataCollection(): LazyCriteriaCollection;

	/**
	 * @param LazyCriteriaCollection $dataCollection
	 */
	public function setDataCollection(LazyCriteriaCollection $dataCollection): self;

	/**
	 * @return array
	 */
	public function getData(): array;
}