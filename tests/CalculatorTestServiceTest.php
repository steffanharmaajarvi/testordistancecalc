<?php

namespace Test;

use App\DTO\DistanceSegmentPriceDTO;
use App\Service\CalculatorService;
use PHPUnit\Framework\TestCase;

class CalculatorTestServiceTest extends TestCase
{

    public function testCanCalculatePriceForValidSegments(): void
    {
        $segments = [
            new DistanceSegmentPriceDTO(
                100,
                1,
                100,
            ),
            new DistanceSegmentPriceDTO(
                80,
                100,
                300,
            ),
            new DistanceSegmentPriceDTO(
                70,
                300
            ),
        ];

        $calculatorService = new CalculatorService();
        $totalPrice = $calculatorService->calculatePriceForDistance(305, ...$segments);

        $this->assertSame(26350, $totalPrice);
    }

    public function testCannorCalculatePriceForInvalidSegments(): void
    {
        $segments = [
            new DistanceSegmentPriceDTO(
                100,
                1,
                100,
            ),
            new DistanceSegmentPriceDTO(
                80,
                200,
                300,
            ),
            new DistanceSegmentPriceDTO(
                70,
                500
            ),
        ];

        $this->expectExceptionMessage('Invalid segments for distance');

        $calculatorService = new CalculatorService();
        $calculatorService->calculatePriceForDistance(305, ...$segments);
    }

}