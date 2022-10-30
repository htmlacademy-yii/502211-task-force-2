<?php
namespace app\controllers;

use app\models\SearchTasks;
use app\models\Categories;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $modelSearch = new SearchTasks();
        $dataProvider = $modelSearch->search($this->request->post());

        $categories = Categories::find()->where([])->all();

        return $this->render('index', [
            'modelSearch' => $modelSearch,
            'dataProvider' => $dataProvider,
            'categories' => $categories
        ]);
    }
}
