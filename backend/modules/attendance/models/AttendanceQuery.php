<?php

namespace backend\modules\attendance\models;

/**
 * This is the ActiveQuery class for [[Attendance]].
 *
 * @see Attendance
 */
class AttendanceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Attendance[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Attendance|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
