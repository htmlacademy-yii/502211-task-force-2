<?php

namespace TaskForce\Classes\Translation;

use SplFileObject;
use TaskForce\Classes\Exceptions\FileFormatException;
use TaskForce\Classes\Exceptions\SourceFileException;
use TaskForce\Classes\Exceptions\RuntimeException;
use TaskForce\Classes\Exceptions\CreateException;

class CSVToSQLConverter
{
    private  $filename;
    private  $columns;
    private  $fileObject;

    private $result = [];
    private $error = null;

    /**
     * CSVToSQLConverter constructor.
     * @param $filename
     * @param $columns
     */
    public function __construct(string $filename, array $columns)
    {
        $this->filename = $filename;
        $this->columns = $columns;
    }

    public function import():void
    {
        if (!$this->validateColumns($this->columns)) {
            throw new FileFormatException("Заданы неверные заголовки столбцов");
        }

        if (!file_exists($this->filename)) {
            throw new SourceFileException("Файл не существует");
        }

        try {
            $this->fileObject = new SplFileObject($this->filename);
        }
        catch (RuntimeException $exception) {
            throw new SourceFileException("Не удалось открыть файл на чтение");
        }

        // Удаляем символы переноса в конце строки
        // Читаем при использовании функций rewind
        // Пропускаем пустые строки с файле
        // Читаем строки в формате CSV
        $this->fileObject->setFlags(SplFileObject::DROP_NEW_LINE | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::READ_CSV);

        // Получаем название столбцов
        $header_data = implode(', ', $this->getHeaderData());

        if ($header_data !== $this->columns) {
            throw new FileFormatException("Исходный файл не содержит необходимых столбцов");
        }

        // Получаем остальные данные
        $this->result = sprintf("\t(%s)",
            implode(', ',
                array_map(
                    function ($item) {
                        return "'{$item}'";
                    },
                    $this->fileObject->fgetcsv(',')
                )
            )
        );

        // Возвращаеv последний компонент имени из указанного пути
        $newFile = basename($this->filename, '.csv');

        // Создали новый файл
        try {
            $this->fileObject = new SplFileObject("src/db/$newFile.sql", 'w');
        } catch (RuntimeException $exception) {
            throw new CreateException('Не удалось создать или записать в файл');
        }

        // Вписали результат в новый файл
        $this->fileObject->fwrite("INSERT INTO $newFile ($header_data) VALUES $this->result;");
    }

    private function getHeaderData():?array {
        $this->fileObject->rewind();
        $data = $this->fileObject->fgetcsv();

        return $data;
    }

    private function validateColumns(array $columns):bool
    {
        $result = true;

        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    $result = false;
                }
            }
        }
        else {
            $result = false;
        }

        return $result;
    }
}
