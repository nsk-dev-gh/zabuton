<?php

/**
 * 
 * Answerテーブル
 *
 * @author schiba
 * @since  20190708
 *
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class AnswerTable extends AppTable
{

	public function initialize(array $config)
	{
		// table名セット
		$this->setTable('answer_t');
	}


}
