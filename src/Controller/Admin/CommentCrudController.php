<?php declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Comment;
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

		if($pageName === 'new' || $pageName === 'edit') {
			$fields[] = AssociationField::new('user');
		}

		return $fields;
	}
}
