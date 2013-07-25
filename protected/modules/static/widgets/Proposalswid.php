<?php

    class Proposalswid extends CWidget
    {
        public function init()
        {
            // этот метод будет вызван внутри CBaseController::beginWidget()
        }

        public function run()
        {
            // этот метод будет вызван внутри CBaseController::endWidget()
        }        
        
        public function showleft()
        {
            $model = Proposals::model()->findByPk(1);
            echo $model->data;
        }
    }