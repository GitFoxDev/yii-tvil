<?php

/**
 * This is the model class for table "tbl_users".
 *
 * The followings are the available columns in table 'tbl_users':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('first_name, email', 'required'),
			array('first_name, last_name', 'length', 'max'=>32),
			array('email', 'length', 'max'=>128),
			array('first_name, last_name, email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'Имя',
			'last_name' => 'Фамилия',
			'email' => 'Электронная почта',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Поиск по всем полям пользователя
     *
     * @param string $phrase поисковая фраза
     * @return array|mixed|null
     */
	public static function fullSearch($phrase)
    {
        if (empty($phrase)) {
            return null;
        }
        $phrase = mb_strtolower($phrase, 'utf-8');

        $criteria = new CDbCriteria;

        $criteria->addSearchCondition('LOWER(first_name)', $phrase, true, 'OR');
        $criteria->addSearchCondition('LOWER(last_name)', $phrase, true, 'OR');
        $criteria->addSearchCondition('LOWER(email)', $phrase, true, 'OR');

        return Users::model()->findAll($criteria);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
