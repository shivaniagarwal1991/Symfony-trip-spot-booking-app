# Symfony-trip-spot-booking-app

This app consist tests and algorithm to book and cancel the appointment related to Trip.

#### Time to run the database migration (MySQL)

1. DB configuration file path: PROJECT_ROOT/.env
2. php bin/console doctrine:database:create
3. php bin/console doctrine:migration:migrate

**You can also import the database directly into db, please find the db dump at PROJECT_ROOT/spot_booking_system.sql**

#### Steps to run the application

- clone the project
- enter into the root folder of the application
- please run any one of the below command to run the application
	1. php bin/console server:run 
	2. php -S localhost:8001 -t public

#### Database migration for testing (I could also use some in-memory databases):

1 DB configuration file path: PROJECT_ROOT/.env.test
2 Command to create test database:
	php bin/console --env=test doctrine:database:create
3 Command to create table 
	php bin/console --env=test doctrine:schema:create

1) default db path: PROJECT_ROOT/spot_booking_system_test.sql
TestCase:

#### Test cases are still left to run, let's run them.
please make sure to ready the test database before running the test cases.
- To run all test cases
	php ./bin/phpunit tests

- To run the Integration test cases:
	php ./bin/phpunit ./tests/Integration/Controller/BookingControllerTest.php

- To run the Unit test cases:
	php ./bin/phpunit ./tests/Unit/BookingRepositoryTest.php


#### Endpoints
- Due to lack of time i taken a constant for spot count rather than creating endpoint, you can modify that here: PROJECT_ROOT/src/Constant/Booking.php

- To get a single user spot booked Detail:  
GET http://localhost:8001/spot/booking/user?user_hash=test@gmail.com

- To get all booked spot (we would add trip id as soon as we give flexibility to add trip to get only respective trip. Rightnow we have only one trip so it do the same):
GET http://localhost:8001/spot/booking 

- To reserve spots:
POST http://localhost:8001/spot/booking?user_hash=test@gmail.com&reserve_spot=1

- To cancel the spots booking:
PATCH http://localhost:8001/spot/booking/cancel?user_hash=test@gmail.com&reserve_spot=2

**User hash should be some unique random hash because i don't prefer the sequential ids as user can guess them. we use email for now as hash for simplicity**
**In POST and PATCH taken the input as query parameters which i don't prefer at all but for the simplicity of testing i did it (We can test from browser now)**

#### What we can improve?

- We can make the trip dynamic and user can create/alter the trip and then we can map the trip to the booking to take the various business decisions.
- The GET /spot/booking endpoint should support the pagination to return limited number of records rather than all at once, believe me it will save resource and would be faster if we suppose to have good amount of data.
- I have written very limited amount of test cases due to time constraint but i usually like more granual level of test along with data validation. In case you feel that i should write them as well then i would be happy to do that.
- I agree that there are still lots of opportunity to refector & clean the code along with custom exception handling etc.
