<?php
namespace app\models;
use yii\db\ActiveQuery;

class PostEventsTemplatesQuery extends ActiveQuery
{    
    public function getActive() {
        return $this
            ->andWhere('post_events_templates.is_active = 1');
    }
}