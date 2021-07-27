<?php declare(strict_types=1);

namespace Beethoven\Controller\Admin;

use Beethoven\Entity\Forum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ForumCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return Forum::class;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			TextField::new('name'),
			BooleanField::new('active'),
		];
	}
}
