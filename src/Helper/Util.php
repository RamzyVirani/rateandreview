<?php

namespace RamzyVirani\RateAndReview\Helper;

class Util
{
    public static function getConfig($suffix)
    {
        return config("rateandreview.fqdn." . $suffix);
    }

    public static function getClassNameFromConfig($suffix)
    {
        return self::getClassNameFromFQDN(self::getConfig($suffix));
    }

    public static function getNameSpaceFromConfig($suffix)
    {
        return self::getNameSpaceFromFQDN(self::getConfig($suffix));
    }

    public static function getClassNameFromFQDN($fqdn)
    {
        return (new \ReflectionClass($fqdn))->getShortName();
    }

    public static function getNameSpaceFromFQDN($fqdn)
    {
        return (new \ReflectionClass($fqdn))->getNamespaceName();
    }

    public static function readCSV($file, $colName = 0)
    {
        $row             = 0;
        $rows            = $columns = [];
        $autoLineEndings = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', TRUE);

        if (($handle = fopen(__DIR__ . '/../assets/' . $file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                if (count($data) <= 1) {
                    $columns[] = $data;
                    continue;
                }
                $row++;
                if ($row == 1) {
                    $columns[] = $data;
                    continue;
                }
                $rows[] = $data;
            }
            fclose($handle);
        }
        ini_set('auto_detect_line_endings', $autoLineEndings);

        if ($colName) {
            return [
                'rows'    => $rows,
                'columns' => $columns
            ];
        } else {
            return $rows;
        }
    }

    public static function seedWithCSV($file)
    {
        $newData = [];
        $data    = self::readCSV($file, 1);

        foreach ($data['rows'] as $key => $row) {
            foreach ($row as $keys => $item) {
                $newData[$key][$data['columns'][0][$keys]] = $item;
            }
        }
        return $newData;
    }
}