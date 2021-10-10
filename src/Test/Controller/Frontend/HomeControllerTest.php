<?php declare(strict_types=1);

namespace Beethoven\Test\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
	public function testHomeResponseOK(): void
	{
		$client = static::createClient();

		$client->request(Request::METHOD_GET, '/');

		$this->assertResponseStatusCodeSame(Response::HTTP_OK);
	}
}
