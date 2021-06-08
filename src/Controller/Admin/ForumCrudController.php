<?php declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Forum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ForumCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return Forum::class;
	}

	/*
	public function configureFields(string $pageName): iterable
	{
		return [
			TextField::new('title'),
			TextEditorField::new('description'),
		];
	}
	*/
}
