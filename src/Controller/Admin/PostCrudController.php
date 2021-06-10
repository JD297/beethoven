<?php declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Post;
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

		if($pageName === 'new' || $pageName === 'edit') {
			$fields[] = AssociationField::new('topic');
			$fields[] = AssociationField::new('user');
		}

		return $fields;
	}
}
