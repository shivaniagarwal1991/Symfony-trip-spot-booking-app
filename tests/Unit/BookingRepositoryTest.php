<?php

namespace App\Tests\Unit;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Booking as BookingEntity;

class BookingRepositoryTest extends WebTestCase
{
    private $bookingRepository;
    private $currentTime;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function setUp(): void
    {
        $this->currentTime = date('d-m-Y');
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->bookingRepository = $this->entityManager
            ->getRepository(BookingEntity::class);
        parent::setUp();
    }

    public function testItCanCreateRecordWithEntity()
    {
        $this->createNewBooking();
        $result = $this->bookingRepository->findByField('user_hash', 'test@gmail.com');
        self::assertNotNull($result);
        self::assertInstanceOf(BookingEntity::class, $result[0]);
        self::assertSame('test@gmail.com', $result[0]->getUserHash());
        self::assertSame(1,  $result[0]->getStatus());
    }

    private function createNewBooking()
    {
        $booking = new BookingEntity();
        $booking->setUserHash('test@gmail.com')
            ->setReserveSpot(1)
            ->setStatus(1)
            ->setCreatedAt($this->currentTime)
            ->setUpdatedAt($this->currentTime);
        $this->bookingRepository->add($booking, true);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
