<?php declare(strict_types=1);

namespace Beethoven\Controller\Frontend;

use Beethoven\Entity\User;
use Beethoven\Page\Auth\Login\LoginFormAuthenticator;
use Beethoven\Page\Auth\Register\RegisterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
		UserPasswordEncoderInterface $passwordEncoder,
		GuardAuthenticatorHandler $guardHandler,
		LoginFormAuthenticator $formAuthenticator
	): Response {
		if ($this->getUser()) {
			return $this->redirectToRoute('frontend.home.index.page');
		}

		$user = new User();

		$form = $this->createForm(RegisterFormType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$user->setUsername(
				$form->get('username')->getData()
			);

			$user->setPassword(
				$passwordEncoder->encodePassword(
					$user,
					$form->get('plainPassword')->getData()
				)
			);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($user);
			$entityManager->flush();

			// login after registration
			return $guardHandler->authenticateUserAndHandleSuccess(
				$user,
				$request,
				$formAuthenticator,
				'main'
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
