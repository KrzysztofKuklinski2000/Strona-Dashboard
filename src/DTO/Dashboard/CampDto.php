<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class CampDto implements DataTransferObjectInterface
{
    public function __construct(
        public string $city,
        public string $guesthouse,
        public string $city_start,
        public string $date_start,
        public string $date_end,
        public string $time_start,
        public string $time_end,
        public string $place,
        public string $accommodation,
        public string $meals,
        public string $trips,
        public string $staff,
        public string $transport,
        public string $training,
        public string $insurance,
        public int    $cost,
        public int    $advancePayment,
        public string $advanceDate,
    )
    {

    }

    public static function fromArray(array $data): self
    {
        return new self(
            city: (string)($data['city'] ?? ''),
            guesthouse: (string)($data['guesthouse'] ?? ''),
            city_start: (string)($data['city_start'] ?? ''),
            date_start: (string)($data['date_start'] ?? ''),
            date_end: (string)($data['date_end'] ?? ''),
            time_start: (string)($data['time_start'] ?? ''),
            time_end: (string)($data['time_end'] ?? ''),
            place: (string)($data['place'] ?? ''),
            accommodation: (string)($data['accommodation'] ?? ''),
            meals: (string)($data['meals'] ?? ''),
            trips: (string)($data['trips'] ?? ''),
            staff: (string)($data['staff'] ?? ''),
            transport: (string)($data['transport'] ?? ''),
            training: (string)($data['training'] ?? ''),
            insurance: (string)($data['insurance'] ?? ''),
            cost: (int)($data['cost'] ?? 0),
            advancePayment: (int)($data['advancePayment'] ?? 0),
            advanceDate: (string)($data['advanceDate'] ?? ''),
        );
    }

    public function toArray(): array
    {
        $data = [
            'city' => $this->city,
            'guesthouse' => $this->guesthouse,
            'city_start' => $this->city_start,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'place' => $this->place,
            'accommodation' => $this->accommodation,
            'meals' => $this->meals,
            'trips' => $this->trips,
            'staff' => $this->staff,
            'transport' => $this->transport,
            'training' => $this->training,
            'insurance' => $this->insurance,
            'cost' => $this->cost,
            'advancePayment' => $this->advancePayment,
            'advanceDate' => $this->advanceDate,
        ];

        return $data;
    }
}