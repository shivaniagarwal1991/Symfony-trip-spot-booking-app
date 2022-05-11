<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Trait\BookingTrait;
use App\Service\Interface\IBookingService;

class BookingController extends AbstractController
{
    use BookingTrait;

    private $bookingService;

    public function __construct(IBookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    #[Route('/spot/booking', name: 'app_list_booking_spot', methods: 'GET')]

    public function getAllBooking(): JsonResponse
    {
        $bookingData = $this->bookingService->fetchAllBooking();
        return new JsonResponse(['total_bookings' => count($bookingData), 'bookings' => $bookingData]);
    }

    #[Route('/spot/booking/user/', name: 'app_list_booking_spot_by_user_hash', methods: 'GET')]

    public function getByUser(Request $request): JsonResponse
    {
        $validatedUserHash = $this->hasVaildParamsForFetch($request->query->all());
        $bookingData = $this->bookingService->fetchByUserHash($validatedUserHash);
        return new JsonResponse(['total_bookings' => count($bookingData), 'bookings' => $bookingData]);
    }

    #[Route('/spot/booking', name: 'app_booking_spot', methods: 'POST')]

    public function addBooking(Request $request): JsonResponse
    {
        $validatedParam = $this->hasVaildParams($request->query->all());
        $response = $this->bookingService->addBooking($validatedParam);
        return new JsonResponse(['status_code' => $response, 'message' => 'Successfully booked your spot']);
    }

    #[Route('/spot/booking/cancel/{id}', name: 'app_cancle_booking_spot', methods: 'PATCH')]

    public function cancelBooking(int $id): JsonResponse
    {
        $response = $this->bookingService->cancelBooking($id);
        return new JsonResponse(['status_code' => $response, 'message' => 'Successfully cancelled your spot']);
    }
}
