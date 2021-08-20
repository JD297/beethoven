<?php declare(strict_types=1);

namespace Beethoven\Controller\Admin;

use Beethoven\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return Post::class;
	}

	public function configureFields(string $pageName): iterable
	{
		$fields = [
			TextField::new('name'),
			TextareaField::new('content'),
			BooleanField::new('active'),
		];

		if ('new' === $pageName || 'edit' === $pageName) {
			$fields[] = AssociationField::new('topic');
			$fields[] = AssociationField::new('user');
		}

		return $fields;
	}
}
