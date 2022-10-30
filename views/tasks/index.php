<?php

/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var \app\models\Categories[] $categories */
/** @var \app\models\SearchTasks $modelSearch */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<main class="main-content container">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>

        <?php foreach ($dataProvider->models as $task) : ?>
            <div class="task-card">
                <div class="header-task">
                    <a href="#" class="link link--block link--big"><?php echo $task->name; ?></a>
                    <p class="price price--task"><?php echo $task->budget; ?></p>
                </div>
                <p class="info-text"><span class="current-time"><?php echo $task->getTimePassed(); ?> </span>назад</p>
                <p class="task-text"><?php echo $task->description; ?></p>
                <div class="footer-task">
                    <p class="info-text town-text"><?php echo $task->address; ?></p>
                    <p class="info-text category-text"><?php echo $task->category->name; ?></p>
                    <a href="#" class="button button--black">Смотреть Задание</a>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="pagination-wrapper">
            <ul class="pagination-list">
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">1</a>
                </li>
                <li class="pagination-item pagination-item--active">
                    <a href="#" class="link link--page">2</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">3</a>
                </li>
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="right-column">
        <div class="right-card black">
            <div class="search-form">
                <?php
                $form = ActiveForm::begin([
                    'options' => ['class' => 'search-task__form'],
                    'method' => 'post',
                    'fieldConfig' => [
                        'options' => ['class' => 'control-label']
                    ]
                ]) ?>
                <h4 class="head-card">Категории</h4>
                <div class="form-group">
                    <div class="checkbox-wrapper">
                        <?php foreach ($categories as $attr => $category) : ?>
                            <?php
                            $checked = in_array($category->id, $modelSearch->categories);
                            echo $form
                                ->field($modelSearch, 'categories[$attr]')
                                ->checkbox(['id' => $attr, 'value' => $category->id, 'label' => $category->name, 'checked' => $checked])
                            ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <h4 class="head-card">Дополнительно</h4>
                <div class="form-group">
                    <?php echo $form->field($modelSearch, 'without_customer')->checkbox(['id' => 'without-performer', 'label' => 'Без исполнителя'])->label(''); ?>
                </div>
                <h4 class="head-card">Период</h4>
                <div class="form-group">
                    <label for="period-value"></label>
                    <?php echo $form
                        ->field($modelSearch, 'timePeriod')
                        ->dropdownList(
                            [
                                60 * 60 => '1 час',
                                60 * 60 * 12 => '12 часов',
                                60 * 60 * 24 => '24 часа'
                            ],
                            ['text' => 'Please select', 'options' => ['id' => 'period-value', 'label' => '']]
                        )->label('');
                    ?> 
                </div>
                <?= Html::submitButton('Искать', ['class' => 'button button--blue', 'value' => "Искать"]) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</main>
