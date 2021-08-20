<?php declare(strict_types=1);

namespace Beethoven\Controller\Frontend;

use Beethoven\Entity\Post;
use Beethoven\Entity\Topic;
use Beethoven\Entity\User;
use Beethoven\Page\Post\PostFormType;
use Beethoven\Page\Topic\TopicPageLoader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends AbstractController
{
	private TopicPageLoader $topicPageLoader;

	public function __construct(TopicPageLoader $topicPageLoader)
	{
		$this->topicPageLoader = $topicPageLoader;
	}

	/**
	 * @Route("/topic/{topicId}", name="frontend.topic.index.page", requirements={"topicId"="\d+"}, methods={"GET"})
	 */
	public function index(int $topicId): Response
	{
		$page = $this->topicPageLoader->load($topicId);

		$form = $this->createForm(PostFormType::class);

		return $this->render('page/topic/index.html.twig', [
			'page' => $page->getData(),
			'postForm' => $form->createView(),
		]);
	}

	/**
	 * @Route("/topic/{topicId}", name="frontend.topic.add.post", requirements={"topicId"="\d+"}, methods={"POST"})
	 * @ParamConverter("topic", options={"id" = "topicId"})
	 */
	public function addPost(Topic $topic, Request $request): Response
	{
		/** @var User $user */
		$user = $this->getUser();

		$form = $this->createForm(PostFormType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid() && $user) {
			$post = new Post();
			$post
				->setName($form->get('name')->getData())
				->setContent($form->get('content')->getData())
				->setUser($user)
				->setTopic($topic)
			;

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($post);
			$entityManager->flush();
		} else {
			foreach ($form->getErrors(true) as $error) {
				$this->addFlash(
					'error', $error->getMessage()
				);
			}
		}

		return $this->redirectToRoute('frontend.topic.index.page', [
			'topicId' => $topic->getId(),
		]);
	}
}
