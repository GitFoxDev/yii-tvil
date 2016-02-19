<?php
/**
 * @var UsersController $this
 * @var CActiveDataProvider $dataProvider
 * @var array $userList
 */

$this->menu=array(
    array('label'=>'Create Users', 'url'=>array('create')),
    array('label'=>'Manage Users', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#users-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");

Yii::app()->clientScript->registerScript('search_data', "
var searchData = " . json_encode($userList) . ";
");

Yii::app()->clientScript->registerCss('search', ".search-block+.search-block {margin-top: 15px;}");

$acGeneralConfig = array(
    'options' => array(
        'minLength' => '1',
        'select' => 'js: function(event, ui) {
            console.log(ui.item.id);
            location.href = "' . Yii::app()->createUrl('users/view') . '" + "&id=" + ui.item.id;
            return false;
        }',
    ),
    'htmlOptions' => array(
        'style' => 'height:20px;',
    ),
);

$acAjaxConfig = array(
    'name' => 'user_id_1',
    'source' => Yii::app()->createUrl('users/search'),
);

$acPageConfig = array(
    'name' => 'user_id_2',
    'source' => 'js: searchData',
);
?>

<h1>Search Users</h1>

<div class="search-block">
    <div>AJAX поиск:</div>
    <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array_merge($acAjaxConfig, $acGeneralConfig)); ?>
</div>

<div class="search-block">
    <div>Поиск по странице:</div>
    <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array_merge($acPageConfig, $acGeneralConfig)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'users-grid',
	'dataProvider' => $model->search(),
    'afterAjaxUpdate' => 'function(id, data){
        var newSearchData = [];
        $("#users-grid tbody tr").each(function(){
            var item = {};
            item.id = $(this).find("td:nth-child(1)").text();

            var itemFirst = $(this).find("td:nth-child(2)").text();
            var itemLast = $(this).find("td:nth-child(3)").text();
            var itemEmail = $(this).find("td:nth-child(4)").text();

            item.label = "ID " + item.id + ": " + itemFirst + (itemLast ? " " + itemLast : "") + " (" + itemEmail + ")";
            item.value = item.label;
            newSearchData.push(item);
        });
        searchData = newSearchData;
        $("#user_id_2").autocomplete("option", { source: searchData });
    }',
	'filter' => $model,
	'columns' => array(
		'id',
		'first_name',
		'last_name',
		'email',
		array(
			'class' => 'CButtonColumn',
            'template' => '{view}',
		),
	),
)); ?>