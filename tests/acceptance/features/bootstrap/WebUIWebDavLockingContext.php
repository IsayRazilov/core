<?php
/**
 * ownCloud
 *
 * @author Artur Neumann <artur@jankaritech.com>
 * @copyright Copyright (c) 2017 Artur Neumann artur@jankaritech.com
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License,
 * as published by the Free Software Foundation;
 * either version 3 of the License, or any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>
 *
 */

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Page\FilesPage;
use Page\SharedWithYouPage;

require_once 'bootstrap.php';

/**
 * context containing webUI steps needed for the locking mechanism of webdav
 */
class WebUIWebDavLockingContext extends RawMinkContext implements Context {

	/**
	 *
	 * @var FilesPage
	 */
	private $filesPage;

	/**
	 *
	 * @var SharedWithYouPage
	 */
	private $sharedWithYouPage;
	/**
	 *
	 * @var FeatureContext
	 */
	private $featureContext;

	/**
	 *
	 * @var WebUIGeneralContext
	 */
	private $webUIGeneralContext;

	private $uploadConflictDialogTitle = "file conflict";

	/**
	 * WebUIFilesContext constructor.
	 *
	 * @param FilesPage $filesPage
	 * @param SharedWithYouPage $sharedWithYouPage
	 *
	 * @return void
	 */
	public function __construct(
		FilesPage $filesPage,
		SharedWithYouPage $sharedWithYouPage
	) {
		$this->filesPage = $filesPage;
		$this->sharedWithYouPage = $sharedWithYouPage;
	}

	/**
	 * @Then the file/folder :file should be marked as locked on the webUI
	 */
	public function theFolderShouldBeMarkedAsLockedOnTheWebui($file) {
		$fileRow = $this->filesPage->findFileRowByName($file, $this->getSession());
		PHPUnit_Framework_Assert::assertTrue($fileRow->getLockState());
	}

	/**
	 * @Then the file/folder :file should not be marked as locked on the webUI
	 */
	public function theFolderShouldNotBeMarkedAsLockedOnTheWebui($file) {
		$fileRow = $this->filesPage->findFileRowByName($file, $this->getSession());
		PHPUnit_Framework_Assert::assertFalse($fileRow->getLockState());
	}
	
	/**
	 * @Then the folder :file should be marked as locked by user :lockedBy in the locks tab of the details panel on the webUI
	 */
	public function theFolderShouldBeMarkedAsLockedByUserInLocksTab(
		$file, $lockedBy
	) {
		$fileRow = $this->filesPage->findFileRowByName($file, $this->getSession());
		$lockDialog = $fileRow->openLockDialog();
		$lockDialog->getAllLocks();
	}
	
}
