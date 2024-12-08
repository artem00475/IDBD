<?php
namespace classes\db\handler\impl;
use classes\db\DBPostgres;
use classes\db\entity\MasterProfile;
use classes\db\handler\MasterProfileHandler;
use PDO;

class MasterProfileHandlerImpl implements MasterProfileHandler
{

    function authorize(int $userId): int
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT check_master(:user)');
        $stmt->bindValue(':user', $userId);
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($obj['check_master']) {
            $obj['check_master'] = trim($obj['check_master'], '()');
            $ar = explode(",",$obj['check_master']);
            return $ar[0] ?: 0;
        } else {
            return 0;
        }
    }

    function add(MasterProfile $masterProfile): int
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT create_master(:userId, :experience, :photo, :rating, :qualification)');
        $stmt->bindValue(':userId', $masterProfile->getUserId());
        $stmt->bindValue(':experience', $masterProfile->getExperience());
        $stmt->bindValue(':photo', $masterProfile->getPhoto());
        $stmt->bindValue(':rating', $masterProfile->getRating());
        $stmt->bindValue(':qualification', $masterProfile->getQualification());
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($obj['create_master']) {
            $obj['create_master'] = trim($obj['create_master'], '()');
            $ar = explode(",",$obj['create_master']);
            return $ar[0] ?: 0;
        } else {
            return 0;
        }
    }

    function getById(int $id): MasterProfile|null
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT get_master(:id)');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($obj['get_master']) {
            $obj['get_master'] = trim($obj['get_master'], '()');
            $ar = explode(",",$obj['get_master']);
            $master = new MasterProfile();
            $master->setUserId($ar[0]);
            $master->setExperience($ar[3]);
            $master->setPhoto($ar[2]);
            $master->setRating($ar[1]);
            $master->setQualification($ar[4]);
            return $master;
        } else {
            return null;
        }
    }

    function update(int $id, MasterProfile $masterProfile): bool
    {
        $stmt = DBPostgres::getConnection()->prepare('SELECT update_master(:id, :userId, :experience, :photo, :rating, :qualification)');
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':userId', $masterProfile->getUserId());
        $stmt->bindValue(':experience', $masterProfile->getExperience());
        $stmt->bindValue(':photo', $masterProfile->getPhoto());
        $stmt->bindValue(':rating', $masterProfile->getRating());
        $stmt->bindValue(':qualification', $masterProfile->getQualification());
        $stmt->execute();
        $obj = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($obj['update_master']) {
            $obj['update_master'] = trim($obj['update_master'], '()');
            $ar = explode(",", $obj['update_master']);
            return (bool)$ar[0];
        } else {
            return 0;
        }
    }

    function getAll(): array
    {
        $req = DBPostgres::getConnection()->query('SELECT findall_workers()');
        $arWorker = [];
        while ($obj = $req->fetch(\PDO::FETCH_ASSOC)) {
            $obj['findall_workers'] = trim($obj['findall_workers'], '()');
            $ar = explode(",", $obj['findall_workers']);
            $arWorker[$ar[4]] = [
                'NAME' => $ar[1],
                'RATE' => $ar[2],
                'EXPERIENCE' => $ar[3],
                'PHOTO' => $ar[0],
                'QUALIFICATION' => $ar[5]
            ];
        }
        return $arWorker;
    }

    function getByDate(string $date): array
    {
        $req = DBPostgres::getConnection()->prepare('SELECT get_masters(:date)');
        $req->bindValue(':date',$_GET['date']);
        $req->execute();
        $table = [];
        while ($obj = $req->fetch(\PDO::FETCH_ASSOC)) {
            $obj['get_masters'] = trim($obj['get_masters'], '()');
            $ar = explode(",",$obj['get_masters']);
            $table[] = ['id' => $ar[0], 'rating' => $ar[1]];
        }
        return $table;
    }
}