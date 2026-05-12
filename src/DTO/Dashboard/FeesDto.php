<?php
declare(strict_types=1);

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class FeesDto implements DataTransferObjectInterface
{
    public function __construct(
        public int    $reducedContribution1Month,
        public int    $reducedContribution2Month,
        public int    $familyContributionMonth,
        public int    $reducedContribution1Year,
        public int    $reducedContribution2Year,
        public int    $familyContributionYear,
        public string $extraInformation,
        public string $feesInformation,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            reducedContribution1Month: (int)($data['reduced_contribution_1_month'] ?? 0),
            reducedContribution2Month: (int)($data['reduced_contribution_2_month'] ?? 0),
            familyContributionMonth: (int)($data['family_contribution_month'] ?? 0),
            reducedContribution1Year: (int)($data['reduced_contribution_1_year'] ?? 0),
            reducedContribution2Year: (int)($data['reduced_contribution_2_year'] ?? 0),
            familyContributionYear: (int)($data['family_contribution_year'] ?? 0),
            extraInformation: (string)($data['extra_information'] ?? ''),
            feesInformation: (string)($data['fees_information'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'reduced_contribution_1_month' => $this->reducedContribution1Month,
            'reduced_contribution_2_month' => $this->reducedContribution2Month,
            'family_contribution_month' => $this->familyContributionMonth,
            'reduced_contribution_1_year' => $this->reducedContribution1Year,
            'reduced_contribution_2_year' => $this->reducedContribution2Year,
            'family_contribution_year' => $this->familyContributionYear,
            'extra_information' => $this->extraInformation,
            'fees_information' => $this->feesInformation,
        ];
    }
}