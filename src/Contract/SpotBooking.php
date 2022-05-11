<?php

namespace App\Contract;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

trait SpotBooking
{

    protected function bookingRule($requestedSpot)
    {
        $totalSpot = constant('App\\Constant\\Booking::TOTAL_SPOT');

        $bookedSpot = ($this->bookingRepository->findTotalSpot())['reserveSpot'];

        $remainingSpot = $totalSpot - $bookedSpot;
        if ($remainingSpot == 0) {
            $this->throwError('nospot');
        }
        if (($requestedSpot + $bookedSpot) > $totalSpot) {
            $this->throwError('overbooking');
        }
    }

    private function throwError($type = null)
    {
        throw new BadRequestException($this->errorMessage($type));
    }

    private function errorMessage($type = null)
    {
        $type = strtolower($type);
        switch ($type) {
            case 'nospot':
                return 'Sorry, All spot are sold out. Best of luck next time.';
            case 'overbooking':
                return 'Sorry, There is not enough spots as per your request.';
            default:
                return true;
        }
    }
}
