<?php

namespace core\modules\forum\models\db;

use core\modules\forum\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Email AR
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $email
 * @property string $subject
 * @property string $content
 * @property integer $status
 * @property integer $attempt
 * @property integer $created_at
 * @property integer $updated_at
 */
class EmailActiveRecord extends ActiveRecord
{
    /**
     * Statuses.
     */
    const STATUS_PENDING = 0;
    const STATUS_SENT    = 1;
    const STATUS_GAVEUP  = 9;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'subject', 'content'], 'required'],
            ['email', 'email'],
            [['subject', 'content'], 'string'],
            ['status', 'default', 'value' => self::STATUS_PENDING],
            ['attempt', 'default', 'value' => 0],
            ['status', 'in', 'range' => [self::STATUS_PENDING, self::STATUS_SENT, self::STATUS_GAVEUP]]
        ];
    }
}
