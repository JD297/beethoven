<?php declare(strict_types=1);

namespace Beethoven\Controller\Frontend;

use Beethoven\Entity\User;
use Beethoven\Page\Auth\Login\LoginFormAuthenticator;
use Beethoven\Page\Auth\Register\RegisterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class AuthController extends AbstractController
{
	/**
	 * @Route("/login", name="frontend.auth.login.page")
	 */
	public function login(AuthenticationUtils $authenticationUtils): Response
	{
		if ($this->getUser()) {
			return $this->redirectToRoute('frontend.home.index.page');
		}

		$error = $authenticationUtils->getLastAuthenticationError();

		return $this->render('page/auth/login.html.twig', [
			'error' => $error,
		]);
	}

	/**
	 * @Route("/register", name="frontend.auth.register.page")
	 */
	public function register(
		Request $request,
		UserPasswordHasherInterface $passwordEncoder,
		UserAuthenticatorInterface $authenticator,
		LoginFormAuthenticator $formAuthenticator
	): Response {
		if ($this->getUser()) {
			return $this->redirectToRoute('frontend.home.index.page');
		}

		$form = $this->createForm(RegisterFormType::class);
		$form->handleRequest($request);

		$csrfToken = $request->request->get('_csrf_token');

		if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('register', $csrfToken)) {
			/** @var User $user */
			$user = $form->getData();
			$user->setPassword(
				$passwordEncoder->hashPassword(
					$user,
					$form->get('plainPassword')->getData()
				)
			);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($user);
			$entityManager->flush();

			return $authenticator->authenticateUser(
				$user,
				$formAuthenticator,
				$request
			);
		} else {
			foreach ($form->getErrors(true) as $error) {
				$this->addFlash(
					'error', $error->getMessage()
				);
			}
		}

		return $this->render('page/auth/register.html.twig', [
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/logout", name="frontend.auth.logout.page")
	 */
	public function logout()
	{
	}
}
