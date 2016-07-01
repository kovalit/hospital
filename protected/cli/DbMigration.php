<?php

class DbMigration extends CDbMigration {
	private $tasks = array();

	protected function startTask($task) {
		echo "    > {$task} ...";
		$this->tasks[$task] = microtime(true);
	}

	protected function finishTask($task) {
		if (!isset($this->tasks[$task])) {
			$this->startTask($task);
		}
		echo " done (time: ".sprintf('%.3f', microtime(true) - $this->tasks[$task])."s)\n";
		unset($this->tasks[$task]);
	}

	protected function finishLastTask() {
		if (empty($this->tasks)) {
			return;
		}
		$tasks = array_keys($this->tasks);
		$this->finishTask(end($tasks));
	}
}