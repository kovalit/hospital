<?php

class RebuildImages extends ConsoleCommand {

	protected static $languageMap = [
		'gr' => 'el', // Greek
		'sp' => 'es', // Spanish
		'jp' => 'ja', // Japanese
	];

	protected function changeLangToISO($languageCode) {
		return in_array($languageCode, array_flip(self::$languageMap))? array_search($languageCode, array_flip(self::$languageMap)): $languageCode;
	}

	public function actionBlog() {
		$this->startTask("Starting rebuilding");

		if (BlogImage::model()
			->count() > 0
		) {
			throw new CException('Warning! Blog image table is not empty.');
		}
		$result = Yii::app()->db
					  ->createCommand()
				  ->select(['pi.id', 'extension ext', 'publication_id postId', 'l.url languageId'])
				  ->from('publications_images pi')
				  ->join('blog b', 'pi.publication_id = b.id')
				  ->leftJoin('locales l', 'pi.locale_id = l.id')
				  ->where('pi.id IN (SELECT MAX(id) FROM publications_images GROUP BY publication_id, locale_id)')
				  ->queryAll();

		$pubsPath = Yii::getPathOfAlias('application.data.images.publications');
		$blogPath = Yii::getPathOfAlias('root.storage.blog');

		foreach ($result as $row) {
			$row['languageId'] = $this->changeLangToISO($row['languageId']);
			$finalDestination  = $blogPath . '/' . $row['postId'] . '/' . $row['languageId'] . '/';

			// copy images to our path
			FSDirectory::create($finalDestination);
			$sourceImage = $pubsPath . '/' . $row['id'] . '.' . $row['ext'];
			if (!file_exists($sourceImage)) {
				continue;
			}
			$hash        = md5(file_get_contents($sourceImage));
			copy($sourceImage, $finalDestination . $hash . '.' . $row['ext']);

			// write images to db
			$blogImage = BlogImage::model()->findByPk($row['id']);

			if ($blogImage && !($imageModel = Image::model()
					->findByPk($blogImage->image->id)) ||
				!($imageModel = Image::model()
					->findByAttributes([
					'hash'        => $hash,
					'storagePath' => 'blog/' . $row['postId'] . '/' . $row['languageId'],
					'ext'         => $row['ext'],
				]))
			) {
				$imageModel              = new Image;
				$imageModel->hash        = $hash;
				$imageModel->storagePath = 'blog/' . $row['postId'] . '/' . $row['languageId'];
				$imageModel->ext         = $row['ext'];
				if (!$imageModel->save()) {
					$this->println('could not save image');
					continue;
				};
			}

			// write relations blog-image to db for default lang
			if (Yii::app()->sourceLanguage == $row['languageId']) {
				$blogImage          = new BlogImage();
				$blogImage->id      = $row['id'];
				$blogImage->postId  = $row['postId'];
				$blogImage->imageId = $imageModel->id;
				$blogImage->isMain  = 1;
				$blogImage->save();
			}
		}

		foreach ($result as $row) {
			$row['languageId'] = $this->changeLangToISO($row['languageId']);
			if (Yii::app()->sourceLanguage != $row['languageId']) {
				/** @var BlogImage $blogImage */
				if (!$blogImage = BlogImage::model()
					->all()
					->multilang()
					->findByAttributes(['postId' => $row['postId']])
				) {
					continue;
				};
				$blogImage->{'imageId_' . $row['languageId']} = $row['id'];
				if (!$blogImage->save()) {
					foreach ($blogImage->errors as $field => $errors) {
						foreach ($errors as $error) {
							$this->println("{$field}: {$error}");
						}
					}
				}
			}
		}

		$this->finishLastTask();
	}

	public function actionUnblog() {
		Yii::app()->db
			->createCommand()
		->delete('blog_image_i18n');
		Yii::app()->db
			->createCommand()
		->delete('blog_image');
	}

