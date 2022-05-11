<?php

namespace App\Service\Interface;

interface IBookingService
{
    /**
     * @param array $data
     */
    public function addBooking(array $data): int;

    /**
     * @param int $bookingId
     */
    public function cancelBooking(int $bookingId): int;

    public function fetchAllBooking(): array;

    public function fetchByUserHash(string $user_hash): array;
}
