<?php

declare(strict_types=1);

namespace App\DTO\Dashboard\Timetable;

use App\DTO\DataTransferObjectInterface;

readonly class UpdateTimetableDto implements DataTransferObjectInterface
{
    public function __construct(
        public int    $id,
        public string $day,
        public string $advancementGroup,
        public string $start,
        public string $end,
        public int    $isNotify,
        public int    $locationId,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int)$data['id'],
            day: (string)$data['day'],
            advancementGroup: (string)$data['advancement_group'],
            start: (string)$data['start'],
            end: (string)$data['end'],
            isNotify: !empty($data['is_notify']) ? 1 : 0,
            locationId: (int)$data['location_id'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'day' => $this->day,
            'advancement_group' => $this->advancementGroup,
            'start' => $this->start,
            'end' => $this->end,
            'location_id' => $this->locationId,
        ];
    }
}
