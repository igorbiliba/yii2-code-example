<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 27.02.16
 * Time: 12:07
 */

namespace app\models;


use yii\db\ActiveQuery;

class PostEventsQuery extends ActiveQuery
{
    /**
     * все, кроме копий
     *
     * @return $this
     */
    public function notCopy() {
        return $this->andWhere('post_events.is_copy <> 1');
    }
    
    /**
     * письма в ожидании
     * 
     * @return type
     */
    public function wait() {
        return $this->andWhere('post_events.status = "wait"');
    }
    
    /**
     * Письма, которым пришло время отправиться
     * 
     * @return type
     */
    public function needSend() {
        return $this->andWhere('post_events.status = "wait"')
                ->andWhere('post_events.expire <= ' . time());
    }
}