<?php

namespace App\DTO;

class DistanceSegmentPriceDTO
{
    public function __construct(
        public readonly int $price,
        public readonly int $from,
        public readonly ?int $to = null,
    ) {}
}