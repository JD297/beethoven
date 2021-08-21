<?php declare(strict_types=1);

namespace Beethoven\Page\Auth\Register;

use Beethoven\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegisterFormType extends AbstractType
{
	public const USERNAME_MIN = 3;
	public const USERNAME_MAX = 24;
	public const PASSWORD_PLAIN_MIN = 8;
	public const PASSWORD_PLAIN_MAX = 4096;

	private TranslatorInterface $translator;

	public function __construct(TranslatorInterface $translator)
	{
		$this->translator = $translator;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('username', TextType::class, [
				'constraints' => [
					new NotBlank([
						'message' => $this->translator->trans('frontend.page.auth.register.error.username.blank', [], 'messages'),
					]),
					new Length([
						'min' => self::USERNAME_MIN,
						'minMessage' => $this->translator->trans('frontend.page.auth.register.error.username.min', [
							'%limit%' => self::USERNAME_MIN,
						], 'messages'),
						'max' => self::USERNAME_MAX,
						'maxMessage' => $this->translator->trans('frontend.page.auth.register.error.username.max', [
							'%limit%' => self::USERNAME_MAX,
						], 'messages'),
					]),
				],
				'label' => 'frontend.page.auth.register.input.username.label',
				'attr' => [
					'placeholder' => 'frontend.page.auth.register.input.username.placeholder',
				],
			])
			->add('plainPassword', PasswordType::class, [
				'mapped' => false,
				'constraints' => [
					new NotBlank([
						'message' => $this->translator->trans('frontend.page.auth.register.error.plainPassword.blank', [], 'messages'),
					]),
					new Length([
						'min' => self::PASSWORD_PLAIN_MIN,
						'minMessage' => $this->translator->trans('frontend.page.auth.register.error.plainPassword.min', [
							'%limit%' => self::PASSWORD_PLAIN_MIN,
						], 'messages'),
						'max' => self::PASSWORD_PLAIN_MAX,
						'maxMessage' => $this->translator->trans('frontend.page.auth.register.error.plainPassword.max', [
							'%limit%' => self::PASSWORD_PLAIN_MAX,
						], 'messages'),
					]),
				],
				'label' => 'frontend.page.auth.register.input.password.label',
				'attr' => [
					'placeholder' => 'frontend.page.auth.register.input.password.placeholder',
				],
			])
			->add('submit', SubmitType::class, [
				'label' => 'frontend.page.auth.register.input.button.show',
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => User::class,
			'constraints' => [
				new UniqueEntity(
					['username'],
					$this->translator->trans('frontend.page.auth.register.error.username.unique', [], 'messages'),
				),
			],
			'csrf_protection' => false,
		]);
	}
}
