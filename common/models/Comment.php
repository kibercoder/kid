<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $entity
 * @property int $entityId
 * @property string $content
 * @property int $parentId
 * @property int $level
 * @property int $createdBy
 * @property int $updatedBy
 * @property string $relatedTo
 * @property string $url
 * @property int $status
 * @property int $createdAt
 * @property int $updatedAt
 * @property int $count_like Лайков
 *
 * @property UserComment[] $userComments
 * @property User[] $us
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity', 'entityId', 'content', 'createdBy', 'updatedBy', 'relatedTo', 'createdAt', 'updatedAt'], 'required'],
            [['entityId', 'parentId', 'level', 'createdBy', 'updatedBy', 'status', 'createdAt', 'updatedAt', 'count_like'], 'integer'],
            [['content', 'url'], 'string'],
            [['entity'], 'string', 'max' => 10],
            [['relatedTo'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity' => 'Entity',
            'entityId' => 'Entity ID',
            'content' => 'Content',
            'parentId' => 'Parent ID',
            'level' => 'Level',
            'createdBy' => 'Created By',
            'updatedBy' => 'Updated By',
            'relatedTo' => 'Related To',
            'url' => 'Url',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'count_like' => 'Лайков',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserComments()
    {
        return $this->hasMany(UserComment::className(), ['id_c' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUs()
    {
        return $this->hasMany(User::className(), ['id' => 'id_u'])->viaTable('userComment', ['id_c' => 'id']);
    }
}
