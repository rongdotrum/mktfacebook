<?php

/**
 * CLinkPager class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CLinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id$
 * @package system.web.widgets.pagers
 * @since 1.0
 */
class GWGLinkPager_News extends CLinkPager {

    public function registerClientScript() {
        if ($this->cssFile !== false) {
            $url = CHtml::asset(Yii::getPathOfAlias('www') . '/css/pager_trade.css');
            self::registerCssFile($url);
        }
    }

    public function run() {
        $this->registerClientScript();
        $buttons = $this->createPageButtons();
        if (empty($buttons))
            return;
        $this->htmlOptions['style'] = 'border-bottom: medium none;';
        echo CHtml::tag('ul', $this->htmlOptions, implode("\n", $buttons));
        echo $this->footer;
    }

}
