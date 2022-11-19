<?php
namespace app\controllers;

use app\models\Users;
use app\models\UsersCategories;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function actionView($id)
    {
        $user = Users::findOne($id);
        $categories = UsersCategories::find()->where(['user_id' => $id])->all();
        $user = Users::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException("Нет такого пользователя!");
        }

        return $this->render('index', [
            'user' => $user,
            'categories' => $categories
        ]);
    }
}
