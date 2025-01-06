<?php
namespace Opencart\Admin\Model\Design;
/**
 * Class Translation
 *
 * Can be loaded using $this->load->model('design/translation');
 *
 * @package Opencart\Admin\Model\Design
 */
class Translation extends \Opencart\System\Engine\Model {
	/**
	 * Add Translation
	 *
	 * @param array<string, mixed> $data array of data
	 *
	 * @return void
	 *
	 * @example
	 *
	 * $this->model_design_translation->addTranslation($data);
	 */
	public function addTranslation(array $data): void {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "translation` SET `store_id` = '" . (int)$data['store_id'] . "', `language_id` = '" . (int)$data['language_id'] . "', `route` = '" . $this->db->escape((string)$data['route']) . "', `key` = '" . $this->db->escape((string)$data['key']) . "', `value` = '" . $this->db->escape((string)$data['value']) . "', `date_added` = NOW()");
	}

	/**
	 * Edit Translation
	 *
	 * @param int                  $translation_id primary key of the translation record
	 * @param array<string, mixed> $data           array of data
	 *
	 * @return void
	 *
	 * @example
	 *
	 * $this->model_design_translation->editTranslation($translation_id, $data);
	 */
	public function editTranslation(int $translation_id, array $data): void {
		$this->db->query("UPDATE `" . DB_PREFIX . "translation` SET `store_id` = '" . (int)$data['store_id'] . "', `language_id` = '" . (int)$data['language_id'] . "', `route` = '" . $this->db->escape((string)$data['route']) . "', `key` = '" . $this->db->escape((string)$data['key']) . "', `value` = '" . $this->db->escape((string)$data['value']) . "' WHERE `translation_id` = '" . (int)$translation_id . "'");
	}

	/**
	 * Delete Translation
	 *
	 * @param int $translation_id primary key of the translation record
	 *
	 * @return void
	 *
	 * @example
	 *
	 * $this->model_design_translation->deleteTranslation($translation_id);
	 */
	public function deleteTranslation(int $translation_id): void {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "translation` WHERE `translation_id` = '" . (int)$translation_id . "'");
	}

	/**
	 * Delete Translations By Store ID
	 *
	 * @param int $store_id primary key of the store record
	 *
	 * @return void
	 *
	 * @example
	 *
	 * $this->model_design_translation->deleteTranslationsByStoreId($store_id);
	 */
	public function deleteTranslationsByStoreId(int $store_id): void {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "translation` WHERE `store_id` = '" . (int)$store_id . "'");
	}

	/**
	 * Delete Translations By Language ID
	 *
	 * @param int $language_id primary key of the language record
	 *
	 * @return void
	 *
	 * @example
	 *
	 * $this->model_design_translation->deleteTranslationsByLanguageId($language_id);
	 */
	public function deleteTranslationsByLanguageId(int $language_id): void {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "translation` WHERE `language_id` = '" . (int)$language_id . "'");
	}

	/**
	 * Get Translation
	 *
	 * @param int $translation_id primary key of the translation record
	 *
	 * @return array<string, mixed> translation record that has translation ID
	 *
	 * @example
	 *
	 * $translation_info = $this->model_design_translation->getTranslation($translation_id);
	 */
	public function getTranslation(int $translation_id): array {
		$query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "translation` WHERE `translation_id` = '" . (int)$translation_id . "'");

		return $query->row;
	}

	/**
	 * Get Translations
	 *
	 * @param array<string, mixed> $data array of filters
	 *
	 * @return array<int, array<string, mixed>> translation records
	 *
	 * @example
	 *
	 * $results = $this->model_design_translation->getTranslations();
	 */
	public function getTranslations(array $data = []): array {
		$sql = "SELECT *, (SELECT `s`.`name` FROM `" . DB_PREFIX . "store` `s` WHERE `s`.`store_id` = `t`.`store_id`) AS `store`, (SELECT `l`.`name` FROM `" . DB_PREFIX . "language` `l` WHERE `l`.`language_id` = `t`.`language_id`) AS `language` FROM `" . DB_PREFIX . "translation` `t`";

		$sort_data = [
			'store',
			'language',
			'route',
			'key',
			'value'
		];

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY store";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	/**
	 * Get Total Translations
	 *
	 * @return int total number of translation records
	 *
	 * @example
	 *
	 * $translation_total = $this->model_design_translation->getTotalTranslations();
	 */
	public function getTotalTranslations(): int {
		$query = $this->db->query("SELECT COUNT(*) AS `total` FROM `" . DB_PREFIX . "translation`");

		return (int)$query->row['total'];
	}
}
