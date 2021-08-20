<?php declare(strict_types=1);

namespace Beethoven\Page\Post;

use Beethoven\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostFormType extends AbstractType
{
	public const CONTENT_ROWS = 5;

	/*
	 * TODO
	 * Add user not blank constraint
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', TextType::class, [
				'constraints' => [
					new NotBlank([
						'message' => 'Title could not be empty',
					]),
				],
				'attr' => [
					'placeholder' => 'frontend.page.topic.index.input.name.placeholder',
				],
			])
			->add('content', TextareaType::class, [
				'constraints' => [
					new NotBlank([
						'message' => 'Post could not be empty',
					]),
				],
				'attr' => [
					'placeholder' => 'frontend.page.topic.index.input.content.placeholder',
					'rows' => self::CONTENT_ROWS,
				],
			])
			->add('submit', SubmitType::class, [
				'label' => 'frontend.page.topic.index.input.button.show',
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Post::class,
		]);
	}
}
