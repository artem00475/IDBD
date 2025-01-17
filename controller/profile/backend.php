<?php

use classes\db\DBPostgres;
use classes\db\entity\ClientProfile;
use classes\db\entity\MasterProfile;

function getImagePath(): string
{
    $upload_file = '';
    if ($_FILES['photo'] && $_FILES['photo']['name']) {
        $file_name = $_FILES['photo']['name'];
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_md5 = md5_file($file_tmp, true);
        $md5_base64 = base64_encode($file_md5);
        $root = '/home/studs/s338923/public_html/isbd';
        $upload_dir = '/upload/' . $md5_base64[0] . '/' . $md5_base64[1] . '/' . substr($md5_base64, 2) . '/';
        if (!is_dir($root . $upload_dir)) {
            mkdir($root . $upload_dir, 0777, true);
        }
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = uniqid() . 'RDB.' . $file_ext;
        $upload_file = $root . $upload_dir . $new_file_name;
        if (!move_uploaded_file($file_tmp, $upload_file)) {
            header('Location: https://se.ifmo.ru/~s338923/isbd' . PROFILE_ID ? '/profile/' : '/profile/create/');
            echo "Ошибка при загрузке файла.";
            return $upload_file;
        }
        $upload_file = $upload_dir . $new_file_name;
    }
    return $upload_file;
}

switch ($_POST["action_type"]) {
    case 'create_master':
        $experience = $_POST["experience"] ?: 0;
        $qualification = $_POST["qualification"] ?: '';
        $photo = getImagePath() ?: '/upload/no-avatar.png';
        try {
            $master = new MasterProfile();
            $master->setExperience($experience);
            $master->setQualification($qualification);
            $master->setUserId(USER_ID);
            $master->setRating(0);
            $master->setPhoto($photo);
            $masterId = DBPostgres::getMasterProfileHandler()->add($master);
            setcookie('PROFILE_ID', $masterId, 0, HOST);
            header('Location: https://se.ifmo.ru/~s338923/isbd/schedule/');
        } catch (Error $e) {
            header('Location: https://se.ifmo.ru/~s338923/isbd/profile/create/');
            echo $e->getMessage();
        }
        break;

    case 'create_client':
        $address = $_POST["address"] ?: '';
        $photo = getImagePath() ?: '/upload/no-avatar.png';
        try {
            $client = new ClientProfile();
            $client->setAddress($address);
            $client->setUserId(USER_ID);
            $client->setPhoto($photo);
            $clientId = DBPostgres::getClientProfileHandler()->add($client);
            setcookie('PROFILE_ID', $clientId, 0, HOST);
            header('Location: https://se.ifmo.ru/~s338923/isbd/');
        } catch (Error $e) {
            header('Location: https://se.ifmo.ru/~s338923/isbd/profile/create/');
            echo $e->getMessage();
        }
        break;

    case 'update_master':
        header('Location: https://se.ifmo.ru/~s338923/isbd/profile/');
        $master = DBPostgres::getMasterProfileHandler()->getById(PROFILE_ID);
        $experience = $_POST["experience"] ?: $master->getExperience();
        $qualification = $_POST["qualification"] ?: $master->getQualification();
        $photo = getImagePath() ?: $master->getPhoto();
        try {
            $master->setExperience($experience);
            $master->setQualification($qualification);
            $master->setPhoto($photo);
            DBPostgres::getMasterProfileHandler()->update(PROFILE_ID, $master);
        } catch (Error $e) {
            echo $e->getMessage();
        }
        break;

    case 'update_client':
        header('Location: https://se.ifmo.ru/~s338923/isbd/profile/');
        $client = DBPostgres::getClientProfileHandler()->getById(PROFILE_ID);
        $address = $_POST["address"] ?: $client->getAddress();
        $photo = getImagePath() ?: $client->getPhoto();
        try {
            $client->setAddress($address);
            $client->setPhoto($photo);
            DBPostgres::getClientProfileHandler()->update(PROFILE_ID, $client);
        } catch (Error $e) {
            echo $e->getMessage();
        }
        break;

    case 'update_user':
        header('Location: https://se.ifmo.ru/~s338923/isbd/profile/');
        $user = DBPostgres::getUserHandler()->getById(USER_ID);
        $login = $_POST["login"] ?: $user->getLogin();
        $name = $_POST["name"] ?: $user->getName();
        $surname = $_POST["surname"] ?: $user->getSurname();
        $email = $_POST["email"] ?: $user->getEmail();
        $phone = $_POST["phone"] ?: $user->getPhone();
        $password = $_POST["password"] ?: $user->getPassword();
        try {
            $user->setLogin($login);
            $user->setName($name);
            $user->setSurname($surname);
            $user->setEmail($email);
            $user->setPhone($phone);
            $user->setPassword($password);
            DBPostgres::getUserHandler()->update(USER_ID, $user);
        } catch (Error $e) {
            echo $e->getMessage();
        }
        break;

    case 'profile_selection':
        if (isset($_POST['ROLE'])) {
            $role = $_POST['ROLE'];
            setcookie("ROLE", $role, 0, HOST);
            if ($role == "Master" && $profileId = DBPostgres::getMasterProfileHandler()->authorize(USER_ID)) {
                setcookie("PROFILE_ID", $profileId, 0, HOST);
            } elseif ($role == "Client" && $profileId = DBPostgres::getClientProfileHandler()->authorize(USER_ID)) {
                setcookie("PROFILE_ID", $profileId, 0, HOST);
            } else {
                setcookie("PROFILE_ID", '', 0, HOST);
            }
            die();
        }
}