	public function actionAcademy() {
		$this->startTask("Starting rebuilding");

		if (AcademyImage::model()
			->count() > 0
		) {
			throw new CException('Warning! Blog image table is not empty.');
		}
		$result = Yii::app()->db
					  ->createCommand()
				  ->select(['pi.id', 'extension ext', 'publication_id postId', 'l.url languageId'])
				  ->from('publications_images pi')
				  ->join('academy b', 'pi.publication_id = b.id')
				  ->leftJoin('locales l', 'pi.locale_id = l.id')
				  ->where('pi.id IN (SELECT MAX(id) FROM publications_images GROUP BY publication_id, locale_id)')
				  ->queryAll();

		$pubsPath = Yii::getPathOfAlias('application.data.images.publications');
		$blogPath = Yii::getPathOfAlias('root.storage.academy');

		foreach ($result as $row) {
			$row['languageId'] = $this->changeLangToISO($row['languageId']);
			$finalDestination  = $blogPath . '/' . $row['postId'] . '/' . $row['languageId'] . '/';

			// copy images to our path
			FSDirectory::create($finalDestination);
			$sourceImage = $pubsPath . '/' . $row['id'] . '.' . $row['ext'];
			if (!file_exists($sourceImage)) {
				continue;
			}
			$hash        = md5(file_get_contents($sourceImage));
			copy($sourceImage, $finalDestination . $hash . '.' . $row['ext']);

			// write images to db
			$blogImage = AcademyImage::model()->findByPk($row['id']);

			if ($blogImage && !($imageModel = Image::model()
					->findByPk($blogImage->image->id)) ||
				!($imageModel = Image::model()
					->findByAttributes([
					'hash'        => $hash,
					'storagePath' => 'academy/' . $row['postId'] . '/' . $row['languageId'],
					'ext'         => $row['ext'],
				]))
			) {
				$imageModel              = new Image;
				$imageModel->hash        = $hash;
				$imageModel->storagePath = 'academy/' . $row['postId'] . '/' . $row['languageId'];
				$imageModel->ext         = $row['ext'];
				if (!$imageModel->save()) {
					$this->println('could not save image');
					continue;
				};
			}

			// write relations blog-image to db for default lang
			if (Yii::app()->sourceLanguage == $row['languageId']) {
				$blogImage          = new AcademyImage();
				$blogImage->postId  = $row['postId'];
				$blogImage->id      = $row['id'];
				$blogImage->imageId = $imageModel->id;
				$blogImage->isMain  = 1;
				$blogImage->save();
			}
		}

		foreach ($result as $row) {
			$row['languageId'] = $this->changeLangToISO($row['languageId']);
			if (Yii::app()->sourceLanguage != $row['languageId']) {
				/** @var AcademyImage $blogImage */
				if(!$blogImage = AcademyImage::model()
							 ->all()
							 ->multilang()
							 ->findByAttributes(['postId' => $row['postId']])) {
					continue;
				};
				$blogImage->{'imageId_' . $row['languageId']} = $row['id'];
				if (!$blogImage->save()) {
					foreach ($blogImage->errors as $field => $errors) {
						foreach ($errors as $error) {
							$this->println("{$field}: {$error}");
						}
					}
				}
			}
		}

		$this->finishLastTask();
	}

	public function actionUnacademy() {
		Yii::app()
			->db
			->createCommand()
			->delete('academy_image_i18n');
		Yii::app()
			->db
			->createCommand()
			->delete('academy_image');
	}

