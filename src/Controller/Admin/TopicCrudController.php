<?php declare(strict_types=1);

namespace Beethoven\Controller\Admin;

use Beethoven\Entity\Topic;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TopicCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return Topic::class;
	}

	public function configureFields(string $pageName): iterable
	{
		$fields = [
			TextField::new('name'),
			TextField::new('description'),
			BooleanField::new('active'),
		];

		if ('new' === $pageName || 'edit' === $pageName) {
			$fields[] = AssociationField::new('forum');
		}

		return $fields;
	}
}
