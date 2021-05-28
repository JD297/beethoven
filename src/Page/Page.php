<?php declare(strict_types=1);

namespace App\Page;

use App\Framework\Struct\ArrayStruct;

abstract class Page
{
	protected ArrayStruct $data;

	public function __construct()
	{
		$this->data = new ArrayStruct([
			'custom' => new ArrayStruct()
		]);
	}

	public function getCustomData(): ArrayStruct
	{
		return $this->data->get('custom');
	}

	public function getData(): array
	{
		return $this->data->getData();
	}
}