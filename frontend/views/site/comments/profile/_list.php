<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii2mod\editable\Editable;
use common\models\UserComment;


/* @var $this \yii\web\View */
/* @var $model \yii2mod\comments\models\CommentModel */
/* @var $maxLevel null|integer comments max level */

?>

<div class="post comment" id="comment-<?=$model->id;?>">

    <div data-comment-content-id="<?php echo $model->id ?>">

        <div class="comment-details">
        
            <div class="comment-body">


    <header class="post__header">
        <div class="level-wrap">
          <div class="avatar red">
            <?php 
                echo Html::img(
                        common\models\User::getAvatar($model->createdBy), 
                        ['alt' => $model->getAuthorName()]
                );
            ?>
          </div>
          <div class="level level_small">
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
            <span class="level__star"></span>
          </div>
        </div>
        <div class="post__info">
            <a class="post__name" href="javascript:void(0)">
                <?php echo $model->getAuthorName(); ?>
            </a>
            <time class="post__time">
                <?php echo Html::a($model->getPostedDate(), $model->getAnchorUrl(), ['class' => 'comment-date']); ?>
            </time>
        </div>
    </header>

                <?php if (Yii::$app->getModule('comment')->enableInlineEdit 
                    && (Yii::$app->getUser()->can('admin') || \Yii::$app->user->identity->id == $model->createdBy)): ?>
                    
                    <?php 

                    echo Editable::widget([
                        'model' => $model,
                        'attribute' => 'content',
                        'url' => '/comment/default/quick-edit',
                        'options' => [
                            'id' => 'editable-comment-' . $model->id,
                        ],
                    ]); ?>

                <?php else: ?>
                    <?php echo $model->getContent(); ?>
                <?php endif; ?>
            </div>
        </div>

    <footer class="post__footer post__content comment-content">
        
        <div class="comment-action-buttons">
    
            <?php if (\Yii::$app->user->identity->id == $model->createdBy) : ?>

                <?php echo Html::a('x', '#', ['data' => ['action' => 'delete', 'url' => Url::to(['/comment/default/delete', 'id' => $model->id]), 'comment-id' => $model->id], 'class' => 'comment-delete' ]); ?>

            <?php endif; ?>

            <?php
                $likeUser = UserComment::find()->select('*')
                        ->where(
                            'id_u = ' . \Yii::$app->user->identity->id 
                            . ' and ' . 'id_c = '.$model->id
                        )->asArray()->count();

                $classLike = ($likeUser) ? 'like' : 'like dislike';
            ?>

            <button class="<?=$classLike?>" type="button" comment-id="<?=$model->id?>" user-id="<?=\Yii::$app->user->identity->id?>">
                <?=$model->count_like;?>
            </button>

            <?php //if (!Yii::$app->user->isGuest && ($model->level < $maxLevel || is_null($maxLevel))) : ?>
                <?php 

                $comment_count = (count($model->getChildren()) > 0) ? count($model->getChildren()) : '';

                echo Html::button($comment_count, ['class' => 'comment-count', 'data' => ['action' => 'reply', 'comment-id' => $model->id]]); ?>
            <?php //endif; ?>

            <button class="repost" type="button">18</button>

        </div>

        
    </footer>

    </div>

<?php $int = 0; if ($model->hasChildren()) : ?>
    <ul class="children post__comments-wrap">
        <?php foreach ($model->getChildren() as $children) : $int++; ?>
            <li class="comment first-level" id="comment-<?php echo $children->id; ?>" item="<?=$int;?>">
                <?php echo $this->render('_children', ['model' => $children, 'maxLevel' => $maxLevel]) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<button class="comment__more" type="button">Все комментарии</button>

</div>

