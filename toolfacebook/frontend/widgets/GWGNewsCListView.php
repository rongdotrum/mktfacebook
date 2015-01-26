<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::import('zii.widgets.CListView');

/**
 * Description of GWGNewsCListView
 *
 * @author Admin
 */
class GWGNewsCListView extends CListView {

    public $colums;
    public $headerCssClass;
    public $summaryCssClass = 'numberPage';
    public $pagerCssClass = 'pager_';
    public $template = "{sorter}\n{items}\n{pager}";

    public function renderPager() {
        if (!$this->enablePagination)
            return;

        $pager = array();
        //$class = 'common.widgets.GWGLinkPager_Tradeee';
        if (is_string($this->pager))
            $class = $this->pager;
        else if (is_array($this->pager)) {
            $pager = $this->pager;
            if (isset($pager['class'])) {
                $class = $pager['class'];
                unset($pager['class']);
            }
        }
        $pager['pages'] = $this->dataProvider->getPagination();
        $pager['maxButtonCount'] = 5;
        //$pager['cssFile'] = false;
        if ($pager['pages']->getPageCount() > 1) {

            echo '<div style="margin-top:5px;float:right;" class="pager_">';
            $this->widget('application.widgets.GWGLinkPager_News', $pager);
            echo '</div>';
        }
        else
            $this->widget('application.widgets.GWGLinkPager_News', $pager);
    }

}

?>
