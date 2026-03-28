<?php 

namespace App\Service\Dashboard\Traits;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;

trait StandardCrudTrait {
    use CanCreate;
    use CanEdit;
    use CanDelete;
    use CanPublished;
}

