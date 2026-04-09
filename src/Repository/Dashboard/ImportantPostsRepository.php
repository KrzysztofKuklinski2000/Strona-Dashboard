<?php

namespace App\Repository\Dashboard;


use App\Repository\Dashboard\Traits\CanPublished;
use App\Repository\Dashboard\Traits\Positionable;
use App\Repository\Dashboard\Traits\StandardCrud;

class ImportantPostsRepository extends BaseDashboardRepository
{
    use Positionable, StandardCrud, CanPublished;
}