<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use App\Service\Interface\IBookingService;
use App\Entity\Booking as BookingEntity;
use App\Repository\BookingRepository;
use App\Contract\SpotBooking;

class BookingService implements IBookingService
{
    use SpotBooking;
    private $bookingRepository;
    private $currentTime;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->currentTime = date('d-m-Y');
    }

    /**
     * @param array $data
     */
    public function addBooking(array $data): int
    {
        $this->bookingRule($data['reserve_spot']);
        $booking = new BookingEntity();
        $booking->setUserHash($data['user_hash']);
        $booking->setReserveSpot($data['reserve_spot']);
        $booking->setStatus(1);
        $booking->setCreatedAt($this->currentTime);
        $booking->setUpdatedAt($this->currentTime);
        $this->bookingRepository->add($booking, true);
        return Response::HTTP_CREATED;
    }

    /**
     * @param int $bookingId
     */
    public function cancelBooking(int $bookingId): int
    {
        $spotRecord = $this->bookingRepository->findByField('id', $bookingId);
        if (empty($spotRecord)) {
            throw new BadRequestException("There is no record for id: " . $bookingId);
        }
        $spotRecord[0]->setStatus(0);
        $this->bookingRepository->add($spotRecord[0], true);
        return Response::HTTP_OK;
    }

    public function fetchByUserHash(string $user_hash): array
    {
        $spotRecord = $this->bookingRepository->findByField('user_hash', $user_hash);
        if (empty($spotRecord)) {
            throw new BadRequestException("There is no record for user_hash: " . $user_hash);
        }
        return $this->formatBooking($spotRecord);
    }

    public function fetchAllBooking(): array
    {
        return $this->formatBooking($this->bookingRepository->findAll());
    }

    /**
     * @param array $bookings
     * @return array
     */
    private function formatBooking(array $bookings): array
    {
        $records = [];
        if (!empty($bookings)) {
            foreach ($bookings as $booking) :
                $data = [];
                $data['booking_id'] = $booking->getId();
                $data['user_hash'] = $booking->getUserHash();
                $data['reserve_spot'] = $booking->getReserveSpot();
                $data['status'] = ($booking->getStatus() == 1) ? constant('App\\Constant\\Booking::STATUS_BOOKED') : constant('App\\Constant\\Booking::STATUS_CANCELLED');
                array_push($records, $data);
            endforeach;
        }
        return $records;
    }
}
