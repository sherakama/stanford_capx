<?php
/**
 * @file
 * @author [author] <[email]>
 */

namespace CAPx\Drupal\Util;

use CAPx\APILib\HTTPClient;

use CAPx\Drupal\Util\CAPx;
use CAPx\Drupal\Util\CAPxMapper;
use CAPx\Drupal\Util\CAPxConnection;
use CAPx\Drupal\Importer\EntityImporter;

class CAPxImporter {

  /**
   * Wrapper for capx_cfe_load_multiple(mappers)
   * @return [type] [description]
   */
  public static function loadAllImporters() {
    return capx_cfe_load_multiple(FALSE, array('type' => 'importer'));
  }

  /**
   * Wrapper for capx_cfe_load_by_machine_name & capx_cfe_load
   * @param  [type] $key [description]
   * @return [type]      [description]
   */
  public static function loadImporter($key) {

    if (is_numeric($key)) {
      return capx_cfe_load_multiple($key, array('type' => 'importer'));
    }
    else {
      return capx_cfe_load_by_machine_name($key, 'importer');
    }

  }

  /**
   * [loadEntityImporter description]
   * @param  [type] $key [description]
   * @return [type]      [description]
   */
  public static function loadEntityImporter($key) {

    $importerConfig = self::loadImporter($key);
    $config = $importerConfig->getEntityImporterConfig();

    $mapper = CAPxMapper::loadEntityMapper($importerConfig->mapper);
    $client = CAPxConnection::getAuthenticatedHTTPClient();

    $importer = new EntityImporter($config, $mapper, $client);
    return $importer;
  }

}
