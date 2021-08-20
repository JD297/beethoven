<?php declare(strict_types=1);

namespace Beethoven\Page\Post;

use Beethoven\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class CommentFormType extends AbstractType
{
	private TranslatorInterface $translator;

	public function __construct(TranslatorInterface $translator)
	{
		$this->translator = $translator;
	}

	/*
	 * TODO
	 * Add user not blank constraint
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('content', TextareaType::class, [
				'constraints' => [
					new NotBlank([
						'message' => $this->translator->trans('frontend.page.post.add-comment.error.content', [], 'messages'),
					]),
				],
				'attr' => [
					'placeholder' => 'frontend.page.post.index.input.comment.placeholder',
				],
			])
			->add('submit', SubmitType::class, [
				'label' => 'frontend.page.post.index.input.button.show',
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Comment::class,
		]);
	}
}
