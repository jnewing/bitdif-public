<?php

namespace lib\BitDif;

use Ramsey\Uuid\Uuid;

class BitDif
{
    /**
     * Get's a filename.
     *
     * @return void
     */
    public static function genFileName(string $ext): array
    {
        // gen a random name
        $rnd_name = explode('-', (string) Uuid::uuid4())[0];

        return [
            'name' => $rnd_name . '.' . $ext,
            'thumb' => $rnd_name . '_thumb.' . $ext,
        ];
    }

    /**
     * Reuturns the max file size.
     *
     * @return integer
     */
    public static function file_upload_max_size(): int
    {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $post_max_size = self::parse_size(ini_get('post_max_size'));

            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = self::parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }

        return $max_size;
    }

    /**
     * Parse a size value from a string.
     *
     * @param [type] $size
     * @return integer
     */
    public static function parse_size($size): int
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.

        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    /**
     * Get the max files that can be uploaded at once.
     *
     * @return integer
     */
    public static function get_max_files(): int
    {
        return (int) ini_get('max_file_uploads');
    }
}
