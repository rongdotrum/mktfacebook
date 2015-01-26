<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::import('zii.widgets.grid.CGridView');
Yii::import('zii.widgets.grid.CGridColumn');

/**
 * Description of GWGRequestTradeCListView
 *
 * @author Admin
 */
class GWGGridViewPowerFight extends CGridView {

    public $template = "{items}\n{pager}";

    /**
     * Initializes the grid view.
     * This method will initialize required property values and instantiate {@link columns} objects.
     */
    public function init() {
        parent::init();

        if (empty($this->updateSelector))
            throw new CException(Yii::t('zii', 'The property updateSelector should be defined.'));

        if (!isset($this->htmlOptions['class']))
            $this->htmlOptions['class'] = 'grid-view-powerfight';

        if ($this->baseScriptUrl === null)
            $this->baseScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')) . '/gridview';

        if ($this->cssFile !== false) {
            //if ($this->cssFile === null)
            $url = app()->theme->baseUrl . '/css/style_powerfight.css';
            Yii::app()->getClientScript()->registerCssFile($url);
        }

        //$this->initColumns();
    }

    public function renderFilter() {
        if ($this->filter !== null) {
            echo "<tr class=\"{$this->filterCssClass}\">\n";
            foreach ($this->columns as $column) {
                $column->renderFilterCell();
                break;
            }
            echo "</tr>\n";
        }
    }

    public function renderTableHeader() {
        if (!$this->hideHeader) {
            echo "<thead>\n";
            if ($this->filterPosition === self::FILTER_POS_HEADER)
                $this->renderFilter();
            if ($this->filterPosition === self::FILTER_POS_BODY)
                $this->renderFilter();
            echo "<tr>\n";
            foreach ($this->columns as $column) {
                $column->renderHeaderCell();
            }
            echo "</tr>\n";
            echo "</thead>\n";
        } else if ($this->filter !== null && ($this->filterPosition === self::FILTER_POS_HEADER || $this->filterPosition === self::FILTER_POS_BODY)) {
            echo "<thead>\n";
            $this->renderFilter();
            echo "</thead>\n";
        }
    }

    /**
     * Renders the filter cell.
     * @since 1.1.1
     */
//    public function renderFilterCell() {
//        echo CHtml::openTag('<td colspan = "3">', $this->filterHtmlOptions);
//        $this->renderFilterCellContent();
//        echo "</td>";
//    }
//    if ($this->cssFile !== false) {
//            $url = CHtml::asset(Yii::getPathOfAlias('www') . '/css/pager_trade.css');
//            self::registerCssFile($url);
//        }
}

?>
