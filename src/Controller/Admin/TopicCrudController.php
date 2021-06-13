<?php declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Topic;
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

    	if($pageName === 'new' || $pageName === 'edit') {
			$fields[] = AssociationField::new('forum');
	    }

	    return $fields;
    }
}
