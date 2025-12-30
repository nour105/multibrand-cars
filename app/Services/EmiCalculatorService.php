<?php

namespace App\Services;

class EmiCalculatorService
{
    public function calculate(
        ?string $salaryRange,
        ?int $hasLoans,
        ?string $loanType,
        ?string $visaLimit
    ): int {
        $salary = $this->salaryValue($salaryRange);
        $pct = $this->emiPct($hasLoans, $loanType);

        $salaryBudget = $salary * $pct;
        $visa = $this->visaValue($visaLimit);
        $visaBonus = $visa * 0.05;

        return (int) round($salaryBudget + $visaBonus);
    }

    private function salaryValue(?string $v): int
    {
        return match ($v) {
            '0-5000' => 5000,
            '5000-10000' => 10000,
            '10000-15000' => 15000,
            '15000+' => 20000,
            default => 0,
        };
    }

    private function visaValue(?string $v): int
    {
        return match ($v) {
            'below_5000' => 5000,
            '5000-10000' => 10000,
            '10000-15000' => 15000,
            '15000+' => 20000,
            default => 0,
        };
    }

    private function emiPct(?int $hasLoans, ?string $loanType): float
    {
        if ($hasLoans !== 1) return 0.45;

        return match ($loanType) {
            'realestate' => 0.65,
            'both' => 0.55,
            default => 0.45,
        };
    }
}
