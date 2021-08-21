<?php declare(strict_types=1);

namespace Beethoven\Page\Auth\Login;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
	use TargetPathTrait;

	public const LOGIN_ROUTE = 'frontend.auth.login.page';

	private EntityManagerInterface $entityManager;
	private UrlGeneratorInterface $urlGenerator;
	private CsrfTokenManagerInterface $csrfTokenManager;
	private UserPasswordHasherInterface $passwordEncoder;
	private TokenStorageInterface $tokenStorage;

	public function __construct(
		EntityManagerInterface $entityManager,
		UrlGeneratorInterface $urlGenerator,
		CsrfTokenManagerInterface $csrfTokenManager,
		UserPasswordHasherInterface $passwordEncoder,
		TokenStorageInterface $tokenStorage
	) {
		$this->entityManager = $entityManager;
		$this->urlGenerator = $urlGenerator;
		$this->csrfTokenManager = $csrfTokenManager;
		$this->passwordEncoder = $passwordEncoder;
		$this->tokenStorage = $tokenStorage;
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): RedirectResponse
	{
		if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
			return new RedirectResponse($targetPath);
		}

		return new RedirectResponse($this->urlGenerator->generate('frontend.home.index.page'));
	}

	protected function getLoginUrl(Request $request): string
	{
		return $this->urlGenerator->generate(self::LOGIN_ROUTE);
	}

	public function authenticate(Request $request): PassportInterface
	{
		$password = $request->request->get('password');
		$username = $request->request->get('username');
		$csrfToken = $request->request->get('_csrf_token');

		// validate no parameter is empty
		if (!$password || !$username) {
			throw new CustomUserMessageAuthenticationException();
		} elseif (!$csrfToken) {
			throw new InvalidCsrfTokenException();
		}

		return new Passport(
			new UserBadge($username),
			new PasswordCredentials($password),
			[new CsrfTokenBadge('authenticate', $csrfToken)]
		);
	}
}
