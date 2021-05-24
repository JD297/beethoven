<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
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
			return $this->redirectToRoute('frontend.forum.index.page');
		}

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('page/security/login.html.twig', [
			'error' => $error
		]);
    }

	/**
	 * @Route("/register", name="frontend.page.register")
	 */
	public function register(
		Request $request,
		UserPasswordEncoderInterface $passwordEncoder,
		GuardAuthenticatorHandler $guardHandler,
		LoginFormAuthenticator $formAuthenticator
	): Response
	{
		if ($this->getUser()) {
			return $this->redirectToRoute('frontend.forum.index.page');
		}

		$user = new User();

		$form = $this->createForm(RegistrationFormType::class);
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

			// do anything else you need here, like send an email

			// login after registration
			return $guardHandler->authenticateUserAndHandleSuccess(
				$user,
				$request,
				$formAuthenticator,
				'main'
			);
		}

		return $this->render('page/security/register.html.twig', [
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/logout", name="frontend.page.logout")
	 */
	public function logout()
	{
	}
}
