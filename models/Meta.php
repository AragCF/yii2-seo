<?php

namespace mirocow\seo\models;

use app\backend\BackendModule;
use app\backend\components\BackendController;
use DevGroup\TagDependencyHelper\CacheableActiveRecord;
use DevGroup\TagDependencyHelper\TagDependencyTrait;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seo_meta".
 *
 * @property string $key
 * @property string $name
 * @property integer $content
 * @property string $lang
 * @property string metaFieldName
 */
class Meta extends ActiveRecord
{
    const KEY_TITLE = 'seoTitle';
    const KEY_DESCRIPTION = 'seoDescription';
    const KEY_KEYWORDS = 'seoKeywords';

    use TagDependencyTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo_meta}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['key', 'name', 'content','lang'], 'required'],
          [['key'], 'unique'],
          [['key', 'name', 'content'], 'string', 'max' => 255],
          [['lang'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          'key' => \Yii::t('app', 'Key'),
          'name' => \Yii::t('app', 'Name'),
          'content' => \Yii::t('app', 'Content'),
          'lang' => \Yii::t('app', 'Language'),
        ];
    }

    /**
     * Search meta tags
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->load($params);
        $query = self::find();
        foreach ($this->attributes as $name => $value) {
            if (!empty($value)) {
                $query->andWhere("`$name` LIKE :$name", [":$name" => "%{$value}%"]);
            }
        }
        $dataProvider = new ActiveDataProvider(
          [
            'query' => $query,
            'pagination' => [
              'pageSize' => 10,
            ],
          ]
        );
        return $dataProvider;
    }

}