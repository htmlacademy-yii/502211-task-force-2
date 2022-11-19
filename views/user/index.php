<?php

/** @var app\models\Users $user */
/** @var app\models\UsersCategories $categories */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<main class="main-content container">
    <div class="left-column">
        <h3 class="head-main"><?php echo $user->name; ?></h3>
        <div class="user-card">
            <div class="photo-rate">
                <?php echo Html::img("@web/img/{$user->avatar}", ['class' => 'card-photo', 'id' => '', 'width' => 191, 'height' => 190, 'alt' => 'Фото пользователя']); ?>

                <div class="card-rate">
                    <div class="stars-rating big">
                        <span class="current-rate"><?php echo $user->rate; ?></span>
                        <?php for ($i = 0; $i < $user->getRating(); $i++): ?>
                            <span class="fill-star">&nbsp;</span>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <p class="user-description"><?php echo $user->about?></p>
        </div>
        <div class="specialization-bio">
            <div class="specialization">
                <p class="head-info">Специализации</p>
                <ul class="special-list">
                    <?php foreach ($categories as $category): ?>
                        <li class="special-item">
                            <a href="#" class="link link--regular"><?php echo $category->category->name; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="bio">
                <p class="head-info">Био</p>
                <p class="bio-info">
                    <span class="town-info"><?php echo $user->address ?></span>,
                    <span class="age-info"><?php $user->getAge($user->birthday); ?></span> лет</p>
            </div>
        </div>
        <h4 class="head-regular">Отзывы заказчиков</h4>
        <?php foreach ($user->reviews0 as $review): ?>
            <div class="response-card">
                <?php echo Html::img("@web/img/{$review->author->avatar}", ['class' => 'customer-photo', 'id' => '', 'width' => 120, 'height' => 127, 'alt' => 'Фото заказчиков']); ?>

                <div class="feedback-wrapper">
                    <p class="feedback"><?php echo $review->description ?></p>
                    <p class="task">
                        Задание «<a href="<?php echo Url::to(['tasks/view', 'id' => $review->task->id]);?>" class="link link--small">
                            <?php echo $review->task->name ?></a>»
                        <?php if ($review->task->status == 'canceled'): ?>
                            отменено
                        <?php endif; ?>

                        <?php if ($review->task->status == 'in_work'): ?>
                            в работе
                        <?php endif; ?>

                        <?php if ($review->task->status == 'done'): ?>
                            выполнено
                        <?php endif; ?>

                        <?php if ($review->task->status == 'failed'): ?>
                            провалено
                        <?php endif; ?>
                    </p>
                </div>

                <div class="feedback-wrapper">
                    <div class="stars-rating small">
                    <?php for ($i = 0; $i < $review->rate; $i++): ?>
                        <span class="fill-star">&nbsp;</span>
                    <?php endfor; ?>
                    <p class="info-text"><span class="current-time"><?php $review->getTimePassed() ?> </span>назад</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="right-column">
        <div class="right-card black">
            <h4 class="head-card">Статистика исполнителя</h4>
            <dl class="black-list">
                <dt>Всего заказов</dt>
                <dd><?php echo count($user->doneTasks); ?> выполнено, <?php echo count($user->failedTasks); ?> провалено</dd>
                <?php
                    $rating = $user->getRating();
                    if (!is_null($rating)):
                ?>
                    <dt>Место в рейтинге</dt>
                    <dd><?php echo $rating; ?> место</dd>
                <?php endif; ?>
                <dt>Дата регистрации</dt>
                <dd><?php echo $user->dt_add; ?></dd>
                <dt>Статус</dt>
                <?php if ($user->workingTasks): ?>
                    <dd>Открыт для новых заказов</dd>
                <?php else: ?>
                    <dd>Закрыт для новых заказов</dd>
                <?php endif; ?>
            </dl>
        </div>
        <div class="right-card white">
            <h4 class="head-card">Контакты</h4>
            <ul class="enumeration-list">
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--phone"><?php echo $user->phone; ?></a>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--email"><?php echo $user->email; ?></a>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--tg"><?php echo $user->telegram; ?></a>
                </li>
            </ul>
        </div>
    </div>
</main>
