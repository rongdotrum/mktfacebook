<?php
class newshome extends CWidget {
    
    public $views = '';             // tên file views hiển thị trong widgets
    public $limit_news = 5;         // số bài viết hiển thị theo chủ đề
    public $limit_newscat = 1;      // số chủ đề hiển thị
    public $newscat = array();      // array cataction trong news_cat - chủ đề tin muốn hiển thị
    public $not_newscat = array();  // array cataction trong news_cat - chủ đề tin không muốn muốn hiển thị

    public function run(){
        if (!empty($this->views)) {
            $criteria = new CDbCriteria();
            if (!empty($this->newscat)) 
            {
                $criteria->addInCondition('CatAction',$this->newscat);
                $criteria->order = 'FIElD(CatAction,"'.implode('","',$this->newscat).'") asc';
            }
            else
                $criteria->limit = $this->limit_newscat;
            if (!empty($this->not_newscat))
                $criteria->addNotInCondition('CatAction',$this->not_newscat);
               // echo $criteria->order;
             //  die;
            $newscat = NewsCat::model()->findAll($criteria);
            
            
            $news = array();
            foreach($newscat as $obj) {
                $news[] = News::model()->findAll(array('condition'=>"CatId=$obj->CatId",'order'=>'DatePost desc','limit'=>$this->limit_news));
            }
            $this->render($this->views,array('newscat'=>$newscat,'news'=>$news));
        }
    }
}  
?>
