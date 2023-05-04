<?php

namespace App\Service;

use App\DTO\DistanceSegmentPriceDTO;

class CalculatorService
{

    /**
     * @param int $distance
     * @param DistanceSegmentPriceDTO ...$segmentPrices
     * @return int
     * @throws \Exception
     */
    public function calculatePriceForDistance(
        int $distance,
        DistanceSegmentPriceDTO ...$segmentPrices,
    ): int
    {
        $totalPrice = 0;
        for ($i = 1; $i <= $distance; $i++) {

            $segmentPriceDTO = $this->findSegmentForDistance($i, $segmentPrices);

            $totalPrice += $segmentPriceDTO->price;
        }

        return $totalPrice;
    }

    /**
     * @param int $distance
     * @param array $segmentPrices
     * @return DistanceSegmentPriceDTO
     * @throws \Exception
     */
    private function findSegmentForDistance(
        int $distance,
        array $segmentPrices,
    ): DistanceSegmentPriceDTO
    {
        $filtered = array_filter(
            $segmentPrices,
            static fn (DistanceSegmentPriceDTO $distanceSegmentPriceDTO) =>
                $distance === 1 && $distance >= $distanceSegmentPriceDTO->from && $distance <= $distanceSegmentPriceDTO->to
                || $distance > $distanceSegmentPriceDTO->from && $distance <= $distanceSegmentPriceDTO->to
                || $distance > $distanceSegmentPriceDTO->from && $distanceSegmentPriceDTO->to === null
        );

        return array_shift($filtered) ?? throw new \Exception('Invalid segments for distance');
    }

}