<?php

class ConsoleCommand extends CConsoleCommand {
	private $tasks = array();
	private $silentMode = false;

	protected function startTask($task) {
		$this->prints("    > {$task} ...");
		$this->tasks[$task] = microtime(true);
	}

	protected function finishTask($task) {
		if (!isset($this->tasks[$task])) {
			$this->startTask($task);
		}
		$this->println(" done (time: ".sprintf('%.3f', microtime(true) - $this->tasks[$task])."s)");
		unset($this->tasks[$task]);
	}

	protected function finishLastTask() {
		if (empty($this->tasks)) {
			return;
		}
		$tasks = array_keys($this->tasks);
		$this->finishTask(end($tasks));
	}

	// 'prints' because 'print' is reserved word :-/
	protected function prints($text) {
		if (!$this->silentMode) {
			echo $text;
		}
	}

	/**
	 * @param string $data
	 */
	protected function println($data) {
		$this->prints($data . "\n");
	}

	public function enableSilentMode() {
		$this->silentMode = true;
	}

	public function disableSilentMode() {
		$this->silentMode = false;
	}

	public function isSilentMode() {
		return $this->silentMode;
	}
}
