<?php
/** @noinspection PhpUnused */
namespace hexlet;
use Cz\Git\GitException;
use Cz\Git\GitRepository;

//load in git class through composer autoload

/**
 * Class GitHelper
 *   Extends a little bit the git class , so it can be called without figuring out where the repo is and also to get the last commit id
 * @example
[2] boris> $a = new GitHelper();
$a = new GitHelper();
4] boris> $a->getCurrentBranchName();
// 'master'
[5] boris> $a->getCurrentCommit();
// '8b584b7'
[6] boris> $a->hasChanges();
// true

 */

class GitHelper extends GitRepository
{
	public $b_is_git_repo = false;
	function is_repo(): bool
    { return $this->b_is_git_repo;}
	/**
	 * GitHelper constructor.
	 * @param string $file (currently unused)
	 * @throws GitException if repo directory is missing
	 */
	public function __construct($file) {

		$this->b_is_git_repo = false;
		$git_dir = null;
		$dir = dirname($file);
		while($dir && ($dir !== '/')) {
			$test_dir = "$dir/.git";
			if (is_dir($test_dir)) {
				$git_dir = $test_dir;
				$this->b_is_git_repo = true;
				break;
			}
			$dir = realpath($dir. '/..');
		}
		if (!$this->b_is_git_repo) {
			return;
		}
		parent::__construct($git_dir);
	}

	/** @noinspection SpellCheckingInspection */

	/**
	 * gets the full hash of the last commit
	 * @return string
	 * @example  8b584b72a7238a9b6340653738caeb9f7bb409a7e3
	 */
	public function getCurrentCommit(): string
    {

		$this->begin();
		$short_hash = exec('git rev-parse  HEAD');
		$this->end();
		return $short_hash;
	}


	/**
	 * gets the short hash of the last commit
	 * @return string
	 * @example  31353e3
	 */
	public function getCurrentShortCommit(): string
    {

		$this->begin();
		$short_hash = exec('git rev-parse --short HEAD');
		$this->end();
		return $short_hash;
	}
}

