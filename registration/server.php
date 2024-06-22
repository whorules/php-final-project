<?php
session_start();

$username = "";
$email    = "";
$errors = array();

$db = mysqli_connect('127.0.0.1', 'root', 'password', 'php_final_project');

if (isset($_POST['reg_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  if (empty($username)) { array_push($errors, "Логин обязателен"); }
  if (empty($email)) { array_push($errors, "Email обязателен"); }
  if (empty($password_1)) { array_push($errors, "Пароль обязателен"); }
  if ($password_1 != $password_2) {
        array_push($errors, "Пароли не совпадают");
  }

  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $get_role_id_query = "SELECT role_id FROM roles WHERE role_name = 'USER'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
    if ($user['username'] === $username) {
      array_push($errors, "Пользователь с таким именем уже зарегестрирован");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Пользователь с таким email уже зарегестрирован");
    }
  }

  if (count($errors) == 0) {
    $role_query = "SELECT role_id FROM roles WHERE role_name = 'ADMIN'";
    $role_result = mysqli_query($db, $role_query);
    $role_row = mysqli_fetch_assoc($role_result);
    $role_id = $role_row['role_id'];

    $stmt = $db->prepare("INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $email, $password_1, $role_id);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: ../main/orders.php');
        exit();
    }
  }
}

if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Логин обязателен");
    }
    if (empty($password)) {
        array_push($errors, "Пароль обязателен");
    }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $user = mysqli_fetch_assoc($results);
            $_SESSION['user_id'] = $user['user_id']; // Сохраняем user_id в сессии
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";

            setcookie('username', $username, time() + (7 * 24 * 60 * 60), "/");

            header('location: ../main/orders.php');
        } else {
            array_push($errors, "Неверный логин / пароль");
        }
    }
}
?>
