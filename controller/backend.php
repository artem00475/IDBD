<?php

use classes\db\DBPostgres;
use classes\db\entity\ClientProfile;
use classes\db\entity\Feedback;
use classes\db\entity\MasterProfile;
use classes\db\entity\Order;
use classes\db\entity\Subscription;
use classes\db\entity\SupportRequest;
use classes\db\entity\Technique;

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
    case 'create_order':
        header('Location: https://se.ifmo.ru/~s338923/isbd/orders/');
        $date = $_POST["date"];
        $comment = $_POST["comment"];
        $technique = $_POST["technique"];
        try {
            $table = DBPostgres::getMasterProfileHandler()->getByDate($date);
            if (count($table) > 0) {
                $order = new Order();
                $order->setClient(PROFILE_ID);
                $order->setTechnique($technique);
                $order->setContent($comment);
                $order->setCost(1000);
                $order->setDate($date);
                $orderId = DBPostgres::getOrderHandler()->add($order);
                DBPostgres::getMasterLogsHandler()->addNewOrder(intval(current($table)['id']), $orderId);
            } else { ?>
                <script>alert('Нет свободных мастеров на эту дату')</script>
            <?php }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'create_order_master':
        header('Location: https://se.ifmo.ru/~s338923/isbd/orders/');
        $masterId = $_POST["masterId"];
        $date = $_POST["date"];
        $comment = $_POST["comment"];
        $technique = $_POST["technique"];

        try {
            $order = new Order();
            $order->setClient(PROFILE_ID);
            $order->setTechnique($technique);
            $order->setContent($comment);
            $order->setCost(1000);
            $order->setDate($date);
            $orderId = DBPostgres::getOrderHandler()->addWithMaster($order, $masterId);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'rate_order':
        header('Location: https://se.ifmo.ru/~s338923/isbd/orders/');
        $order = $_POST["order_id"];
        $comment = $_POST["comment"];
        $rating = $_POST["rating"];
        try {
            $feedback = new Feedback();
            $feedback->setOrderId($order);
            $feedback->setClientId(PROFILE_ID);
            $feedback->setContent($comment);
            $feedback->setRating($rating);
            DBPostgres::getFeedbackHandler()->add($feedback);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'add_technique':
        header('Location: https://se.ifmo.ru/~s338923/isbd/technique/');
        $date = $_POST["date"];
        $technique = $_POST["technique"];
        try {
            $tech = new Technique();
            $tech->setClientId(PROFILE_ID);
            $tech->setDate($date);
            $tech->setTechnique($technique);
            DBPostgres::getOwnerHandler()->add($tech);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'new_subscribe':
        header('Location: https://se.ifmo.ru/~s338923/isbd/subscribe/');
        $start_date = $_POST["start_date"];
        $finish_date = $_POST["finish_date"];
        $plan_id = $_POST["technique"];
        try {
            $sub = new Subscription();
            $sub->setClient(PROFILE_ID);
            $sub->setPlan($plan_id);
            $sub->setStartDate($start_date);
            $sub->setFinishDate($finish_date);
            DBPostgres::getSubscriberHandler()->add($sub);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'qa':
        header('Location: https://se.ifmo.ru/~s338923/isbd/qa/');
        $theme = $_POST["theme"];
        $comment = $_POST["comment"];
        try {
            $request = new SupportRequest();
            $request->setClientId(PROFILE_ID);
            $request->setTheme($theme);
            $request->setContent($theme);
            DBPostgres::getSupportRequestHandler()->add($request);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'schedule':
        header('Location: https://se.ifmo.ru/~s338923/isbd/schedule/');
        $days = $_POST["days"];
        try {
            DBPostgres::getScheduleHandler()->updateByMaster(PROFILE_ID, $days);
        } catch (Error $e) {
            echo $e->getMessage();
        }
        break;

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
}
?>