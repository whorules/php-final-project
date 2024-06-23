<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

require_once '../main/db.php';

$username = "";
$email    = "";
$errors = array();

$db = new Database();
$conn = $db->getConnection();

if (isset($_POST['reg_user'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password_1 = htmlspecialchars($_POST['password_1']);
    $password_2 = htmlspecialchars($_POST['password_2']);

    if (empty($username)) { array_push($errors, "Логин обязателен"); }
    if (empty($email)) { array_push($errors, "Email обязателен"); }
    if (empty($password_1)) { array_push($errors, "Пароль обязателен"); }
    if ($password_1 != $password_2) {
        array_push($errors, "Пароли не совпадают");
    }

    $user_check_query = "SELECT * FROM users WHERE username=:username OR email=:email LIMIT 1";
    $stmt = $conn->prepare($user_check_query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Пользователь с таким именем уже зарегистрирован");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Пользователь с таким email уже зарегистрирован");
        }
    }

    if (count($errors) == 0) {
        $role_query = "SELECT role_id FROM roles WHERE role_name = 'USER'";
        $role_stmt = $conn->prepare($role_query);
        $role_stmt->execute();
        $role_row = $role_stmt->fetch(PDO::FETCH_ASSOC);
        $role_id = $role_row['role_id'];

        $insert_query = "INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_1);  // Storing plaintext password
        $stmt->bindParam(':role_id', $role_id);

        if ($stmt->execute()) {
            $user_id = $conn->lastInsertId();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: ../main/orders.php');
            exit();
        }
    }
}

if (isset($_POST['login_user'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($username)) {
        array_push($errors, "Логин обязателен");
    }
    if (empty($password)) {
        array_push($errors, "Пароль обязателен");
    }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username=:username AND password=:password";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);  // Checking plaintext password
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";

            setcookie('username', $username, time() + (7 * 24 * 60 * 60), "/");
            setcookie('role_id', $user['role_id'], time() + (7 * 24 * 60 * 60), "/");

            // Проверяем роль пользователя
            if ($user['role_id'] == 1) {
                header('location: ../main/admin.php');
            } else {
                header('location: ../main/orders.php');
            }
            exit();
        } else {
            array_push($errors, "Неверный логин / пароль");
        }
    }
}
?>
