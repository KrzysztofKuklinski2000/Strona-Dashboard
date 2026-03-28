<?php 

namespace App\Service\Dashboard\Traits;

trait StandardCrudTrait {
    use CanCreate;
    use CanEdit;
    use CanDelete;
    use CanPublished;
}

