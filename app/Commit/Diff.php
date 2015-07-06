<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Commit;

use ArrayAccess;

/**
 * This is the commit diff class.
 *
 * @author Joseph Cohen <joe@alt-three.com>
 */
class Diff implements ArrayAccess
{
    /**
     * The diff splitted files.
     *
     * @var string[]
     */
    protected $files = [];

    /**
     * The count of additions on the diff.
     *
     * @var int
     */
    protected $additions = 0;

    /**
     * The count of deletions on the diff.
     *
     * @var int
     */
    protected $deletions = 0;

    /**
     * Creates a new diff instance.
     *
     * @return void
     */
    public function __construct($diff)
    {
        $this->processDiff($diff);
    }

    /**
     * Get the splitted commit diff files.
     *
     * @return string[]
     */
    public function files()
    {
        return $this->files;
    }

    /**
     * Get the count of additions on the commit diff.
     *
     * @return int
     */
    public function additions()
    {
        return $this->additions;
    }

    /**
     * Get the count of deletions on the commit diff.
     *
     * @return int
     */
    public function deletions()
    {
        return $this->deletions;
    }

    /**
     * Get the count of files on the commit diff.
     *
     * @return int
     */
    public function count()
    {
        return count($this->files);
    }

    /**
     * Process a raw diff patch.
     *
     * @param string $rawDiff
     *
     * @return void
     */
    protected function processDiff($rawDiff)
    {
        $diff = ltrim($rawDiff);

        // We first get the original and modified file names from the diff.
        preg_match_all('/\-\-\-\sa\/(.*?.*)/i', $diff, $originalNames);
        preg_match_all('/\+\+\+\sb\/(.*?.*)/i', $diff, $modifiedNames);

        // Then we count the additions and deletions from the diff.
        preg_match_all('/^\+[^\+]/im', $diff, $additions);
        preg_match_all('/^\-[^\-]/im', $diff, $deletions);

        $this->additions = count($additions[0]);
        $this->deletions = count($deletions[0]);

        $fileNames = [];

        // If the file name was modified we show the change.
        foreach ($originalNames[1] as $key => $originalName) {
            if ($originalName != $modifiedNames[1][$key]) {
                $fileNames[] = $originalName.' -> '.$modifiedNames[1][$key];
            } else {
                $fileNames[] = $originalName;
            }
        }

        // Then we split the diff into files.
        $extractedFiles = preg_split("/(^\s*?diff --git)/m", $diff, -1, PREG_SPLIT_NO_EMPTY);

        // Match file names with files.
        foreach ($extractedFiles as $index => $file) {
            $this->files[$fileNames[$index]] = 'diff --git '.$file;
        }
    }

    /**
     * Set a diff file.
     *
     * @param string $offset
     * @param mixed  $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->files[] = $value;
        } else {
            $this->files[$offset] = $value;
        }
    }

    /**
     * Determine if the given file exists.
     *
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->files[$offset]);
    }

    /**
     * Unset a diff file.
     *
     * @param string $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->files[$offset]);
    }

    /**
     * Get a diff file.
     *
     * @param string $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->files[$offset]) ? $this->files[$offset] : null;
    }
}
