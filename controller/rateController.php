<?php
/*
 * Route Controller
 * Description: Route Controller
 * Author: YEN
 */

session_start();
require_once '../config/config.php';

class RouteController {
    private $db;

    public function __construct() {
        $conn = new Connection();
        $this->db = $conn->getConnection();
    }

    public function addRoute() {
        $user = $_SESSION['user_id'];
        $route = $_POST['description'];

        $sql = "SELECT * FROM `frs_routes` WHERE `description` = ? AND `deleted` != b'1'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$route]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = 'Error: Route already exists!';
            echo "<script>window.location.href='../admin/route.php';</script>";
        }
        else {
            $sqlinsert = "INSERT INTO `frs_routes`(`description`, `created_by`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$route, $user]);

            $description = "Added a new route.";
            $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['success'] = 'Success: Route added!';
            echo "<script>window.location.href='../admin/route.php';</script>";
        }
    }

    public function editRoute() {
        $user = $_SESSION['user_id'];
        $route = $_POST['route_id'];
        $description = $_POST['description'];

        $sql = "SELECT * FROM `frs_routes` WHERE `description` = ? AND `deleted` != b'1' AND `id` != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$description, $route]);

        if ($stmt->rowcount() > 0) {
            $_SESSION['error'] = "Error: Route already exists!";
            echo "<script>window.location.href='../admin/route.php';</script>";
        }
        else {
            $sqlupdate = "UPDATE `frs_routes` SET `description` = ?, `updated_by` = ? WHERE `id` = ?";
            $statementupdate = $this->db->prepare($sqlupdate);
            $statementupdate->execute([$description, $user, $route]);

            $description = "Updated Route.";
            $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
            $statementinsert = $this->db->prepare($sqlinsert);
            $statementinsert->execute([$user, $description]);

            $_SESSION['updated'] = 'Success: Route updated!';
            echo "<script>window.location.href='../admin/route.php';</script>";
        }
    }

    public function deleteRoute() {
        $user = $_SESSION['user_id'];
        $route = $_POST['route_id'];

        $sqlupdate = "UPDATE `frs_routes` SET `deleted` = b'1', `updated_by` = ? WHERE `id` = ?";
        $statementupdate = $this->db->prepare($sqlupdate);
        $statementupdate->execute([$user, $route]);

        $description = "Deleted Route.";
        $sqlinsert = "INSERT INTO `frs_trail` (`user_id`, `description`) VALUES (?,?)";
        $statementinsert = $this->db->prepare($sqlinsert);
        $statementinsert->execute([$user, $description]);

        $_SESSION['deleted'] = 'Success: Route deleted!';
        echo "<script>window.location.href='../admin/route.php';</script>";
    }
}

$controller = new RouteController();

if (isset($_POST['add'])) $controller->addRoute();
if (isset($_POST['edit'])) $controller->editRoute();
if (isset($_POST['delete'])) $controller->deleteRoute();