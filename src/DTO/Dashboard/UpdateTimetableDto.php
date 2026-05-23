<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class UpdateTimetableDto implements DataTransferObjectInterface
{

    public function __construct(
        public int $id,
        public string $day,
        public string $city,
        public string $advancementGroup,
        public string $place,
        public string $start,
        public string $end,
        public int $isNotify,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            day: (string) $data['day'],
            city: (string) $data['city'],
            advancementGroup: (string) $data['advancement_group'],
            place: (string) $data['place'],
            start: (string) $data['start'],
            end: (string) $data['end'],
            isNotify: (int) $data['is_notify'],
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'day' => $this->day,
            'city' => $this->city,
            'advancement_group' => $this->advancementGroup,
            'place' => $this->place,
            'start' => $this->start,
            'end' => $this->end,
        ];
    }
}