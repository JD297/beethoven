<?php declare(strict_types=1);

namespace Beethoven\Controller\Frontend;

use Beethoven\Entity\Comment;
use Beethoven\Entity\Post;
use Beethoven\Entity\User;
use Beethoven\Page\Post\CommentFormType;
use Beethoven\Page\Post\PostPageLoader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
	private PostPageLoader $postPageLoader;

	public function __construct(PostPageLoader $postPageLoader)
	{
		$this->postPageLoader = $postPageLoader;
	}

	/**
	 * @Route("/post/{postId}", name="frontend.post.index.page", requirements={"postId"="\d+"}, methods={"GET"})
	 */
	public function index(int $postId): Response
	{
		$page = $this->postPageLoader->load($postId);

		$form = $this->createForm(CommentFormType::class);

		return $this->render('page/post/index.html.twig', [
			'page' => $page->getData(),
			'commentForm' => $form->createView(),
		]);
	}

	/**
	 * @Route("/post/{postId}", name="frontend.post.add.comment", requirements={"postId"="\d+"}, methods={"POST"})
	 * @ParamConverter("post", options={"id" = "postId"})
	 */
	public function addComment(Post $post, Request $request): Response
	{
		$form = $this->createForm(CommentFormType::class);
		$form->handleRequest($request);

		/** @var User $user */
		$user = $this->getUser();

		if ($form->isSubmitted() && $form->isValid() && $user) {
			$comment = new Comment();
			$comment
				->setContent($form->get('content')->getData())
				->setUser($user)
				->setPost($post)
			;

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($comment);
			$entityManager->flush();
		} else {
			foreach ($form->getErrors(true) as $error) {
				$this->addFlash(
					'error', $error->getMessage()
				);
			}
		}

		return $this->redirectToRoute('frontend.post.index.page', [
			'postId' => $post->getId(),
		]);
	}
}