	// here we drop the original ids and use AI ids
	// so u must run blog and academy commands first
	public function actionQuest() {
		$this->startTask("Starting rebuilding");

		$result = Yii::app()->db
					  ->createCommand()
				  ->select(['pi.id', 'extension ext', 'poll_id questId', 'l.url languageId'])
				  ->from('polls_images pi')
				  ->join('quest b', 'pi.poll_id = b.id')
				  ->leftJoin('locales l', 'pi.locale_id = l.id')
				  ->where('pi.id IN (SELECT MAX(id) FROM polls_images GROUP BY poll_id, locale_id)')
				  ->queryAll();

		$pubsPath = Yii::getPathOfAlias('application.data.images.polls');
		$blogPath = Yii::getPathOfAlias('root.storage.quest');

		$imageIds = [];
		foreach ($result as $row) {
			$row['languageId'] = $this->changeLangToISO($row['languageId']);
			$finalDestination  = $blogPath . '/' . $row['questId'] . '/' . $row['languageId'] . '/';

			// copy images to our path
			FSDirectory::create($finalDestination);
			$sourceImage = $pubsPath . '/' . $row['id'] . '.' . $row['ext'];
			if (!file_exists($sourceImage)) {
				continue;
			}
			$hash        = md5(file_get_contents($sourceImage));
			copy($sourceImage, $finalDestination . $hash . '.' . $row['ext']);
			$storagePath = 'quest/' . $row['questId'] . '/' . $row['languageId'];

			// write images to db
			if (!$imageModel = Image::model()
							   ->findByAttributes(['hash' => $hash, 'storagePath' => $storagePath, 'ext' => $row['ext']])
			) {
				$imageModel = new Image;
//				$imageModel->id = $row['id'];
				$imageModel->hash        = $hash;
				$imageModel->storagePath = $storagePath;
				$imageModel->ext         = $row['ext'];
				if (!$imageModel->save()) {
					$this->println('could not save image');
					continue;
				};
			}

			// write relations blog-image to db for default lang
			if (Yii::app()->sourceLanguage == $row['languageId']) {
				$questImage = Quest::model()
							  ->all()
							  ->multilang()
							  ->findByPk($row['questId']);
//				$questImage->questId = $row['questId'];
				$questImage->imageId = $imageModel->id;
				$questImage->save();
			}
			$imageIds[$row['questId']][$row['languageId']] = $imageModel->id;
		}

		foreach ($result as $row) {
			$row['languageId'] = $this->changeLangToISO($row['languageId']);
			if (Yii::app()->sourceLanguage != $row['languageId']) {
				// if for some reason file does not exist in first scope, it won't be added to an array
				// so we must check whether key was not added imageIds array
				if (!(isset($imageIds[$row['questId']]) && isset($imageIds[$row['questId']][$row['languageId']]))) {
					continue;
				}

				/** @var Quest $questImage */
				$questImage = Quest::model()
							  ->all()
							  ->multilang()
							  ->findByPk($row['questId']);

				$questImage->{'imageId_' . $row['languageId']} = $imageIds[$row['questId']][$row['languageId']];
				if (!$questImage->save()) {
					foreach ($questImage->errors as $field => $errors) {
						foreach ($errors as $error) {
							$this->println("{$field}: {$error}");
						}
					}
				}
			}
		}

		$this->finishLastTask();
	}

	/**
	 * author images must be in /public/images.authors folder
	 */
	public function actionAuthors() {
		$this->startTask("Starting rebuilding");

		$result = Yii::app()->db
					  ->createCommand()
				  ->select(['pa.id authorId', 'pa.avatar_src avaSrc'])
				  ->from('publications_authors pa')
				  ->queryAll();

		// remember that author $row['avaSrc'] contains FULL PATH so we use /data/ folder as pubs path
		$pubsPath   = Yii::getPathOfAlias('application.data');
		$imagesPath = Yii::getPathOfAlias('root') . '/storage/author/';

		foreach ($result as $row) {
			// copy images to our path
			$sourceImage = $pubsPath . $row['avaSrc'];
			if (!file_exists($sourceImage)) {
				continue;
			}

			$finalDestination = $imagesPath . '/' . $row['authorId'] . '/';
			FSDirectory::create($finalDestination);

			$ext  = substr($row['avaSrc'], strrpos($row['avaSrc'], '.') + 1);
			$hash = md5(file_get_contents($sourceImage));
			copy($sourceImage, $finalDestination . $hash . '.' . $ext);
			$storagePath = 'author/' . $row['authorId'] . '/';

			// write images to db
			if (($imageModel = Image::model()->findByAttributes(['hash' => $hash, 'storagePath' => $storagePath, 'ext' => $ext])) === null) {
				$imageModel              = new Image();
				$imageModel->hash        = $hash;
				$imageModel->storagePath = $storagePath;
				$imageModel->ext         = $ext;
				if (!$imageModel->save()) {
					$this->println('could not save image');
					continue;
				};
			}

			/** @var Author $author */
			$author = Author::model()->all()->findByPk($row['authorId']);
			$author->avatarId = $imageModel->id;
			if (!$author->save()) {
				foreach ($author->errors as $field => $errors) {
					foreach ($errors as $error) {
						$this->println("{$field}: {$error}");
					}
				}
			}
		}

		$this->finishLastTask();
	}
}
