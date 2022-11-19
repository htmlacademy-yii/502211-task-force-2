<?php
namespace app\controllers;

use app\models\SearchTasks;
use app\models\Categories;
use app\models\Tasks;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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

    public function actionView($id)
    {
        $task = Tasks::findOne($id);

        if (!$task) {
            throw new NotFoundHttpException("Нет такого задания!");
        }

        return $this->render('view-task', ['task' => $task]);
    }
}
