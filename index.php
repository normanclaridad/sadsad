<?php
include('inc/app_settings.php');
require_once('inc/helpers.php');
require_once('models/Events.php');
require_once('models/Transactions.php');
require_once('models/Entrances.php');
require_once('models/Requested_dances.php');

$helpers = new Helpers();
$events = new Events(); 
$transactions = new Transactions();
$entrances = new Entrances();
$requestedDances = new Requested_dances();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$resEvents = $events->getWhere("WHERE status = 'Y' AND start <= '". date('Y-m-d H:i:s') ."' AND end >= '". date('Y-m-d H:i:s') ."'");
$message = '';
if(empty($resEvents)) {
    $message = 'No event set for today!';
}

if(count($resEvents) > 1) {
    $message = 'More than One(1) event enabled. It should only one(1) event should be enabled.';   
}

$eventId = (count($resEvents) == 1) ? $resEvents[0]['id'] : 0;
$eventName = (count($resEvents) == 1) ? $resEvents[0]['name'] : '';
$salesCount = 0;
if(count($resEvents) == 1) {
    $salesCount = $transactions->getSalesCount(" AND t.event_id = $eventId");
}

$gross = 0.00;
$revenue = 0.00;
$entranceRev = 0.00;
$requestedDanceRev = 0.00;
$entranceCategory = [
    [
        'name' => 'male',
        'quantity' => 0
    ],
    [
        'name' => 'female',
        'quantity' => 0
    ],
    [
        'name' => 'kids',
        'quantity' => 0
    ],
    [
        'name' => 'table-charge',
        'quantity' => 0
    ],
];
if(count($resEvents) == 1) {
    $whereGrossRev = "AND t.event_id = $eventId AND pr.event_id = $eventId";
    $resGrossRev = $transactions->getGrossRevenue($whereGrossRev);

    $gross = $resGrossRev['gross'];
    $revenue = $resGrossRev['revenue'];

    $entranceRev = $entrances->getEntranceRevenue(" AND event_id = $eventId");

    $whereEntranceCategory = " AND event_id = $eventId GROUP BY name";

    $entranceCategory = $entrances->getEntranceByCategory($whereEntranceCategory);

    $requestedDanceRev = $requestedDances->getCurachaRequestDance("AND event_id = $eventId");
}

include_once 'templates/header.php';
include_once 'templates/sidebar.php';
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <!-- <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div> -->

                            <div class="card-body">
                                <h5 class="card-title">
                                    Sales
                                    <?php if(!empty($eventName)){ ?>
                                    <span>| <?php echo $eventName ?></span>
                                    <?php } ?>
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>
                                            <?php echo $salesCount ?>
                                        </h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span>
                                        <span class="text-muted small pt-2 ps-1">increase</span> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card revenue-card">

                            <!-- <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div> -->

                            <div class="card-body">
                            <h5 class="card-title">
                                Gross 
                                <?php if(!empty($eventName)){ ?>
                                    <span>| <?php echo $eventName ?></span>
                                <?php } ?>
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>
                                        <?php echo number_format($gross,2) ?>
                                    </h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                                </div>
                            </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card revenue-card">

                            <!-- <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div> -->

                            <div class="card-body">
                                <h5 class="card-title">
                                    Revenue                                    
                                    <?php if(!empty($eventName)){ ?>
                                        <span>| <?php echo $eventName ?></span>
                                    <?php } ?>
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo number_format($revenue,2) ?></h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->
                    <!-- Entrance Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Entrance Revenue                                    
                                    <?php if(!empty($eventName)){ ?>
                                        <span>| <?php echo $eventName ?></span>
                                    <?php } ?>
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-lines-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo number_format($entranceRev,2) ?></h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Entrance Card -->
                    <!-- Entrance Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Curacha/Requested Dance                                    
                                    <?php if(!empty($eventName)){ ?>
                                        <span>| <?php echo $eventName ?></span>
                                    <?php } ?>
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-lines-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo number_format($requestedDanceRev,2) ?></h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Entrance Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Entrance List By Category</h5>
                                <!-- List group With badges -->
                                <ul class="list-group">
                                    <?php foreach($entranceCategory as $category): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo ucfirst($category['name']) ?>
                                        <span class="badge bg-primary rounded-pill">
                                            <?php echo $category['quantity'] ?>
                                        </span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul><!-- End List With badges -->
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>

  </main><!-- End #main -->
<?php
    include_once 'templates/footer.php';
?>