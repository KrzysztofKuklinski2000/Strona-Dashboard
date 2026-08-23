<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Traits;

trait StandardCrudTrait
{
    use CanCreate;
    use CanEdit;
    use CanDelete;
    use CanPublished;
}
