<?php 
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST'); 
    header('Content-Type: application/json');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With'); 

    include_once '../../config/Database.php';
    include_once '../../models/Booking.php';
    include_once '../../models/Car.php';

    $database = new Database();
    $db = $database->connect();

    // instantiate Booking object
    $Booking = new Booking($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $Booking->userId = $data->userId;
    $Booking->carId = $data->carId;
    $Booking->numberOfDays = $data->numberOfDays;
    $Booking->startDate = $data->startDate;

    // to unavail the car
    $car = new Car($db);

    if($Booking->createBooking() && $car->unavailCar($data->carId)) {
        echo json_encode(
            array('message' => 'Booking Created!')
        );
    } else {
        echo json_encode(
            array('message' => 'Booking already exists')
        );
    }
