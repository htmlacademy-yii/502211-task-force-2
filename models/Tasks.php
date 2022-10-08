<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $executor_id
 * @property int|null $customer_id
 * @property string $dt_add
 * @property int $category_id
 * @property string|null $description
 * @property int|null $status
 * @property string $expire
 * @property string $name
 * @property string|null $address
 * @property int|null $budget
 * @property float|null $lat
 * @property float|null $long
 *
 * @property Categories $category
 * @property Users $customer
 * @property Users $executor
 * @property Opinions[] $opinions
 * @property Replies[] $replies
 * @property TasksCategories[] $tasksCategories
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['executor_id', 'category_id', 'expire', 'name'], 'required'],
            [['executor_id', 'customer_id', 'category_id', 'status', 'budget'], 'integer'],
            [['dt_add', 'expire'], 'safe'],
            [['lat', 'long'], 'number'],
            [['description', 'address'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 45],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'executor_id' => 'Executor ID',
            'customer_id' => 'Customer ID',
            'dt_add' => 'Dt Add',
            'category_id' => 'Category ID',
            'description' => 'Description',
            'status' => 'Status',
            'expire' => 'Expire',
            'name' => 'Name',
            'address' => 'Address',
            'budget' => 'Budget',
            'lat' => 'Lat',
            'long' => 'Long',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Users::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinions::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TasksCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksCategories()
    {
        return $this->hasMany(TasksCategories::className(), ['task_id' => 'id']);
    }
}
