<?php declare(strict_types=1);

namespace Beethoven\Test\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthControllerTest extends WebTestCase
{
	public function testLoginGetResponseOK(): void
	{
		$client = static::createClient();

		$client->request(Request::METHOD_GET, '/login');

		$this->assertResponseStatusCodeSame(Response::HTTP_OK);
	}

	public function testRegisterGetResponseOK(): void
	{
		$client = static::createClient();

		$client->request(Request::METHOD_GET, '/register');

		$this->assertResponseStatusCodeSame(Response::HTTP_OK);
	}
}
