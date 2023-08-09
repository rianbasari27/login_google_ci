<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\YouTube\Resource;

use Google\Service\YouTube\AbuseReport;

/**
 * The "abuseReports" collection of methods.
 * Typical usage is:
 *  <code>
 *   $youtubeService = new Google\Service\YouTube(...);
 *   $abuseReports = $youtubeService->abuseReports;
 *  </code>
 */
class AbuseReports extends \Google\Service\Resource
{
  /**
   * Inserts a new resource into this collection. (abuseReports.insert)
   *
   * @param string|array $part The *part* parameter serves two purposes in this
   * operation. It identifies the properties that the write operation will set as
   * well as the properties that the API response will include.
   * @param AbuseReport $postBody
   * @param array $optParams Optional parameters.
   * @return AbuseReport
   */
  public function insert($part, AbuseReport $postBody, $optParams = [])
  {
    $params = ['part' => $part, 'postBody' => $postBody];
    $params = array_merge($params, $optParams);
    return $this->call('insert', [$params], AbuseReport::class);
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AbuseReports::class, 'Google_Service_YouTube_Resource_AbuseReports');
