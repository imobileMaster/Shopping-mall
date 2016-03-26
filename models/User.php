<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
class User extends ActiveRecord implements IdentityInterface
{
    public $id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_userdb2';
    }

    public $authKey;
    public $accessToken;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['userIndex' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUserID($userid)
    {
        return static::findOne(['userID' => $userid]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();    
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->userPassword == crypt($password, $this->userPassword);
    }

    public function getOnline()
    {
        $query = "select (NOW() < DATE_ADD(logonDate, INTERVAL 60 SECOND)) online from tbl_userdb2 where userID='$this->userID' and delStatus='0'";
        return Yii::$app->db->createCommand($query)->queryScalar();
    }
}
