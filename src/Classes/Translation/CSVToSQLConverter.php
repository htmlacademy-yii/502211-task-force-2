<?php

namespace TaskForce\Classes\Translation;

use SplFileObject;
use TaskForce\Classes\Exceptions\FileFormatException;
use TaskForce\Classes\Exceptions\SourceFileException;
use TaskForce\Classes\Exceptions\RuntimeException;
use TaskForce\Classes\Exceptions\CreateException;

class CSVToSQLConverter
{
    private  $file;
    private  $columns;
    private  $fileObject;

    private $result = [];
    private $error = null;

    /**
     * CSVToSQLConverter constructor.
     * @param $file
     * @param $columns
     */
    public function __construct(string $file, array $columns)
    {
        $this->file = $file;
        $this->filename = basename($file, '.csv');  // возвращает последний компонент имени из указанного пути
        $this->columns = $columns;
    }

    public function import(): void
    {
        if (!$this->validateColumns($this->columns)) {
            throw new FileFormatException("Заданы неверные заголовки столбцов");
        }

        if (!file_exists($this->file)) {
            throw new SourceFileException("Файл $this->filename.csv не существует");
        }

        try {
            $this->fileObject = new SplFileObject($this->file);
        } catch (RuntimeException $exception) {
            throw new SourceFileException("Не удалось открыть файл на чтение");
        }

        $this->fileObject->
            setFlags(
                SplFileObject::DROP_NEW_LINE |  // удаляет символы переноса в конце строки
                SplFileObject::READ_AHEAD |     // читает при использовании функций rewind
                SplFileObject::SKIP_EMPTY |     // пропускает пустые строки с файле
                SplFileObject::READ_CSV         // читает строки в формате CSV
            );

        // Получаем название столбцов
        $header_data = $this->getHeaderData();

        if ($header_data !== $this->columns) {
            throw new FileFormatException("Исходный файл не содержит необходимых столбцов");
        }

        $header_data = implode(', ',
            array_map(
                function ($item) {
                    return "`{$item}`";
                },
                $header_data
            )
        );

        // Получаем остальные данные
        foreach ($this->getNextLine() as $line) {
            if (gettype($line) === 'array') {
                $this->result[] = sprintf(
                    "\t(%s)",
                    implode(', ',
                        array_map(
                            function ($item) {
                                if (is_numeric($item)) {
                                    return "{$item}";
                                }

                                return "'{$item}'";
                            },
                            $line
                        )
                    )
                );
            }
        }

        // Создаем новый файл
        try {
            $this->fileObject = new SplFileObject("src/db/data/$this->filename.sql", 'w');
        } catch (RuntimeException $exception) {
            throw new CreateException('Не удалось создать или записать в файл');
        }

        // Вписываем результат в новый файл
        $this->fileObject->fwrite("INSERT INTO $this->filename ($header_data) VALUES " . implode(', ', $this->result) . ";");
    }

    private function getHeaderData(): ?array
    {
        $data = $this->fileObject->fgetcsv();

        return $data;
    }

    public function getNextLine(): ?iterable
    {
        $result = null;

        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }

        return $result;
    }

    private function validateColumns(array $columns): bool
    {
        $result = true;

        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    $result = false;
                }
            }
        } else {
            $result = false;
        }

        return $result;
    }
}
