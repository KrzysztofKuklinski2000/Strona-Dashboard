<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class CampDto implements DataTransferObjectInterface
{
    public function __construct(
        public string $city,
        public string $guesthouse,
        public string $cityStart,
        public string $dateStart,
        public string $dateEnd,
        public string $timeStart,
        public string $timeEnd,
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
            cityStart: (string)($data['city_start'] ?? ''),
            dateStart: (string)($data['date_start'] ?? ''),
            dateEnd: (string)($data['date_end'] ?? ''),
            timeStart: (string)($data['time_start'] ?? ''),
            timeEnd: (string)($data['time_end'] ?? ''),
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
            'city_start' => $this->cityStart,
            'date_start' => $this->dateStart,
            'date_end' => $this->dateEnd,
            'time_start' => $this->timeStart,
            'time_end' => $this->timeEnd,
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