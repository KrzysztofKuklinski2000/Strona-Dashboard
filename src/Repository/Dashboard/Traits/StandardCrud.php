<?php

declare(strict_types=1);

namespace App\Repository\Dashboard\Traits;

trait StandardCrud
{
    use CanCreate;
    use CanEdit;
    use CanDelete;
}
