<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\ContactDto;
use App\DTO\DataTransferObjectInterface;
use App\Repository\Dashboard\Traits\CanEdit;

class ContactRepository extends BaseDashboardRepository
{
    use CanEdit;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return ContactDto::fromArray($data);
    }
}