<?php

/**
 * 
 * Odaiテーブル
 *
 * @author schiba
 * @since  20190708
 *
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class OdaiTable extends AppTable
{

	public function initialize(array $config)
	{
		// table名セット
		$this->setTable('odai_t');
	}


}
