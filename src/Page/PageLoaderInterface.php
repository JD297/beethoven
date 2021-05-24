<?php declare(strict_types=1);

namespace App\Page;

use Symfony\Component\HttpFoundation\Request;

interface PageLoaderInterface
{
	public function load(Request $request): PageInterface;
}