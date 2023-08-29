<?php
namespace App;
error_reporting(E_ALL);

class Functions {
  public function extractData($query)
  {

    $extractedData = [];

    $count = count((array)$query);

    $hasNext = true;

    if (!array_key_exists("sorted_item_1", $query) || !array_key_exists("sorted_attendance_1", $query) || !array_key_exists("sorted_unit_1", $query)) {
      throw new \Exception("Component attribute missing");
    };

    $i = $query['sorted_item_1'];
    $att = $query['sorted_attendance_1'];
    $u = $query['sorted_unit_1'];

    for ($nextID = 2; ($nextID <= $count/3 + 1 && $hasNext == true); $nextID++) {

      if (strlen($i) == 0) {
        throw new \Exception("Unlabelled item");
      };

      $attFloat = floatval($att);

      if (is_nan($attFloat)) {
          throw new \Exception("Non-numerical/blank attendance");
      };

      if ($attFloat < 0) {
          throw new \Exception("Negative attendance");
      };

      $thisIndex = $nextID - 2;

      $extractedData[$thisIndex] = array(
        'item' => $i,
        'attendance' => $attFloat,
        'unit' => $u
      );

      if (!array_key_exists("sorted_item_{$nextID}", $query) && !array_key_exists("sorted_attendance_{$nextID}", $query) && !array_key_exists("sorted_unit_{$nextID}", $query)) {

        $hasNext = false;

      } elseif (!array_key_exists("sorted_item_{$nextID}", $query) || !array_key_exists("sorted_attendance_{$nextID}", $query) || !array_key_exists("sorted_unit_{$nextID}", $query)) {

        throw new \Exception("Inconsistent counts of component attributes");

      } else {

        $i = $query["sorted_item_{$nextID}"];
        $att = $query["sorted_attendance_{$nextID}"];
        $u = $query["sorted_unit_{$nextID}"];     

      };

    };

    return $extractedData;
  }

  public function buildResults($extractedData) {

    try {
      $results = array(
        "error" => false,
        "data" => array(
          "max_attendances" => [],
          "min_attendances" => []
        ),
        "lines" => []
      );

      ## clone array
      $count = count($extractedData);

      if ($extractedData[$count-1]['attendance'] > $extractedData[0]['attendance']) {
        throw new \Exception("Data must be sorted in descending order");
      };

      $maxes = [];
      $maxLineHead = "Maximum attendance";
      $maxLines = [];
      $mins = [];
      $minHead = "Minimum attendace";
      $minLines = [];

      for ($index = 0; $index < $count; $index++) {

        if ($index == 0 || $extractedData[$index] == $extractedData[$index-1]) {
          $item = $extractedData[$index]['item'];
          $attendance = $extractedData[$index]['attendance'];
          $unit = $extractedData[$index]['unit'];          
          $maxes[] = $extractedData[$index];
          $maxLines[] = '- '.$item.': '.round($attendance).' '.$unit;
        } else if ($extractedData[$index] < $extractedData[$index-1]) {
          break;
        } else {
          throw new \Exception("Data must be sorted");
        }

      }

      for ($index = $count-1; $index >= 0; $index--) {

        if ($index == $count-1 || $extractedData[$index] == $extractedData[$index+1]) {
          $item = $extractedData[$index]['item'];
          $attendance = $extractedData[$index]['attendance'];
          $unit = $extractedData[$index]['unit'];          
          $mins[] = $extractedData[$index];
          $minLines[] = '- '.$item.': '.round($attendance).' '.$unit;
        } else if ($extractedData[$index] > $extractedData[$index+1]) {
          break;
        } else {
          throw new \Exception("Data must be sorted");
        }

      }

      $results['data']['max_attendances'] = $maxes;
      $results['data']['min_attendances'] = array_reverse($mins);

      if (count($maxLines) == $count) {
        $results['lines'][] = 'All attendances equal';
      } else {

        $maxLineHead += (count($maxLines)>1) ? "s:" : ":";
        $minLineHead += (count($minLines)>1) ? "s:" : ":";

        $results['lines'][] = $maxLineHead;

        foreach ($maxLines as $line) {
          $results['lines'][] = $line;
        }

        $results['lines'][] = $minLineHead;

        $minLines = array_reverse($minLines);

        foreach ($minLines as $line) {
          $results['lines'][] = $line;
        }

      }

    } catch (Exception $e) {
      $results = array(
        "error" => true,
        "message" => $e
      );
    }

    return $results;
  }
};
?>