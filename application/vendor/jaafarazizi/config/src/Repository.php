<?php namespace JaafarAzizi\Config;

use Illuminate\Config\Repository as RepositoryBase;

class Repository extends RepositoryBase
{
    /**
     * The config rewriter object.
     *
     * @var string
     */
    protected $writer;

    /**
     * Create a new configuration repository.
     *
     * @param  array  $items
     * @param  FileWriter $writer
     * @return void
     */
    public function __construct($items = array(), $writer)
    {
        $this->writer = $writer;
        parent::__construct($items);
    }

    /**
     * Write a given configuration value to file.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function write($filename, $key, $value)
    {
		
        $result = $this->writer->write($key, $value, $this->parseFilename($filename));

        if(!$result) throw new \Exception('File could not be written to');

        $this->set($key, $value);
    }

    /**
     * change . with / or \
     * @param $filename
     * @return string
     */
    private function parseFilename($filename)
    {
        return str_replace('.', DIRECTORY_SEPARATOR, $filename);
    }
}