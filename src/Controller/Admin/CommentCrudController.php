<?php declare(strict_types=1);

namespace Beethoven\Controller\Admin;

use Beethoven\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class CommentCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return Comment::class;
	}

	public function configureFields(string $pageName): iterable
	{
		$fields = [
			TextareaField::new('content'),
			BooleanField::new('active'),
		];

		if ('new' === $pageName || 'edit' === $pageName) {
			$fields[] = AssociationField::new('user');
		}

		return $fields;
	}
}
