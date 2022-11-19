<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property string $dt_add
 * @property string $last_visit
 * @property string|null $about
 * @property string|null $birthday
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $skype
 * @property int|null $role
 * @property int|null $rate
 *
 * @property Favorites[] $favorites
 * @property Favorites[] $favorites0
 * @property Opinions[] $opinions
 * @property Replies[] $replies
 * @property Reviews[] $reviews
 * @property Reviews[] $reviews0
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UsersCategories[] $usersCategories
 * @property Tasks[] $doneTasks
 * @property Tasks[] $failedTasks
 * @property Tasks[] $workingTasks
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['dt_add', 'last_visit', 'birthday'], 'safe'],
            [['role', 'rate'], 'integer'],
            [['name', 'email', 'password', 'avatar'], 'string', 'max' => 45],
            [['about', 'address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            [['skype'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'avatar' => 'Avatar',
            'dt_add' => 'Dt Add',
            'last_visit' => 'Last Visit',
            'about' => 'About',
            'birthday' => 'Birthday',
            'address' => 'Address',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'role' => 'Role',
            'rate' => 'Rate',
        ];
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorites::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Favorites0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites0()
    {
        return $this->hasMany(Favorites::className(), ['favorite_user_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinions::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews0()
    {
        return $this->hasMany(Reviews::className(), ['recipient_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[UsersCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersCategories()
    {
        return $this->hasMany(UsersCategories::class, ['user_id' => 'id']);
    }

    public function getDoneTasks()
    {
        return $this->hasMany(Tasks::class, ['executor_id' => 'id'])->andWhere(['status' => 'done']);
    }

    public function getFailedTasks()
    {
        return $this->hasMany(Tasks::class, ['executor_id' => 'id'])->andWhere(['status' => 'fail']);
    }

    public function getWorkingTasks()
    {
        return $this->hasMany(Tasks::class, ['executor_id' => 'id'])->andWhere(['status' => 'in_work']);
    }

    public function getRating()
    {
        static $rating = null;

        if (is_null($rating) && count($this->replies) > 0) {
            $ratings = [];
            foreach ($this->replies as $reply) {
                $ratings[] = $reply->rate;
            }

            $rating = array_sum($ratings) / count($ratings);
        }
        return $rating;
    }

    public function getAge($birthday)
    {
        $birthday_timestamp = strtotime($birthday);
        $age = date('Y') - date('Y', $birthday_timestamp);
        if (date('md', $birthday_timestamp) > date('md')) {
            $age--;
        }

        return $age;
    }
}
